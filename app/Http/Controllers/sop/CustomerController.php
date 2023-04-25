<?php

namespace App\Http\Controllers\sop;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Imports\CustomersImport;
use App\Models\Invoice;
use App\Models\Payement;
use App\Models\PayementDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /* function that grabs all the customers */
    public function Allcustomers()
    {
        try {
            $customers = Customer::latest()->get();
            return view('backend.customers.allcustomers', compact(('customers')));
        } catch (\Exception $e) {
            Log::error('Allcustomers function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    /* redirects to customer page to add it  */
    public function AddCustomer()
    {
        return view('backend.customers.Add_customer');
    }
    /* adds customer in DB */
    public function StoreCustomer(Request $request)
    {
        try {
            if ($request->hasFile('customers_csv')) {
                /* dashboard kpis cache reset */
                Cache::forget('totalcustomers');
                $import = new CustomersImport();
                Excel::import($import, $request->file('customers_csv'));
                $dupscount = $import->duplicatesrow();
                if ($dupscount > 0) {
                    $notification = InsertNotification($dupscount . ' Customers Were Skipped The Rest Is  Imported Successfuly', 'info');
                } else {
                    $notification = InsertNotification('Customers Imported Successfuly', 'success');
                }
                return redirect()->route('all.customers')->with($notification);
            } else {
                Cache::forget('totalcustomers');
                Cache::forget('total_customers_calculation');
                Customer::insert([
                    'name' =>  $request->name,
                    'phone' =>  $request->phone,
                    'address' =>  $request->address,
                    'email' =>  $request->email,
                    'ice' =>  $request->ice,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
                $notification = InsertNotification('Customer Added Successfully', 'success');
                return redirect()->route('all.customers')->with($notification);
            }
        } catch (\Exception $e) {
            Log::error('StoreCustomer function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    /* redirects to customer page to modify it  */
    public function EditCustomer($id)
    {
        try {
            $customerinfo = Customer::findorfail($id);
            return view('backend.customers.Edit_customer', compact("customerinfo"));
        } catch (\Exception $e) {
            Log::error('EditCustomer function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function ModifyCustomer(request $request)
    {
        try {
            $id = $request->supplierId;
            Customer::findorfail($id)->update([
                'name' =>  $request->name,
                'phone' =>  $request->phone,
                'address' =>  $request->address,
                'email' =>  $request->email,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = InsertNotification('Customer Modified Successfully', 'success');
            return redirect()->route('all.customers')->with($notification);
        } catch (\Exception $e) {
            Log::error('ModifyCustomer function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function DeleteCustomer($id)
    {
        try {
            Cache::forget('totalcustomers');
            Cache::forget('total_customers_calculation');
            Customer::findorfail($id)->delete();
            $notification = InsertNotification('Customer Deleted Successfully', 'info');
            return redirect()->route('all.customers')->with($notification);
        } catch (\Exception $e) {
            Log::error('DeleteCustomer function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function CustomersCredit()
    {
        try {
            $data = Payement::whereIn('pay_status', ['full_due', 'partial_paid'])->get();
            return view('backend.customers.Customers_CreditInfo', compact(('data')));
        } catch (\Exception $e) {
            Log::error('CustomersCredit function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function CustomersPrintPdf()
    {
        try {
            $data = Payement::whereIn('pay_status', ['full_due', 'partial_paid'])->get();
            return view('backend.pdfs.Customers_pdf', compact(('data')));
        } catch (\Exception $e) {
            Log::error('CustomersPrintPdf function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function EditCustomersInvoice($inv_id)
    {
        try {
            $invoice = Invoice::with('InvoiceDetails')->where('id', $inv_id)->first();
            $payements  = Payement::where('invoice_id', $inv_id)->first();
            return view('backend.customers.Customers_edit_invoice', compact('payements', 'invoice'));
        } catch (\Exception $e) {
            Log::error('EditCustomersInvoice function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function UpdateCustomerPayement(request $request, $inv_id)
    {
        try {
            if ($request->dueamount < $request->pay_amount || $request->pay_amount <= 0) {
                $notification = InsertNotification('Please Re-Check the Payement Amount', 'error');
                return redirect()->back()->with($notification);
            } else {
                $payement_data = Payement::where('invoice_id', $inv_id)->first();
                $payement_details = new PayementDetail();
                $payement_data->pay_status = $request->pay_status;
                if ($request->pay_status == 'full_paid') {
                    $payement_data->paid_amount =  Payement::where('invoice_id', $inv_id)->first()['paid_amount'] + $request->pay_amount;
                    $payement_data->due_amount = '0';
                    $payement_details->paid_amount_current = $request->pay_amount;
                } elseif ($request->pay_status == 'partial_paid') {
                    $payement_data->paid_amount = Payement::where('invoice_id', $inv_id)->first()['paid_amount'] + $request->pay_amount;
                    $payement_data->due_amount = Payement::where('invoice_id', $inv_id)->first()['due_amount'] - $request->pay_amount;
                    $payement_details->paid_amount_current = $request->pay_amount;
                }
                $payement_data->save();
                $payement_details->invoice_id =  $inv_id;
                $payement_details->date = date('y-m-d', strtotime($request->date));
                $payement_details->updated_by = Auth::user()->id;
                $payement_details->save();

                $notification = InsertNotification('Invoice Updated Successfully', 'success');

                return redirect()->route('customers.credit')->with($notification);
            }
        } catch (\Exception $e) {
            Log::error('UpdateCustomerPayement function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function InvoicesDetailsCustomers($inv_id)
    {
        try {
            $Pdetails = PayementDetail::where('invoice_id', $inv_id)->get();
            $invoice = Invoice::with('InvoiceDetails')->where('id', $inv_id)->first();
            $payement = Payement::where('invoice_id', $inv_id)->first();
            return view('backend.pdfs.customer_invoices_detail', compact('payement', 'invoice', 'Pdetails'));
        } catch (\Exception $e) {
            Log::error('InvoicesDetailsCustomers function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Allpaidcustomers()
    {
        try {
            $data = Payement::where('pay_status', '!=', 'full_due')->get();
            return view('backend.customers.Allpaidcustomers', compact('data'));
        } catch (\Exception $e) {
            Log::error('Allpaidcustomers function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function PrintCustomersPaid()
    {
        try {
            $data = Payement::where('pay_status', '!=', 'full_due')->get();
            return view('backend.pdfs.paid_customers_pdf', compact('data'));
        } catch (\Exception $e) {
            Log::error('PrintCustomersPaid function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function CustomerWiseReports()
    {
        try {
            $customers = Customer::all();
            return view('backend.customers.customers_wise_report', compact('customers'));
        } catch (\Exception $e) {
            Log::error('CustomerWiseReports function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function CustomerWisecredit(request $request)
    {
        try {
            $data = Payement::where('customer_id', $request->customer_id)->whereIn('pay_status', ['full_due', 'partial_paid'])->get();
            return view('backend.pdfs.customer_credit_wise_pdf', compact('data'));
        } catch (\Exception $e) {
            Log::error('CustomerWisecredit function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function CustomerWisepayement(request $request)
    {
        try {
            $data = Payement::where('customer_id', $request->customer_id)->where('pay_status', '!=', 'full_due')->get();
            return view('backend.pdfs.customer_payment_wise_pdf', compact('data'));
        } catch (\Exception $e) {
            Log::error('CustomerWisepayement function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
}
