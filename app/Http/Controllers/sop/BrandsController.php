<?php

namespace App\Http\Controllers\sop;

use App\Http\Controllers\Controller;
use App\Imports\BrandsImport;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class BrandsController extends Controller
{
    public function Allbrands()
    {
        try {
            $brands = Brand::latest()->get();
            return view('backend.brands.allbrands', compact(('brands')));
        } catch (\Exception $e) {
            Log::error('All brands function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function AddBrand()
    {
        return view('backend.brands.add_brand');
    }

    public function StoreBrand(Request $request)
    {
        try {
            if ($request->hasFile('brands_cvs')) {
                $import = new BrandsImport();
                Excel::import($import, $request->file('brands_cvs'));
                $duplicates = $import->getDuplicates();

                if (!empty($duplicates)) {

                    $notification = array(
                        'message' => 'Some brands already exist in the database: ' . implode(', ', $duplicates),
                        'alert-type' => 'error'
                    );
                    return redirect()->route('all.Brands')->with($notification);
                }
                return redirect()->route('all.Brands')->with('success', 'User Imported Successfully');
            } else {
                Brand::insert([
                    'Brand_name' =>  $request->name,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
                $notification = InsertNotification('Brand Added Successfully', 'success');
            }
            return redirect()->route('all.Brands')->with($notification);
        } catch (\Exception $e) {
            Log::error('StoreBrand function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function EditBrand($id)
    {
        try {
            $data = Brand::findorfail($id);
            return view('backend.brands.Edit_brand', compact(('data')));
        } catch (\Exception $e) {
            Log::error('EditBrand function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function ModifyBrand(Request $request)
    {
        try {
            $id = $request->brandid;
            brand::findorfail($id)->update([
                'Brand_name' =>  $request->name,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
            $notification = InsertNotification('Brand Updated Successfully', 'success');
            return redirect()->route('all.Brands')->with($notification);
        } catch (\Exception $e) {
            Log::error('ModifyBrand function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Deletebrand($id)
    {
        try {
            Brand::findorfail($id)->delete();
            $notification = InsertNotification('Brand Deleted Successfully', 'info');
            return redirect()->route('all.Brands')->with($notification);
        } catch (\Exception $e) {
            Log::error('Deletebrand function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
}
