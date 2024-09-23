<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\backend\StaffRole;
use Yajra\DataTables\DataTables;

class StaffController extends Controller
{
    public function view(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('staff_roles')
                ->where('company_id', Session::get('company_id'))
                ->where('archive', 0)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-primary btn-sm m-1" href="' . url('admin/edit-staff-role', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                    $btn .= '<a class="btn btn-danger btn-sm m-1" href="' . url('admin/delete-staff-role', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.staffrole.staff-roles');
    }

    public function add()
    {
        return view('backend.staffrole.add-roles');
    }
    public function Add_staff(Request $request)
    {

        $request->validate([
            'staff_name' => 'required|unique:staff_roles,staff_name'
        ]);

        $add_role = new StaffRole();
        $add_role->company_id = Session::get('company_id');
        $add_role->staff_name = trim(ucwords($request->staff_name));
        $add_role->telemarketing = json_encode($request->telemarketing);
        $add_role->marketing = json_encode($request->marketing);
        $add_role->client = json_encode($request->client);
        $add_role->manager = json_encode($request->manager);
        $add_role->bde = json_encode($request->bde);
        $add_role->call_history = json_encode($request->call_history);
        $add_role->check_call = json_encode($request->check_call);
        $add_role->coldcall = json_encode($request->coldcall);
        $add_role->ashign_meating_client = json_encode($request->ashign_meating_client);
        $add_role->meeting_response = json_encode($request->meeting_response);
        $add_role->our_service = json_encode($request->our_service);
        $add_role->created_date = date('d-m-Y');
        $add_role->created_time = time();
        $add_role->ip_address = $_SERVER['REMOTE_ADDR'];
        $role_add = $add_role->save();
        if ($role_add) {
            return back()->with('success', 'User has got permission successfully!');
        }
    }

    public function Edit_Rolls($id)
    {
        $staff_id = Crypt::decrypt($id);
        $edit_role = StaffRole::find($staff_id);

        return view('backend.staffrole.edit-staff-role', compact('edit_role'));
    }

    public function Update_role(Request $request)
    {
        // echo "<pre>", print_r($request->all()), "</pre>";
        // exit;
        $role_id = Crypt::decrypt($request->role_id);
        $role_update = StaffRole::find($role_id);
        if ($role_update->staff_name != $request->staff_name) {
            $request->validate([
                'staff_name' => 'required|unique:staff_roles,staff_name'
            ]);
        }

        $role_update->company_id = Session::get('company_id');
        $role_update->staff_name = trim(ucfirst($request->staff_name));
        $role_update->telemarketing = json_encode($request->telemarketing);
        $role_update->marketing = json_encode($request->marketing);
        $role_update->client = json_encode($request->client);
        $role_update->manager = json_encode($request->manager);
        $role_update->bde = json_encode($request->bde);
        $role_update->call_history = json_encode($request->call_history);
        $role_update->check_call = json_encode($request->check_call);
        $role_update->coldcall = json_encode($request->coldcall);
        $role_update->ashign_meating_client = json_encode($request->ashign_meating_client);
        $role_update->meeting_response = json_encode($request->meeting_response);
        $role_update->our_service = json_encode($request->our_service);
        $update = $role_update->save();
        if ($update) {
            return redirect('admin/staff-roles')->with('success', 'Role Update Successfully!');
        }
    }

    public function Delete_staff_role($id)
    {
        $delete_roleID = Crypt::decrypt($id);
        $delete_role = StaffRole::find($delete_roleID);
        $delete_role->archive = 1;
        $del_role = $delete_role->save();
        if ($del_role) {
            return back()->with('success', 'Role Delete Successfully!');
        }
    }

    public function Archive_role_staff(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('staff_roles')
                ->where('company_id', Session::get('company_id'))
                ->where('archive', 1)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1" href="' . url('admin/active-roles', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-arrow-clockwise"></i></a>';
                    // $btn .= '<a class="btn btn-danger btn-sm m-1" href="' . url('admin/delete-staff-role', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.staffrole.archive-role-staff');
    }

    public function Active_role($id)
    {
        $active_id = Crypt::decrypt($id);
        $active_role = StaffRole::find($active_id);
        $active_role->archive = 0;
        $role_active = $active_role->save();
        if ($role_active) {
            return back()->with('success', 'Role Active Successfully!');
        }
    }
}
