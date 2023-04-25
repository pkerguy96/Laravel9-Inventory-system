<?php

namespace App\Http\Controllers\sop;

use Illuminate\Support\Facades\DB;
use App\Events\ProductQuantityUpdated;
use Illuminate\Support\Facades\Cache;
use App\Models\Payement;
use App\Models\PayementDetail;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    public function AllInvoices()
    {
        try {
            $allinvoices = Invoice::orderby('date', 'desc')->orderby('id', 'desc')->where('status', '1')->get();
            return view('backend.Invoices.all_invoices', compact(('allinvoices')));
        } catch (\Exception $e) {
            Log::error('AllInvoices function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function AddInvoices()
    {
        try {
            $invoice_no = generateInvoiceNumber();
            $date = date('Y-m-d');
            $categories = Category::all();
            $customers = Customer::all();
            $brands = Brand::all();
            return view('backend.Invoices.Add_Invoices', compact('invoice_no', 'date', 'categories', 'customers', 'brands'));
        } catch (\Exception $e) {
            Log::error('AddInvoices function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function storeInvoices(Request $request)
    {
        try {
            if (empty($request->category_id) || empty($request->pay_status) || empty($request->customer_id)   || empty($request->product_id) || empty($request->delivery_id)) {
                $errorMessage = (empty($request->category_id)) ? "Please select a category. " : "";
                $errorMessage .= (empty($request->pay_status)) ? "Please select a payment status. " : "";
                $errorMessage .= (empty($request->customer_id)) ? "Please select a customer. " : "";
                $errorMessage .= (empty($request->product_id)) ? "Please select a product. " : "";
                $errorMessage .= (empty($request->delivery_id)) ? "Please select a delivery method. " : "";
                $notification = InsertNotification($errorMessage, 'error');
                return redirect()->back()->with($notification);
            } else {
                if ($request->paid_amount > $request->Gtotal) {
                    $notification = InsertNotification('Partial Payement is greater then total please check again', 'error');
                    return redirect()->back()->with($notification);
                } else {
                    $invoice = new Invoice();
                    $invoice->customer_id = $request->customer_id;
                    $invoice->delivery_id = $request->delivery_id;
                    $invoice->invoice_no = $request->invoice_no;
                    $invoice->date = date('Y-m-d', strtotime($request->date));
                    $invoice->due_date = date('Y-m-d', strtotime($request->due_date));
                    $invoice->description = $request->description;
                    $invoice->status = '0';
                    $invoice->created_by = Auth::user()->id;

                    /* make sure invoice saved no errors then insert on others */
                    DB::transaction(function () use ($request, $invoice) {
                        if ($invoice->save()) {
                            $category_count = count($request->category_id);
                            for ($i = 0; $i < $category_count; $i++) {
                                $invoice_details = new InvoiceDetail();
                                $invoice_details->invoice_id = $invoice->id;
                                $invoice_details->date = date('Y-m-d', strtotime($request->date));
                                $invoice_details->category_id = $request->category_id[$i];
                                $invoice_details->product_id = $request->product_id[$i];
                                $invoice_details->qte = $request->qte[$i];
                                $invoice_details->brand_id = $request->brand_id[$i];
                                $invoice_details->unit_price = $request->unit_price[$i];
                                $invoice_details->selling_price = $request->selling_pricerd[$i];
                                $invoice_details->status = '0';
                                $invoice_details->save();
                            }
                            $customerid = $request->customer_id;

                            /* Add customer id in the invoice table after its created */
                            invoice::findorfail($invoice->id)->update(['customer_id' => $customerid]);
                            $payements = new Payement();
                            $payements_details = new PayementDetail();
                            $payements->invoice_id = $invoice->id;
                            $payements->customer_id = $customerid;
                            $payements->pay_status = $request->pay_status;
                            $payements->discount_amount = $request->discount_amount;
                            $total_amount_with_tax =  CalculateGrandTotal($request->selling_pricerd, $request->discount_amount, 20);
                            $payements->total_amount =  $total_amount_with_tax['grand_total'];
                            if ($request->pay_status == 'full_paid') {
                                $payements->paid_amount =  $total_amount_with_tax['grand_total'];
                                $payements->due_amount = '0';
                                $payements_details->paid_amount_current = $total_amount_with_tax['grand_total'];
                            } elseif ($request->pay_status == 'full_due') {
                                $payements->paid_amount = '0';
                                $payements->due_amount = $total_amount_with_tax['grand_total'];
                                $payements_details->paid_amount_current = '0';
                            } elseif ($request->pay_status == 'partial_paid') {
                                $payements->paid_amount = $request->paid_amount;
                                $payements->due_amount = $total_amount_with_tax['grand_total'] - $request->paid_amount;
                                $payements_details->paid_amount_current = $request->paid_amount;
                            }
                            $payements->save();
                            $payements_details->invoice_id = $invoice->id;
                            $payements_details->date = date('Y-m-d', strtotime($request->date));
                            $payements_details->save();
                        }
                    });
                }
            }
            $notification = InsertNotification('Invoice Data inserted Successfuly', 'sucess');
            return redirect()->route('all.invoices')->with($notification);
        } catch (\Exception $e) {
            Log::error('storeInvoices function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function PendingInvoices()
    {
        try {
            $allinvoices = Invoice::orderby('date', 'desc')->orderby('id', 'desc')->where('status', '0')->get();
            return view('backend.Invoices.Pending_invoices', compact(('allinvoices')));
        } catch (\Exception $e) {
            Log::error('PendingInvoices function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }

    public function DeleteInvoices($id)
    {
        try {
            $invoiceinfo = invoice::findorfail($id);
            $invoiceinfo->delete();
            InvoiceDetail::where('invoice_id', $id)->delete();
            Payement::where('invoice_id', $id)->delete();
            PayementDetail::where('invoice_id', $id)->delete();
            $notification = InsertNotification('Invoice Deleted Successfuly', 'info');
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            Log::error('DeleteInvoices function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function ApproveInvoices($id)
    {
        try {
            $payement = Payement::where('invoice_id', $id)->first();
            $invoice = Invoice::with('InvoiceDetails')->findorfail($id);
            return view('backend.Invoices.Approved_invoices', compact('invoice', 'payement'));
        } catch (\Exception $e) {
            Log::error('ApproveInvoices function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function AcceptInvoices(request $request, $id)
    {
        try {
            /* dashboard kpis cache reset */
            Cache::forget('invoices');
            Cache::forget('neworders');
            Cache::forget('outofstock');
            Cache::forget('invoice');
            Cache::forget('total_sales_calculation');
            Cache::forget('total_order_calculation');

            foreach ($request->qte as $key => $value) {
                $invoiceDetails = InvoiceDetail::where('id', $key)->first();
                $product = Product::where('id', $invoiceDetails->product_id)->first();
                if ($product->product_qte < $request->qte[$key]) {
                    $notification = InsertNotification('Oops Not Enought Product Quantity Please check the stock', 'error');
                    return redirect()->back()->with($notification);
                }
                $invoice = invoice::findorfail($id);
                $invoice->status = '1';
                $invoice->updated_by = Auth::user()->id;
                DB::transaction(function () use ($request, $invoice, $id) {
                    foreach ($request->qte as $key => $value) {
                        $invoiceDetails = InvoiceDetail::where('id', $key)->first();
                        $invoiceDetails->status = '1';
                        $invoiceDetails->save();
                        $product = Product::where('id', $invoiceDetails->product_id)->first();
                        $product->product_qte = ((float)$product->product_qte) - ((float)$request->qte[$key]);
                        event(new ProductQuantityUpdated($product));
                        $product->save();;
                    }
                    $invoice->save();
                });
                $notification = InsertNotification('Invoice Approved Successfully', 'success');
                return redirect()->route('all.pending.invoices')->with($notification);
            }
        } catch (\Exception $e) {
            Log::error('AcceptInvoices function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }

    /* Invoice details for admins */
    public function PrintInvoice($id)
    {
        try {
            $invoice = Invoice::with('InvoiceDetails')->findorfail($id);
            return view('backend.pdfs.invoice_pdf', compact(('invoice')));
        } catch (\Exception $e) {
            Log::error('PrintInvoice function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    /* Printing invoice details for clients */
    public function PrintClientInvoice($id)
    {
        try {
            $payement = Payement::where('invoice_id', $id)->first();
            $invoice = Invoice::with('InvoiceDetails')->findorfail($id);
            return view('backend.pdfs.Client_invoice_pdf', compact('invoice', 'payement'));
        } catch (\Exception $e) {
            Log::error('PrintClientInvoice function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function DailyInvoicePage()
    {
        return view('backend.Invoices.daily_report');
    }
    public function SearchByDateInvoice(request $request)
    {
        try {
            $startdate = date('Y-m-d', strtotime($request->startdate));
            $enddate = date('Y-m-d', strtotime($request->enddate));
            $data = Invoice::whereBetween('date', [$startdate, $enddate])->where('status', '1')->get();
            return view('backend.pdfs.date_invoice_pdf', compact('data', 'startdate', 'enddate'));
        } catch (\Exception $e) {
            Log::error('SearchByDateInvoice function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
}
