<?php

namespace App\Http\Controllers\sop;

use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function AllProducts()
    {
        try {
            $products = Product::latest()->get();
            return view('backend.products.All_Products', compact(('products')));
        } catch (\Exception $e) {
            Log::error('AllProducts function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Addproduct()
    {
        try {
            $suppliers = Supplier::all();
            $units = Unit::all();
            $categories = Category::all();
            $brands = Brand::all();
            return view('backend.products.Add_Products', compact('suppliers', 'units', 'categories', 'brands'));
        } catch (\Exception $e) {
            Log::error('Addproduct function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Storeproduct(Request $request)
    {
        try {
            $request->validate(
                ['product_name' => 'required|min:3',    'ref_num' => 'required', 'brand_id' => 'required', 'product_qte' => 'required', 'supplier_id' => 'required', 'unit_id' => 'required', 'category_id' => 'required'],
                [
                    'product_name.required' => 'Please enter a product name.',
                    'product_name.min' => 'The name must be at least 3 characters long.',
                    'ref_num.required' => 'Please enter a referrence number.',
                    'brand_id.required' => 'Please enter a brand.',
                    'product_qte.required' => 'Please enter product quantity number.',
                    'supplier_id.required' => 'Please enter a supplier.',
                    'unit_id.required' => 'Please enter a unit.',
                    'category_id.required' => 'Please enter products category.',

                ]
            );
            Product::insert([
                'product_name' => $request->product_name,
                'ref_num' => $request->ref_num,
                'brand_id' => $request->brand_id,
                'product_qte' => $request->product_qte,
                'supplier_id' => $request->supplier_id,
                'unit_id' => $request->unit_id,
                'category_id' => $request->category_id,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);
            Cache::forget('outofstock');
            $notification = InsertNotification('Product Added Successfully', 'success');
            return redirect()->route('all.Products')->with($notification);
        } catch (\Exception $e) {
            Log::error('Storeproduct function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    /* redirects to customer page to modify it  */
    public function Editproduct($id)
    {
        try {
            $productinfo = Product::findorfail($id);
            $suppliers = Supplier::all();
            $units = Unit::all();
            $categories = Category::all();
            return view('backend.products.Edit_Products', compact('productinfo', 'suppliers', 'units', 'categories'));
        } catch (\Exception $e) {
            Log::error('Editproduct function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Modifyproduct(Request $request)
    {
        try {
            $productid = $request->productid;
            Product::findorfail($productid)->update([
                'product_name' => $request->product_name,
                'ref_num' => $request->ref_num,
                'product_qte' => $request->product_qte,
                'supplier_id' => $request->supplier_id,
                'unit_id' => $request->unit_id,
                'category_id' => $request->category_id,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
            Cache::forget('outofstock');
            $notification = InsertNotification('Product Updated Successfully', 'success');
            return redirect()->route('all.Products')->with($notification);
        } catch (\Exception $e) {
            Log::error('Modifyproduct function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Deleteproduct($id)
    {
        try {
            Product::findorfail($id)->delete();
            $notification = InsertNotification('Product Deleted Successfully', 'info');
            Cache::forget('outofstock');
            return redirect()->route('all.Products')->with($notification);
        } catch (\Exception $e) {
            Log::error('Deleteproduct function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
}
