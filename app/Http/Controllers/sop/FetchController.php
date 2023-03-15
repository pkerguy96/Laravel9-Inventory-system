<?php

namespace App\Http\Controllers\sop;

use App\Models\Purchase;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use App\Models\DeliveryReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\notifications;
use Illuminate\Support\Facades\Session;

class FetchController extends Controller
{
    public function FetchCategory(Request $request)
    {
        $brand_id = $request->brand_id;
        $categories = Product::with(['categories'])->select('category_id')->where('brand_id', $brand_id)->groupBy('category_id')->get();
        return response()->json($categories);
    }
    public function FetchProduct(Request $request)
    {
        $categoryId = $request->category_id;
        $products = Product::where('category_id', $categoryId)->get();
        return response()->json($products);
    }
    public function ProductStock(request $request)
    {
        $productStock = product::where('id', $request->product_id)->first()->product_qte;
        return response()->json($productStock);
    }
    public function CustomerDelivery(request $request)
    {
        $deliveryreceipt = DeliveryReceipt::where('customer_id', $request->customer_id)->get();
        return response()->json($deliveryreceipt);
    }
    public function ReadNotification(request $request)
    {
        $notificationID = $request->notificationid;
        notifications::where('id', $notificationID)->where('user_id', auth::user()->id)->update(['is_read' => true]);
        $message = "Notification marked as read successfully!";
        return response()->json(['message' => $message]);
    }
    public function deleteNotification(request $request)

    {
        $notificationID = $request->notificationid;
        notifications::where('id', $notificationID)->where('user_id', auth::user()->id)->delete();
        $message = 'Notification deleted successfully! ';
        return response()->json(['message' => $message]);
    }
}
