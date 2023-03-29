<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User Logout Successfully',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    } // End Method 


    public function Profile()
    {
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view', compact('adminData'));
    } // End Method 


    public function EditProfile()
    {

        $id = Auth::user()->id;
        $editData = User::find($id);
        return view('admin.admin_profile_edit', compact('editData'));
    } // End Method 

    public function StoreProfile(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;

        if ($request->file('profile_image')) {
            $file = $request->file('profile_image');

            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['profile_image'] = $filename;
        }
        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('admin.profile')->with($notification);
    } // End Method


    public function ChangePassword()
    {

        return view('admin.admin_change_password');
    } // End Method


    public function UpdatePassword(Request $request)
    {

        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword',

        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->oldpassword, $hashedPassword)) {
            $users = User::find(Auth::id());
            $users->password = bcrypt($request->newpassword);
            $users->save();

            session()->flash('message', 'Password Updated Successfully');
            return redirect()->back();
        } else {
            session()->flash('message', 'Old password is not match');
            return redirect()->back();
        }
    } // End Method
    /* all admins view */
    public function Alladmins()
    {


        $admins = User::all();
        return view('backend.adminroles.all_admins', compact('admins'));
    }
    /* edit admin view */
    public function Editadmin($id)
    {
        $roles = Role::all();
        $data = User::where('id', $id)->with('roles')->first();
        return view('backend.adminroles.edit_admin', compact('data', 'roles'));
    }
    public function Modifyadmin(Request $request)
    {
        $adminid = $request->adminid;
        $rules = [
            'name' => 'required|min:3|max:50',
            'username' => 'required|unique:users,username,' . $adminid . '|min:3|max:40',
            'email' => 'required|unique:users,email,' . $adminid . '|email',
            'role' => 'required',
        ];
        $messages = [
            'name.required' => 'please enter a name',
            'username.unique' => 'The username field must be unique.',
            'email.required' => 'please enter a email',
            'email.unique' => 'email already exists try again',
            'role.required' => 'please enter a role ',
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

            User::findorfail($adminid)->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'updated_at' => Carbon::now(),
            ]);
            $admin = User::findorfail($adminid);
            if ($request->role == 'none') {
                $admin->roles()->detach();
            } else {
                $admin->roles()->detach();
                $role = Role::find($request->role);

                $admin->roles()->sync([$role->id]);
            }
            $notification = InsertNotification('Admin updated successfully!', 'success');
            return redirect()->route('all.admins')->with($notification);
        }
    }
    public function Addnewadmin()
    {
        $roles = Role::all();
        return view('backend.adminroles.add_new_admin', compact("roles"));
    }
    public function StoreNewAdmin(Request $request)
    {
        $rules = [
            'name' => 'required|min:3|max:50',
            'username' => 'required|unique:users,username|min:3|max:40',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|confirmed',
            'role' => 'required',
        ];
        $messages = [
            'name.required' => 'please enter a name',
            'username.unique' => 'The username field must be unique.',
            'email.required' => 'please enter a email',
            'email.unique' => 'email already exists try again',
            'role.required' => 'please enter a role ',
            'password.required' => 'please enter a password ',
            'password.confirmed' => 'Password confirmation dosnt match',
        ];
        $result = verifySupplierIce($request, $rules, $messages);
        if ($result['status'] === 'error') {
            $errors = implode('+', $result['errors']);
            $notification = array(
                'message' => $errors,
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {

            $admin = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_at' => Carbon::now(),
            ]);

            if ($request->role != 'none') {

                $role = Role::find($request->role);
                $admin->roles()->sync([$role->id]);
            }
            $notification = InsertNotification('Admin updated successfully!', 'success');
            return redirect()->back()->with($notification);
        }
    }
    public function Deleteadmin(request $request)
    {
        $admin = User::findorfail($request->id);
        $admin->delete();
        $notification = InsertNotification('Admin Deleted successfully!', 'info');
        return redirect()->back()->with($notification);
    }
}
