<?php

namespace App\Http\Controllers\sop;

use App\Models\Unit;
use App\Http\Controllers\Controller;
use App\Imports\UnitImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

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
        /* CSV INERT  */
        if ($request->hasfile('units_csv')) {

            $import = new UnitImport();
            Excel::import($import, $request->file('units_csv'));
            $dups = $import->getduplicates();

            if ($dups > 0) {

                $notification = InsertNotification($dups . ' Skipped Duplicates', 'success');
            } else {
                $notification =   InsertNotification('Units Uploaded Successfully', 'success');
            }
            return redirect()->route('all.Units')->with($notification);
        } else {

            /* REGULAR INPUTS INSERT */
            Unit::insert([
                'unit_name' =>  $request->name,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);
            $notification = InsertNotification('Unit Added Successfully', 'success');

            return redirect()->route('all.Units')->with($notification);
        }
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
        $notification = InsertNotification('Unit Modified Successfully', 'success');

        return redirect()->route('all.Units')->with($notification);
    }
    public function DeleteUnit($id)
    {
        Unit::findorfail($id)->delete();
        $notification = InsertNotification('Unit Deleted Successfully', 'info');


        return redirect()->route('all.Units')->with($notification);
    }
}
