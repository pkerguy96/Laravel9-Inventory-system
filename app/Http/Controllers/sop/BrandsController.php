<?php

namespace App\Http\Controllers\sop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandsController extends Controller
{
    public function Allbrands()
    {
        $brands = Brand::latest()->get();
        return view('backend.Brands.allbrands', compact(('brands')));
    }
}
