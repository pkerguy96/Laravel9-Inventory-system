<?php

namespace App\Http\Controllers\sop;

use Illuminate\Support\Facades\Cache;

use App\Models\Purchase;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DeliveryReceipt;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\notifications;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use App\Models\InvoiceDetail;

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
    public function getallroles()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
    public function getallpermissions(request $request)
    {
        $permissions = Role::findByName($request->rolename)->permissions;
        return response()->json($permissions);
    }
    public function gettotalsells()
    {
        // When new rows are added to the database, increment the version number:
        //  Cache::forget('invoices');

        $minutes = 720;
        $key = 'totalsells';
        $key2 = 'neworders';
        $key3 = 'totalcustomers';
        $key4 = 'outofstock';
        $key5 = 'invoice';
        $oneWeekAgo = Carbon::now()->subWeek();
        $currentDate = Carbon::now();

        $totalsell = Cache::remember($key, $minutes, function () {
            return  InvoiceDetail::sum('grand_total');
        });
        $neworder = Cache::remember($key2, $minutes, function () use ($oneWeekAgo, $currentDate) {

            return  InvoiceDetail::whereBetween('created_at', [$oneWeekAgo, $currentDate])

                ->count();
        });
        $totalCustomer = cache::remember($key3, $minutes, function () {
            return Customer::count();
        });
        $totaloutofstock =  cache::remember($key4, $minutes, function () {
            return Product::where('product_qte', '<', '10')->count();
        });
        $invoice = cache::remember($key5, $minutes, function () use ($oneWeekAgo, $currentDate) {


            return Invoice::with('clients', 'InvoiceDetails')
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
        });
        $data = [
            'totalsells' => $totalsell,
            'neworders' => $neworder,
            'totalCustomers' => $totalCustomer,
            'outofstocks' => $totaloutofstock,
            'invoices' => $invoice,
        ];
        return response()->json($data);
    }
}
