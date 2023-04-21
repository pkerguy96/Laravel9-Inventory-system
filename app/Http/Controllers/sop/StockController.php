<?php

namespace App\Http\Controllers\sop;

use App\Models\Supplier;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    public function Stockreport()
    {
        try {
            $data = Product::orderby('supplier_id', 'asc')->orderby('category_id', 'asc')->get();
            return view('backend.Stock.View_Stock', compact('data'));
        } catch (\Exception $e) {
            Log::error('Stockreport function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function PrintStockreport()
    {
        try {
            $data = Product::orderby('supplier_id', 'asc')->orderby('category_id', 'asc')->get();
            return view('backend.pdfs.Print_report_pdf', compact('data'));
        } catch (\Exception $e) {
            Log::error('PrintStockreport function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Searchbysuporstock()
    {
        try {
            $suppliers  = Supplier::all();
            $categories = Category::all();
            return view('backend.Stock.supplier_stock_filtration', compact('suppliers', 'categories'));
        } catch (\Exception $e) {
            Log::error('Searchbysuporstock function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Searchbysupplier(request $request)
    {
        try {
            $data = Product::orderby('supplier_id', 'asc')->orderby('category_id', 'asc')->where('supplier_id', $request->supplier_id)->get();
            return view('backend.pdfs.supplier_report_pdf', compact('data'));
        } catch (\Exception $e) {
            Log::error('Searchbysupplier function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Searchbyproduct(request $request)
    {
        try {
            $products = Product::where('category_id', $request->category_id)->where('id', $request->product_id)->first();
            return view('backend.pdfs.product_report_pdf', compact('products'));
        } catch (\Exception $e) {
            Log::error('Searchbyproduct function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
}
