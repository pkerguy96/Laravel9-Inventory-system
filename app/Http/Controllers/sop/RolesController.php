<?php

namespace App\Http\Controllers\sop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function allroles()
    {
        $roles = role::all();
        return view('backend.adminroles.all_roles', compact('roles'));
    }
    public function Allrolespermissions()
    {

        return view('backend.adminroles.roles_permissions');
    }
    public function storerole(request $request)
    {
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
    }
    public function storepermissions(Request $request)
    {

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
                /* $role = Role::findByName($request->roles_data);
                    $role->givePermissionTo($permission); */
            }
        }
        $notification = InsertNotification('Permissions updated successfully!', 'success');
        return redirect()->route('all.admins')->with($notification);
    }
    public function DeleteRole($id)
    {
        role::where('id', $id)->delete();
        $notification = InsertNotification('Role deleted successfuly', 'info');
        return redirect()->back()->with($notification);
    }
}
