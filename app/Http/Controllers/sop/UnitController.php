<?php

namespace App\Http\Controllers\sop;

use App\Models\Unit;
use App\Http\Controllers\Controller;
use App\Imports\UnitImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class UnitController extends Controller
{
    /* function that grabs all the Units */
    public function Allunits()
    {
        try {
            $units = Unit::latest()->get();
            return view('backend.Units.allunits', compact(('units')));
        } catch (\Exception $e) {
            Log::error('Allunits function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function AddUnit()
    {
        return view('backend.Units.add_unit');
    }
    /* adds Unit in DB */
    public function StoreUnit(Request $request)
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('StoreUnit function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    /* redirects to unit page to modify it  */
    public function EditUnit($id)
    {
        try {
            $unitinfo = Unit::findorfail($id);
            return view('backend.Units.Edit_unit', compact("unitinfo"));
        } catch (\Exception $e) {
            Log::error('EditUnit function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function ModifyUnit(request $request)
    {
        try {
            $id = $request->unitid;
            Unit::findorfail($id)->update([
                'unit_name' =>  $request->name,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
            $notification = InsertNotification('Unit Modified Successfully', 'success');

            return redirect()->route('all.Units')->with($notification);
        } catch (\Exception $e) {
            Log::error('ModifyUnit function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function DeleteUnit($id)
    {
        try {
            Unit::findorfail($id)->delete();
            $notification = InsertNotification('Unit Deleted Successfully', 'info');
            return redirect()->route('all.Units')->with($notification);
        } catch (\Exception $e) {
            Log::error('DeleteUnit function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
}
