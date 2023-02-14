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

class StockController extends Controller
{
    public function Stockreport()
    {
        $data = Product::orderby('supplier_id', 'asc')->orderby('category_id', 'asc')->get();
        return view('backend.Stock.View_Stock', compact('data'));
    }
    public function PrintStockreport()
    {
        $data = Product::orderby('supplier_id', 'asc')->orderby('category_id', 'asc')->get();
        return view('backend.pdfs.Print_report_pdf', compact('data'));
    }
    public function Searchbysuporstock()
    {
        $suppliers  = Supplier::all();
        $categories = Category::all();
        return view('backend.Stock.supplier_stock_filtration', compact('suppliers', 'categories'));
    }
    public function Searchbysupplier(request $request)
    {

        $data = Product::orderby('supplier_id', 'asc')->orderby('category_id', 'asc')->where('supplier_id', $request->supplier_id)->get();
        return view('backend.pdfs.supplier_report_pdf', compact('data'));
    }
    public function Searchbyproduct(request $request)
    {
        $products = Product::where('category_id', $request->category_id)->where('id', $request->product_id)->first();
        return view('backend.pdfs.product_report_pdf', compact('products'));
    }
}
