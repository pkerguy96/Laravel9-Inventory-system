<?php

namespace App\Http\Controllers\sop;

use App\Http\Controllers\Controller;
use App\Imports\SupplierImport;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
{
    /* function that grabs all the suppliers */
    public function Allsuppliers()
    {
        $suppliers = Supplier::latest()->get();
        return view('backend.supplier.allsuppliers', compact(('suppliers')));
    }
    /* redirects to supplier page to add it  */
    public function Addsupplier()
    {
        return view('backend.supplier.Add_supplier');
    }
    /* adds supplier in DB */
    public function Storesupplier(Request $request)
    {
        /* First we try the insert by CSV file  */
        if ($request->hasfile('suppliers_csv')) {
            $suppliers = new SupplierImport();
            Excel::import($suppliers, $request->file('suppliers_csv'));
            $dupscount = $suppliers->duplicatesrow();
            if ($dupscount > 0) {
                $notification = InsertNotification($dupscount . ' Suppliers Were Skipped The Rest Is  Imported Successfuly', 'info');
            } else {
                $notification = InsertNotification('Suppliers Imported Successfuly', 'success');
            }

            return redirect()->route('all.suppliers')->with($notification);
        } else {
            /* Now we try if user entered supplier via inputs */
            /* rules for the inputes  */
            $rules = [
                'name' => 'required|string|max:255',
                'phone' => 'required|string|unique:suppliers,phone',
                'email' => 'required|email|unique:suppliers,email',
                'address' => 'required|string',
                'ice' => 'required|string|unique:suppliers,ice',
            ];
            $messages = [
                'name.required' => 'please enter a name',
                'ice.unique' => 'The ICE field must be unique.'
            ];
            /*  Inputs Validation*/
            $result = verifySupplierIce($request, $rules, $messages);

            if ($result['status'] === 'error') {
                $errors = implode('<br>', $result['errors']);
                $notification = array(
                    'message' => $errors,
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            } else {
                /* if no errors in validation we continue inserting data */
                supplier::insert([
                    'name' =>  $request->name,
                    'phone' =>  $request->phone,
                    'address' =>  $request->address,
                    'email' =>  $request->email,
                    'ice' =>  $request->ice,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
                $notification = InsertNotification('Supplier Has Been Added Successfuly', 'success');

                return redirect()->route('all.suppliers')->with($notification);
            }
        }
    }
    /* redirects to supplier page to modify it  */
    public function EditSupplier($id)
    {
        $supplierinfo = Supplier::findorfail($id);
        return view('backend.supplier.Edit_supplier', compact("supplierinfo"));
    }
    public function ModifySupplier(request $request)
    {
        $id = $request->supplierId;
        supplier::findorfail($id)->update([
            'name' =>  $request->name,
            'phone' =>  $request->phone,
            'address' =>  $request->address,
            'email' =>  $request->email,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Supplier Modified Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.suppliers')->with($notification);
    }
    public function DeleteSupplier($id)
    {
        Supplier::findorfail($id)->delete();
        $notification = array(
            'message' => 'Supplier Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.suppliers')->with($notification);
    }
}
