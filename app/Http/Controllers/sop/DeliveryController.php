<?php

namespace App\Http\Controllers\sop;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Brand;
use App\Models\DeliveryReceipt;
use App\Http\Controllers\Controller;
use App\Models\delivery_details;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function Alldelivery()
    {
        $deliverys = DeliveryReceipt::all();
        return view('backend.delivery.all_deliverys', compact(('deliverys')));
    }
    public function AddDelivery()
    {
        $delivery_no = generateDeliveryNumber();
        $date = date('Y-m-d');
        $categories = Category::all();
        $customers = Customer::all();
        $brands = Brand::all();
        return view('backend.delivery.add_delivery', compact('delivery_no', 'date', 'categories', 'customers', 'brands'));
    }
    public function storedevlivery(request $request)
    {
        if ($request->category_id == null || $request->customer_id == null) {
            $notification = array(
                'message' => 'please select category',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {
            $delivery = new DeliveryReceipt();
            $delivery->customer_id = $request->customer_id;
            $delivery->delivery_no = $request->delivery_no;
            $delivery->date =  date('Y-m-d', strtotime($request->date));
            $delivery->due_date = date('Y-m-d', strtotime($request->due_date));

            $delivery->description = $request->description;
            $delivery->total_qte = $request->Gtotal;
            $delivery->created_by = Auth::user()->id;
            DB::transaction(function () use ($request, $delivery) {
                $category_count = count($request->category_id);
                if ($delivery->save()) {
                    for ($i = 0; $i < $category_count; $i++) {

                        $delivery_details = new delivery_details();
                        $delivery_details->delivery_id = $delivery->id;
                        $delivery_details->brand_id = $request->brand_id[$i];
                        $delivery_details->category_id = $request->category_id[$i];
                        $delivery_details->product_id = $request->product_id[$i];
                        $delivery_details->qte = $request->qte[$i];
                        $delivery_details->save();
                    }
                }
            });
        }

        $notification = array(
            'message' => 'Delivery Receipt Data inserted Successfuly',
            'alert-type' => 'success'
        );
        return redirect()->route('all.delivery.receipt')->with($notification);
    }
    public function PrintDelivery($id)
    {
        $data = DeliveryReceipt::findorfail($id);
        $delivery_details = delivery_details::Where('delivery_id', $id)->get();
        return view('backend.pdfs.print_Deliverys', compact('data', 'delivery_details'));
    }
    public function DeleteDelivery($id)
    {
        DeliveryReceipt::findorfail($id)->delete();
        delivery_details::Where('delivery_id', $id)->delete();
        $notification = array(
            'message' => 'Delivery Receipt Deleted ',
            'alert-type' => 'info'
        );
        return redirect()->back()->with($notification);
    }
}
