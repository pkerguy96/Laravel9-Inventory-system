<?php

namespace App\Http\Controllers\sop;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\PurchaseDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function AllPurchases()
    {
        try {
            $purchases = Purchase::with('PurchaseDetails')->orderBy('date', 'desc')->orderBy('id', 'desc')->get();
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
            $brands = Brand::all();
            return view('backend.purchases.Add_Purchases', compact('suppliers', 'brands'));
        } catch (\Exception $e) {
            Log::error('Addpurchase function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function storepurchase(request $request)
    {
        try {
            if (empty($request->category_id)  || empty($request->product_id)) {
                $errorMessage = empty($request->category_id) ? "Please select a category." : "Please select a product.";
                $notification = InsertNotification($errorMessage, 'error');
                return redirect()->back()->with($notification);
            } else {
                $purchase = new Purchase();
                $purchase->purchase_no = $request->purchase_no;
                $purchase->date = date('Y-m-d', strtotime($request->date));
                $purchase->description = $request->description;
                $purchase->tax_rate = $request->tax_rate;
                $purchase->created_by = Auth::user()->id;
                DB::transaction(function () use ($request, $purchase) {
                    if ($purchase->save()) {
                        $category_count = count($request->category_id);
                        for ($i = 0; $i < $category_count; $i++) {
                            $purchase_details = new PurchaseDetails();
                            $purchase_details->purchase_id = $purchase->id;
                            $purchase_details->brand_id = $request->brand_id[$i];
                            $purchase_details->supplier_id = $request->supplier_id[$i];
                            $purchase_details->category_id = $request->category_id[$i];
                            $purchase_details->product_id = $request->product_id[$i];
                            $purchase_details->qte = $request->buying_qty[$i];
                            $purchase_details->unit_price = $request->unit_price[$i];
                            $purchase_details->buying_price = $request->buying_pricerd[$i];
                            $purchase_details->save();
                        }
                    }
                });
            }
            $notification = InsertNotification('Purchases Added Successfuly', 'success');
            return redirect()->route('all.Purchases')->with($notification);
        } catch (\Exception $e) {
            Log::error('Deletepurchase function: ' . $e->getMessage());
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
            $purchases = Purchase::with('PurchaseDetails')->orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '0')->get();
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
            $purchasedetails = PurchaseDetails::where('purchase_id', $id)->get();
            $product = Product::where('id', $purchase->product_id)->first();
            foreach ($purchasedetails as $detail) {
                $product = Product::where('id', $detail->product_id)->first();
                $purchase_qte = ((float) $detail->qte) + ((float) $product->product_qte);
                $product->product_qte = $purchase_qte;
                $product->save();
            }
            if ($product->save()) {
                Purchase::findorfail($id)->update([
                    'status' => '1',
                ]);
            }
            $notification = InsertNotification('Status Approved Successfuly', 'success');
            return redirect()->route('all.Purchases')->with($notification);
        } catch (\Exception $e) {
            Log::error('SearchPurchasesPdfPage function: ' . $e->getMessage());
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
            $data = Purchase::with('PurchaseDetails')->whereBetween('date', [$startdate, $enddate])->where('status', '1')->get();
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
            $data = Purchase::with('PurchaseDetails')->findorfail($id);
            return view('backend.pdfs.Purchases_details_pdf', compact('data'));
        } catch (\Exception $e) {
            Log::error('ViewPurchasesDetails function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
}
