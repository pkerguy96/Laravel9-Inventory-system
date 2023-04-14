<?php

namespace App\Http\Controllers\sop;

use App\Models\Category;
use App\Models\Brand;
use App\Models\OrderForm;
use App\Http\Controllers\Controller;
use App\Models\OrderFormDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderFormController extends Controller
{
    public function AllOrderForms()
    {

        $data = OrderForm::orderBy('created_at', 'desc')->get();
        return view('backend.orderform.all_order_forms', compact('data'));
    }
    public function AddOrderForm()
    {
        $orderform_no = generateOrderFormNumber();
        $date = date('Y-m-d');
        $categories = Category::all();

        $brands = Brand::all();
        return view('backend.orderform.add_order_form', compact('orderform_no', 'date', 'categories', 'brands'));
    }
    public function StoreOrderForm(Request $request)
    {
        if ($request->category_id == null) {
            $notification = InsertNotification('please select category', 'error');
            return redirect()->back()->with($notification);
        } else {
            $orderform = new OrderForm();
            $orderform->orderform_no = $request->orderform_no;
            $orderform->date =  date('Y-m-d', strtotime($request->date));
            $orderform->total_qte = $request->Gtotal;
            $orderform->created_by = Auth::user()->id;
            DB::transaction(function () use ($request, $orderform) {
                $category_count = count($request->category_id);
                if ($orderform->save()) {
                    for ($i = 0; $i < $category_count; $i++) {
                        $orderform_details = new OrderFormDetails();
                        $orderform_details->orderform_id = $orderform->id;
                        $orderform_details->brand_id = $request->brand_id[$i];
                        $orderform_details->category_id = $request->category_id[$i];
                        $orderform_details->product_id = $request->product_id[$i];
                        $orderform_details->qte = $request->qte[$i];
                        $orderform_details->save();
                    }
                }
            });
        }

        $notification = InsertNotification('Order Form Data inserted Successfuly', 'success');
        return redirect()->route('all.order.forms')->with($notification);
    }
    public function OrderFormDetails($id)
    {
        $orderforms = OrderForm::with('OrderFormDetails')->findOrFail($id);
        return view('backend.pdfs.order_form_details', compact('orderforms'));
    }
}
