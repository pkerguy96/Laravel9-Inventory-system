<?php

namespace App\Http\Controllers\sop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\quotation;
use App\Models\QuotationDetail;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    public function AllQuotations()
    {
        $data = quotation::with('QuotationDetails')->orderby('date', 'desc')->orderby('id', 'desc')->get();
        return view('backend.quotation.All_Quotations', compact('data'));
    }
    public function AddQuotations()
    {
        $quotation_no = generateQuotationNumber();

        $date = date('Y-m-d');
        $categories = Category::all();
        $customers = Customer::all();
        $brands = Brand::all();
        return view('backend.quotation.Add_Quotation',  compact('quotation_no', 'date', 'categories', 'customers', 'brands'));
    }
    public function StoreQuotations(request $request)
    {
        if ($request->category_id == null) {
            $notification = array(
                'message' => 'please select category',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {

            $quotation = new quotation();
            $quotation->quotation_no = $request->quotation_no;
            $quotation->date = date('Y-m-d', strtotime($request->date));
            $quotation->due_date = date('Y-m-d', strtotime($request->due_date));
            $quotation->description = $request->description;
            $quotation->payement_type = $request->payement_status;
            $quotation->created_by = Auth::user()->id;

            /* make sure quotation saved no errors then insert on others */
            DB::transaction(function () use ($request, $quotation) {
                if ($quotation->save()) {
                    $category_count = count($request->category_id);
                    $total_qte = 0;
                    for ($i = 0; $i < $category_count; $i++) {
                        $tax = calculatetax($request->selling_pricerd[$i]);
                        $qte_count = intval($request->qte[$i]); // count the quantity in this category
                        $total_qte += $qte_count; // increment the total quantity by the quantity in this category
                        $quotation_details = new QuotationDetail();
                        $quotation_details->quotation_id = $quotation->id;

                        $quotation_details->category_id = $request->category_id[$i];
                        $quotation_details->product_id = $request->product_id[$i];
                        $quotation_details->qte = $request->qte[$i];
                        $quotation_details->brand_id = $request->brand_id[$i];
                        $quotation_details->tax_amount = calculatetax($request->selling_pricerd[$i]);
                        $quotation_details->unit_price = $request->unit_price[$i];
                        $quotation_details->selling_price = $request->selling_pricerd[$i];
                        $quotation_details->grand_total = CalculateGrandAmount($request->selling_pricerd[$i], $tax);


                        $quotation_details->save();
                    }
                    $quotation->total_qte = $total_qte;
                    $quotation->save();
                }
            });
        }
        $notification = array(
            'message' => 'Quotation Data inserted Successfuly',
            'alert-type' => 'success'
        );
        return redirect()->route('all.quotations')->with($notification);
    }
    public function DeleteQuotation($id)
    {
        quotation::findorfail($id)->delete();
        QuotationDetail::where('quotation_id', $id)->delete();
        $notification = InsertNotification('Quotation deleted successfuly', 'info');
        return redirect()->back()->with($notification);
    }
    public function QuotationDetails($id)
    {
        $quotation = quotation::with('QuotationDetails')->findorfail($id);
        return view('backend.pdfs.quotation_pdf', compact('quotation'));
    }
}
