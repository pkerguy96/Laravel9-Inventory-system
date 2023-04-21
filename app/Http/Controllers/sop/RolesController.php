<?php

namespace App\Http\Controllers\sop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class RolesController extends Controller
{
    public function allroles()
    {
        try {
            $roles = Role::orderByRaw("name = 'SuperAdmin' desc, name asc")->get();
            return view('backend.adminroles.all_roles', compact('roles'));
        } catch (\Exception $e) {
            Log::error('allroles function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Allrolespermissions()
    {

        return view('backend.adminroles.roles_permissions');
    }
    public function storerole(request $request)
    {
        try {
            $rules = [
                'role_name' => 'required|min:3|max:50',
            ];
            $messages = [
                'role_name.required' => 'please enter a name',
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
            }
            $rolename = $request->role_name;
            Role::create(['name' =>  $rolename]);
            $notification = InsertNotification('Role inserted successfuly.', 'success');
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            Log::error('storerole function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function storepermissions(Request $request)
    {
        try {
            $permissions = ['m_supp', 'm_cust', 'm_unit', 'm_brand', 'm_categ', 'm_prod', 'm_purch', 'm_recei', 'm_inv', 'm_stock',];
            if ($request->roles_data == null) {
                $notification = InsertNotification('Please select a role first!', 'error');
                return redirect()->back()->with($notification);
            } else {
                $role = Role::findByName($request->roles_data);
                $currentPermissions = $role->permissions->pluck('name')->toArray();
                foreach ($permissions as $permission) {
                    if ($request->has($permission)) {
                        if (!in_array($permission, $currentPermissions)) {
                            $role->givePermissionTo($permission);
                        }
                    } else {
                        if (in_array($permission, $currentPermissions)) {
                            $role->revokePermissionTo($permission);
                        }
                    }
                }
            }
            $notification = InsertNotification('Permissions updated successfully!', 'success');
            return redirect()->route('all.admins')->with($notification);
        } catch (\Exception $e) {
            Log::error('storepermissions function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function DeleteRole($id)
    {
        try {
            role::where('id', $id)->delete();
            $notification = InsertNotification('Role deleted successfuly', 'info');
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            Log::error('DeleteRole function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
}
