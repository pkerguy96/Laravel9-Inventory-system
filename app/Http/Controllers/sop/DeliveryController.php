<?php

namespace App\Http\Controllers\sop;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Brand;
use App\Models\DeliveryReceipt;
use App\Http\Controllers\Controller;
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

            $category_count = count($request->category_id);
            for ($i = 0; $i < $category_count; $i++) {

                $delivery_receipt = new DeliveryReceipt();

                $delivery_receipt->delivery_no = $request->delivery_no;
                $delivery_receipt->date = date('Y-m-d', strtotime($request->date));
                $delivery_receipt->due_date = date('Y-m-d', strtotime($request->due_date));
                $delivery_receipt->category_id = $request->category_id[$i];
                $delivery_receipt->product_id = $request->product_id[$i];
                $delivery_receipt->qte = $request->qte[$i];
                $delivery_receipt->brand_id = $request->brand_id[$i];

                $delivery_receipt->customer_id = $request->customer_id;

                $delivery_receipt->save();
            }
        }

        $notification = array(
            'message' => 'Delivery Receipt Data inserted Successfuly',
            'alert-type' => 'success'
        );
        return redirect()->route('all.delivery.receipt')->with($notification);
    }
}
