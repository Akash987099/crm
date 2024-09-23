<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Users;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;

class AdminController extends Controller
{

    public function view_adminUsers(Request $request)
    {

        $adminUser = DB::table('users')
        ->where('id', Session::get('company_id'))
        ->get();

        if ($request->ajax()) {
            $data = $adminUser;
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-lg" href="' . url('admin/edit-admin', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                    // $btn = $btn . '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.admin.admin-users');
    }


    public function add_admin()
    {
        $country = config::get('common.all_country');
        return view('backend.admin.create-admin-user', compact('country'));
    }

    public function Create_admin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    
        $admin = new Users();
        $admin->company_id = Session::get('company_id');
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->phone = $request->phone;
        $admin->type = 2;
        $admin->address = $request->address;
        $admin->country = $request->country;
    
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $extension = $file->getClientOriginalExtension();
            $rename = time() . "." . $extension;
            $file->move('assets/uploads/users/', $rename);
            $admin->profile_pic = $rename;
    
            $path = "assets/uploads/users/" . $request->profile_pic;
            if (File::exists($path)) {
                File::delete($path);
            }
        } else {
            $admin->profile_pic = null; 
        }
    
       $save =  $admin->save();

        if ($save) {
            return back()->with('success', 'Admin Created Successfully!');
        }
    }

    public function Edit_admin($id)
    {

        $country = config::get('common.all_country');
        $admin_id = Crypt::decrypt($id);
        $edit_admin = Users::find($admin_id);
        return view('backend.admin.edit-user-admin', compact('edit_admin', 'country'));
    }

    public function Update_Admin(Request $request)
    {
        $admin_id = Crypt::decrypt($request->admin_id);
        $update_admin = Users::find($admin_id);
        if ($request->email != $update_admin->email) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required|confirmed'
            ]);
        }


        if (isset($request->profile_pic) && $request->profile_pic != "") {
            $path = "assets/uploads/users/" . $update_admin->profile_pic;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('profile_pic');
            $extension = $file->getClientOriginalExtension();
            $rename = time() . "." . $extension;
            $file->move('assets/uploads/users', $rename);

            $update_admin->company_id = Session::get('company_id');
            $update_admin->name = $request->name;
            $update_admin->email = $request->email;
            $update_admin->password = Hash::make($request->password);
            $update_admin->phone = $request->phone;
            $update_admin->address = $request->address;
            $update_admin->country = $request->country;
            $update_admin->profile_pic = $rename;
            $save = $update_admin->save();
        } else {
            $update_admin->company_id = Session::get('company_id');
            $update_admin->name = $request->name;
            $update_admin->email = $request->email;
            $update_admin->password = Hash::make($request->password);
            $update_admin->phone = $request->phone;
            $update_admin->address = $request->address;
            $update_admin->country = $request->country;
            $save = $update_admin->save();
        }
        if ($save) {
            return redirect('admin/admin-users')->with('success', 'Admin update successfully!');
        }
    }
}
