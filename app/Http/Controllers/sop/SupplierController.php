<?php

namespace App\Http\Controllers\sop;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


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
        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'ice' => 'required|string|unique:suppliers,ice',
        ];
        $messages = [
            'name.required' => 'please enter a name',
            'ice.unique' => 'The ICE field must be unique.'
        ];

        $result = verifySupplierIce($request, $rules, $messages);

        if ($result['status'] === 'error') {
            $errors = implode('<br>', $result['errors']);
            $notification = array(
                'message' => $errors,
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {

            supplier::insert([
                'name' =>  $request->name,
                'phone' =>  $request->phone,
                'address' =>  $request->address,
                'email' =>  $request->email,
                'ice' =>  $request->ice,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'Supplier Added Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.suppliers')->with($notification);
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
