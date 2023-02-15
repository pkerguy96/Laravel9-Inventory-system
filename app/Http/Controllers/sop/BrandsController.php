<?php

namespace App\Http\Controllers\sop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class BrandsController extends Controller
{
    public function Allbrands()
    {
        $brands = Brand::latest()->get();
        return view('backend.Brands.allbrands', compact(('brands')));
    }
    public function AddBrand()
    {
        return view('backend.Brands.add_brand');
    }

    public function StoreBrand(Request $request)
    {


        Brand::insert([
            'Brand_name' =>  $request->name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Brand Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.Brands')->with($notification);
    }
    public function EditBrand($id)
    {
        $data = Brand::findorfail($id);
        return view('backend.Brands.Edit_brand', compact(('data')));
    }
    public function ModifyBrand(Request $request)
    {
        $id = $request->brandid;
        brand::findorfail($id)->update([
            'Brand_name' =>  $request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Brand Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.Brands')->with($notification);
    }
    public function Deletebrand($id)
    {
        Brand::findorfail($id)->delete();
        $notification = array(
            'message' => 'Brand Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.Brands')->with($notification);
    }
}
