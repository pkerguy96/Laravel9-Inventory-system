<?php

namespace App\Http\Controllers\sop;

use Illuminate\Support\Facades\DB;

use App\Models\Payement;
use App\Models\PayementDetail;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function AllInvoices()
    {
        $allinvoices = Invoice::orderby('date', 'desc')->orderby('id', 'desc')->where('status', '1')->get();
        return view('backend.Invoices.all_invoices', compact(('allinvoices')));
    }
    public function AddInvoices()
    {

        $invoice_no = generateInvoiceNumber();

        $date = date('Y-m-d');
        $categories = Category::all();
        $customers = Customer::all();
        $brands = Brand::all();
        return view('backend.Invoices.Add_Invoices', compact('invoice_no', 'date', 'categories', 'customers', 'brands'));
    }
    public function storeInvoices(Request $request)
    {
        if ($request->category_id == null || $request->pay_status == null || $request->customer_id == null) {
            $notification = array(
                'message' => 'please select category',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {
            if ($request->paid_amount > $request->amount) {
                $notification = array(
                    'message' => 'Partial Payement is greater then total please check again',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            } else {
                $invoice = new Invoice();
                $invoice->invoice_no = $request->invoice_no;
                $invoice->date = date('Y-m-d', strtotime($request->date));
                $invoice->description = $request->description;
                $invoice->status = '0';
                $invoice->created_by = Auth::user()->id;

                /* make sure invoice saved no errors then insert on others */
                DB::transaction(function () use ($request, $invoice) {
                    if ($invoice->save()) {
                        $category_count = count($request->category_id);
                        for ($i = 0; $i < $category_count; $i++) {
                            $tax = calculatetax($request->selling_price[$i]);
                            $invoice_details = new InvoiceDetail();
                            $invoice_details->invoice_id = $invoice->id;
                            $invoice_details->date = date('Y-m-d', strtotime($request->date));
                            $invoice_details->category_id = $request->category_id[$i];
                            $invoice_details->product_id = $request->product_id[$i];
                            $invoice_details->qte = $request->qte[$i];
                            $invoice_details->brand_id = $request->brand_id[$i];
                            $invoice_details->tax_amount = calculatetax($request->selling_price[$i]);
                            $invoice_details->unit_price = $request->unit_price[$i];
                            $invoice_details->selling_price = $request->selling_price[$i];
                            $invoice_details->grand_total = CalculateGrandAmount($request->selling_price[$i], $tax);
                            $invoice_details->status = '0';

                            $invoice_details->save();
                        }

                        if ($request->customer_id == '0') {
                            $newcustomer = new Customer();
                            $newcustomer->name = $request->name;
                            $newcustomer->phone = $request->phone;
                            $newcustomer->email = $request->email;

                            $newcustomer->created_by = Auth::user()->id;
                            $newcustomer->save();
                            $customerid = $newcustomer->id;
                        } else {
                            $customerid = $request->customer_id;
                        }
                        /* Add customer id in the invoice table after its created */
                        invoice::findorfail($invoice->id)->update(['customer_id' => $customerid]);
                        $payements = new Payement();
                        $payements_details = new PayementDetail();
                        $payements->invoice_id = $invoice->id;
                        $payements->customer_id = $customerid;
                        $payements->pay_status = $request->pay_status;
                        $payements->discount_amount = $request->discount_amount;
                        $payements->total_amount = $request->amount;
                        if ($request->pay_status == 'full_paid') {
                            $payements->paid_amount = $request->amount;
                            $payements->due_amount = '0';
                            $payements_details->paid_amount_current = $request->amount;
                        } elseif ($request->pay_status == 'full_due') {
                            $payements->paid_amount = '0';
                            $payements->due_amount = $request->amount;;
                            $payements_details->paid_amount_current = '0';
                        } elseif ($request->pay_status == 'partial_paid') {
                            $payements->paid_amount = $request->paid_amount;
                            $payements->due_amount = $request->amount - $request->paid_amount;
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
        $notification = array(
            'message' => 'Invoice Data inserted Successfuly',
            'alert-type' => 'success'
        );
        return redirect()->route('all.invoices')->with($notification);
    }
    public function PendingInvoices()
    {
        $allinvoices = Invoice::orderby('date', 'desc')->orderby('id', 'desc')->where('status', '0')->get();
        return view('backend.Invoices.Pending_invoices', compact(('allinvoices')));
    }

    public function DeleteInvoices($id)
    {
        $invoiceinfo = invoice::findorfail($id);
        $invoiceinfo->delete();
        InvoiceDetail::where('invoice_id', $id)->delete();
        Payement::where('invoice_id', $id)->delete();
        PayementDetail::where('invoice_id', $id)->delete();
        $notification = array(
            'message' => 'Invoice Deleted Successfuly',
            'alert-type' => 'sucess'
        );
        return redirect()->back()->with($notification);
    }
    public function ApproveInvoices($id)
    {
        $invoice = Invoice::with('InvoiceDetails')->findorfail($id);
        return view('backend.Invoices.Approved_invoices', compact(('invoice')));
    }
    public function AcceptInvoices(request $request, $id)
    {
        foreach ($request->qte as $key => $value) {
            $invoiceDetails = InvoiceDetail::where('id', $key)->first();
            $product = Product::where('id', $invoiceDetails->product_id)->first();
            if ($product->product_qte < $request->qte[$key]) {
                $notification = array(
                    'message' => 'Oops Not Enought Product Quantity Please check the stock',
                    'alert-type' => 'error'
                );
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
                    $product->save();
                }
                $invoice->save();
            });
            $notification = array(
                'message' => 'Invoice Approved Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.pending.invoices')->with($notification);
        }
    }
    public function PrintInvoicePage()
    {
        $allinvoices = Invoice::orderby('date', 'desc')->orderby('id', 'desc')->where('status', '1')->get();
        return view('backend.Invoices.Print_invoices', compact(('allinvoices')));
    }
    /* Invoice details for admins */
    public function PrintInvoice($id)
    {
        $invoice = Invoice::with('InvoiceDetails')->findorfail($id);
        return view('backend.pdfs.invoice_pdf', compact(('invoice')));
    }
    /* Printing invoice details for clients */
    public function PrintClientInvoice($id)
    {
        $invoice = Invoice::with('InvoiceDetails')->findorfail($id);
        return view('backend.pdfs.Client_invoice_pdf', compact(('invoice')));
    }
    public function DailyInvoicePage()
    {
        return view('backend.Invoices.daily_report');
    }
    public function SearchByDateInvoice(request $request)
    {
        $startdate = date('Y-m-d', strtotime($request->startdate));
        $enddate = date('Y-m-d', strtotime($request->enddate));
        $data = Invoice::whereBetween('date', [$startdate, $enddate])->where('status', '1')->get();


        return view('backend.pdfs.date_invoice_pdf', compact('data', 'startdate', 'enddate'));
    }
}
