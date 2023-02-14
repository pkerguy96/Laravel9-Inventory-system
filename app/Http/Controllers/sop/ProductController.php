<?php

namespace App\Http\Controllers\sop;

use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    public function AllProducts()
    {
        $products = Product::latest()->get();
        return view('backend.products.All_Products', compact(('products')));
    }
    public function Addproduct()
    {
        $suppliers = Supplier::all();
        $units = Unit::all();
        $categories = Category::all();
        return view('backend.products.Add_Products', compact('suppliers', 'units', 'categories'));
    }
    public function Storeproduct(Request $request)
    {
        Product::insert([
            'product_name' => $request->product_name,
            'ref_num' => $request->ref_num,
            'product_qte' => $request->product_qte,
            'supplier_id' => $request->supplier_id,
            'unit_id' => $request->unit_id,
            'category_id' => $request->category_id,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Product Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.Products')->with($notification);
    }
    /* redirects to customer page to modify it  */
    public function Editproduct($id)
    {
        $productinfo = Product::findorfail($id);
        $suppliers = Supplier::all();
        $units = Unit::all();
        $categories = Category::all();
        return view('backend.products.Edit_Products', compact('productinfo', 'suppliers', 'units', 'categories'));
    }
    public function Modifyproduct(Request $request)
    {
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
        $notification = array(
            'message' => 'Product Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.Products')->with($notification);
    }
    public function Deleteproduct($id)
    {
        Product::findorfail($id)->delete();
        $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.Products')->with($notification);
    }
}
