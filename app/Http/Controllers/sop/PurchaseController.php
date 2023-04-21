<?php

namespace App\Http\Controllers\sop;

use App\Models\Purchase;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    public function AllPurchases()
    {
        try {
            $purchases = Purchase::orderBy('date', 'desc')->orderBy('id', 'desc')->get();
            return view('backend.purchases.All_Purchases', compact('purchases'));
        } catch (\Exception $e) {
            Log::error('AllPurchases function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Addpurchase()
    {
        try {
            $suppliers = Supplier::all();
            $units = Unit::all();
            $categories = Category::all();
            $brands = Brand::all();
            return view('backend.purchases.Add_Purchases', compact('suppliers', 'units', 'categories', 'brands'));
        } catch (\Exception $e) {
            Log::error('Addpurchase function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function storepurchase(request $request)
    {
        try {
            if ($request->category_id == null) {
                $notification = InsertNotification('Sorry No Category Been Seletected', 'error');
                return redirect()->back()->with($notification);
            } else {
                $category_count = count($request->category_id);
                for ($i = 0; $i < $category_count; $i++) {
                    $tax = calculatetax($request->buying_price[$i]);
                    $fields = [
                        'date' => date('Y-m-d', strtotime($request->date[$i])),
                        'purchase_no' => $request->purchase_no[$i],
                        'supplier_id' => $request->supplier_id[$i],
                        'category_id' => $request->category_id[$i],
                        'product_id' => $request->product_id[$i],
                        'buying_price' => $request->buying_price[$i],
                        'brand_id' => $request->brand_id[$i],
                        'unit_price' => $request->unit_price[$i],
                        'tax_amount' => calculatetax($request->buying_price[$i]),
                        'grand_total' => CalculateGrandAmount($request->buying_price[$i], $tax),
                        'qte' => $request->buying_qty[$i],
                        'description' => $request->description[$i],
                        'created_by' => Auth::user()->id,
                        'status' => '0',
                    ];
                    insertFields(Purchase::class, $fields);
                }
            }
            $notification = InsertNotification('Purchases Added Successfuly', 'success');
            return redirect()->route('all.Purchases')->with($notification);
        } catch (\Exception $e) {
            Log::error('storepurchase function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Deletepurchase($id)
    {
        try {
            Purchase::findorfail($id)->delete();
            $notification = InsertNotification('Purchase Deleted Successfuly', 'info');
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            Log::error('Deletepurchase function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Pendingpurchase()
    {
        try {
            $purchases = Purchase::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '0')->get();
            return view('backend.purchases.All_Pending_Purchases', compact('purchases'));
        } catch (\Exception $e) {
            Log::error('Pendingpurchase function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function approvepurchase($id)
    {
        try {
            $purchase = Purchase::findorfail($id);
            $product = Product::where('id', $purchase->product_id)->first();
            $purchase_qte = ((float)($purchase->qte)) + ((float)($product->product_qte));
            $product->product_qte = $purchase_qte;
            if ($product->save()) {
                Purchase::findorfail($id)->update([
                    'status' => '1',
                ]);
            }
            $notification = InsertNotification('Status Approved Successfuly', 'success');
            return redirect()->route('all.Purchases')->with($notification);
        } catch (\Exception $e) {
            Log::error('approvepurchase function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function SearchPurchases()
    {
        return view('backend.purchases.Search_Purchases');
    }
    public function SearchPurchasesPdfPage(Request $request)
    {
        try {
            $startdate = date('Y-m-d', strtotime($request->startdate));
            $enddate = date('Y-m-d', strtotime($request->enddate));
            $data = Purchase::whereBetween('date', [$startdate, $enddate])->where('status', '1')->get();
            return view('backend.pdfs.Purchases_Search_Report_pdf', compact('data', 'startdate', 'enddate'));
        } catch (\Exception $e) {
            Log::error('SearchPurchasesPdfPage function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function ViewPurchasesDetails($id)
    {
        try {
            $data = Purchase::findorfail($id);
            return view('backend.pdfs.Purchases_details_pdf', compact('data'));
        } catch (\Exception $e) {
            Log::error('ViewPurchasesDetails function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
}
