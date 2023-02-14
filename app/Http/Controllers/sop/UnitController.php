<?php

namespace App\Http\Controllers\sop;

use App\Models\Unit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class UnitController extends Controller
{
    /* function that grabs all the Units */
    public function Allunits()
    {
        $units = Unit::latest()->get();
        return view('backend.Units.allunits', compact(('units')));
    }
    public function AddUnit()
    {
        return view('backend.Units.add_unit');
    }
    /* adds Unit in DB */
    public function StoreUnit(Request $request)
    {
        Unit::insert([
            'unit_name' =>  $request->name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Unit Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.Units')->with($notification);
    }
    /* redirects to unit page to modify it  */
    public function EditUnit($id)
    {
        $unitinfo = Unit::findorfail($id);
        return view('backend.Units.Edit_unit', compact("unitinfo"));
    }
    public function ModifyUnit(request $request)
    {
        $id = $request->unitid;
        Unit::findorfail($id)->update([
            'unit_name' =>  $request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Unit Modified Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.Units')->with($notification);
    }
    public function DeleteUnit($id)
    {
        Unit::findorfail($id)->delete();
        $notification = array(
            'message' => 'Unit Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.Units')->with($notification);
    }
}
