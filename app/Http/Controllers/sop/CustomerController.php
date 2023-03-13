<?php

namespace App\Http\Controllers\sop;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Imports\CustomersImport;
use App\Models\Payement;
use App\Models\PayementDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /* function that grabs all the customers */
    public function Allcustomers()
    {
        $customers = Customer::latest()->get();
        return view('backend.customers.allcustomers', compact(('customers')));
    }
    /* redirects to customer page to add it  */
    public function AddCustomer()
    {
        return view('backend.customers.Add_customer');
    }
    /* adds customer in DB */
    public function StoreCustomer(Request $request)
    {
        if ($request->hasFile('customers_csv')) {

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
    }
    /* redirects to customer page to modify it  */
    public function EditCustomer($id)
    {
        $customerinfo = Customer::findorfail($id);
        return view('backend.customers.Edit_customer', compact("customerinfo"));
    }
    public function ModifyCustomer(request $request)
    {
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
    }
    public function DeleteCustomer($id)
    {
        Customer::findorfail($id)->delete();

        $notification = InsertNotification('Customer Deleted Successfully', 'info');
        return redirect()->route('all.customers')->with($notification);
    }
    public function CustomersCredit()
    {
        $data = Payement::whereIn('pay_status', ['full_due', 'partial_paid'])->get();

        return view('backend.customers.Customers_CreditInfo', compact(('data')));
    }
    public function CustomersPrintPdf()
    {
        $data = Payement::whereIn('pay_status', ['full_due', 'partial_paid'])->get();
        return view('backend.pdfs.Customers_pdf', compact(('data')));
    }
    public function EditCustomersInvoice($inv_id)
    {
        $payements  = Payement::where('invoice_id', $inv_id)->first();
        return view('backend.customers.Customers_edit_invoice', compact(('payements')));
    }
    public function UpdateCustomerPayement(request $request, $inv_id)
    {
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
    }
    public function InvoicesDetailsCustomers($inv_id)
    {
        $payement = Payement::where('invoice_id', $inv_id)->first();
        return view('backend.pdfs.customer_invoices_detail', compact('payement'));
    }
    public function Allpaidcustomers()
    {
        $data = Payement::where('pay_status', '!=', 'full_due')->get();
        return view('backend.customers.Allpaidcustomers', compact('data'));
    }
    public function PrintCustomersPaid()
    {
        $data = Payement::where('pay_status', '!=', 'full_due')->get();
        return view('backend.pdfs.paid_customers_pdf', compact('data'));
    }
    public function CustomerWiseReports()
    {
        $customers = Customer::all();

        return view('backend.customers.customers_wise_report', compact('customers'));
    }
    public function CustomerWisecredit(request $request)
    {
        $data = Payement::where('customer_id', $request->customer_id)->whereIn('pay_status', ['full_due', 'partial_paid'])->get();
        return view('backend.pdfs.customer_credit_wise_pdf', compact('data'));
    }
    public function CustomerWisepayement(request $request)
    {
        $data = Payement::where('customer_id', $request->customer_id)->where('pay_status', '!=', 'full_due')->get();
        return view('backend.pdfs.customer_payment_wise_pdf', compact('data'));
    }
}
