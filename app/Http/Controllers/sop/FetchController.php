<?php

namespace App\Http\Controllers\sop;

use App\Models\Purchase;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class FetchController extends Controller
{
    public function FetchCategory(Request $request)
    {
        $supplierid = $request->supplier_id;
        $categories = Product::with(['categories'])->select('category_id')->where('supplier_id', $supplierid)->groupBy('category_id')->get();
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
}
