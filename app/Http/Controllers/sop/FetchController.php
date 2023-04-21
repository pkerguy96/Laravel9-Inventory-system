<?php

namespace App\Http\Controllers\sop;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DeliveryReceipt;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\notifications;
use Spatie\Permission\Models\Role;
use App\Models\InvoiceDetail;
use App\Models\Payement;

class FetchController extends Controller
{
    public function FetchCategory(Request $request)
    {
        try {
            $brand_id = $request->brand_id;
            $categories = Product::with(['categories'])->select('category_id')->where('brand_id', $brand_id)->groupBy('category_id')->get();
            return response()->json($categories);
        } catch (\Exception $e) {
            Log::error('FetchCategory function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function FetchProduct(Request $request)
    {
        try {
            $categoryId = $request->category_id;
            $products = Product::where('category_id', $categoryId)->get();
            return response()->json($products);
        } catch (\Exception $e) {
            Log::error('FetchProduct function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function ProductStock(request $request)
    {
        try {
            $productStock = product::where('id', $request->product_id)->first()->product_qte;
            return response()->json($productStock);
        } catch (\Exception $e) {
            Log::error('ProductStock function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function CustomerDelivery(request $request)
    {
        try {
            $deliveryreceipt = DeliveryReceipt::where('customer_id', $request->customer_id)->get();
            return response()->json($deliveryreceipt);
        } catch (\Exception $e) {
            Log::error('CustomerDelivery function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function ReadNotification(request $request)
    {
        try {
            $notificationID = $request->notificationid;
            notifications::where('id', $notificationID)->where('user_id', auth::user()->id)->update(['is_read' => true]);
            $message = "Notification marked as read successfully!";
            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            Log::error('ReadNotification function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function deleteNotification(request $request)
    {
        try {
            $notificationID = $request->notificationid;
            notifications::where('id', $notificationID)->where('user_id', auth::user()->id)->delete();
            $message = 'Notification deleted successfully! ';
            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            Log::error('deleteNotification function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function getallroles()
    {
        try {
            $roles = Role::all();
            return response()->json($roles);
        } catch (\Exception $e) {
            Log::error('getallroles function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function getallpermissions(request $request)
    {
        try {
            $permissions = Role::findByName($request->rolename)->permissions;
            return response()->json($permissions);
        } catch (\Exception $e) {
            Log::error('getallpermissions function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function gettotalsells()
    {
        try {
            $minutes = 1440;
            $key = 'totalsells'; // treseta mnin ikon invoice jdid
            $key2 = 'neworders'; //treseta mnin ikon invoice jdid
            $key3 = 'totalcustomers'; // treseta mnin iji customer
            $key4 = 'outofstock'; // treseta mnin tajouta product ola tmodifya quantity means accepting an invoice tahia
            $key5 = 'invoice'; // treseta mnin ikon invoice jdid
            $oneWeekAgo = Carbon::now()->subWeek();
            $currentDate = Carbon::now();

            $totalsell = Cache::remember($key, $minutes, function () {
                return  Payement::sum('total_amount');
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
                return Invoice::with('clients', 'InvoiceDetails', 'payements')
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
        } catch (\Exception $e) {
            Log::error('gettotalsells function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
}
