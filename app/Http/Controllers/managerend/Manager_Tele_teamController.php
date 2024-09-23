<?php

namespace App\Http\Controllers\managerend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\backend\Telemarketing;
use App\Models\backend\Services;
use Yajra\DataTables\DataTables;

class Manager_Tele_teamController extends Controller
{
    public function Manager_Tele_team(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tele_person')
                ->where('archive', 0)
                ->where('user_type', 1)
                ->where('user_id', Session::get('user_id'))
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1 tele_mteam" data-id=' . Crypt::encrypt($row->id) . '><i class="bi bi-eye"></i></a>';
                    $btn .= '<a class="btn btn-primary btn-sm m-1" href="' . url('manager/edit-mtele-team', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                    $btn .= '<a class="btn btn-danger btn-sm m-1" href="' . url('manager/mtele-delete-team', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('managerend.view-tele-team');
    }

    public function Add_Manager_Tele_team()
    {
        return view('managerend/madd-tele-team');
    }
    public function Submit_Manager_Tele_team(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'staff_id' => 'required',
            'staff_role' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric|digits:10',
            'joining_date' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'state' => 'required',
            'password' => 'required|confirmed',

        ]);

        if (isset($request->document_file) && $request->document_file != "") {
            $path = "assets/uploads/telemarketing/" . $request->document_file;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('document_file');
            $extenstion = $file->getClientOriginalExtension();
            $rename = time() . "." . $extenstion;
            $file->move('assets/uploads/telemarketing/', $rename);

            $data = [
                'company_id' => Session::get('company_id'),
                'user_id' => Session::get('user_id'),
                'user_type' => 1,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'staff_id' => $request->staff_id,
                'staff_role' => $request->staff_role,
                'email' => $request->email,
                'phone' => $request->phone,
                'joining_date' => $request->joining_date,
                'address' => $request->address,
                'city' => $request->city,
                'pincode' => $request->pincode,
                'password' => Hash::make($request->password),
                'state' => $request->state,
                'document_file' => $rename,
                'created_date' => date('d-m-Y'),
                'created_time' => time(),
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ];
        } else {
            $data = [

                'company_id' => Session::get('company_id'),
                'user_id' => Session::get('user_id'),
                'user_type' => 1,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'staff_id' => $request->staff_id,
                'staff_role' => $request->staff_role,
                'email' => $request->email,
                'phone' => $request->phone,
                'joining_date' => $request->joining_date,
                'address' => $request->address,
                'city' => $request->city,
                'pincode' => $request->pincode,
                'password' => Hash::make($request->password),
                'state' => $request->state,
                'created_date' => date('d-m-Y'),
                'created_time' => time(),
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ];
        }

        $insert = DB::table('tele_person')->insert($data);
        if ($insert) {
            return back()->with('success', 'Record save successfully!');
        }
    }

    public function Edit_Manager_Tele_team($id)
    {
        $tid = Crypt::decrypt($id);
        $teleAll = Telemarketing::find($tid);
        return view('managerend.edit-mtele-team', compact('teleAll'));
    }

    public function Update_Manager_Tele_team(Request $request)
    {
        $tid = Crypt::decrypt($request->id);
        $update = Telemarketing::find($tid);
        if ($request->email != $update->email) {
            $request->validate([
                'firstname' => 'required',
                'staff_role' => 'required',
                'email' => 'required|unique:tele_person,email',
                'phone' => 'required|numeric|digits:10',
                'joining_date' => 'required',
                'address' => 'required',
                'city' => 'required',
                'pincode' => 'required',
                'state' => 'required'
            ]);
        }

        if (isset($request->document_file) && $request->document_file != "") {
            $path = "assets/uploads/telemarketing/" . $update->document_file;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('document_file');
            $extenstion = $file->getClientOriginalExtension();
            $rename = time() . "." . $extenstion;
            $file->move('assets/uploads/telemarketing/', $rename);

            $update->user_id = Session::get('user_id');
            $update->company_id = Session::get('company_id');
            $update->user_type = 1;
            $update->firstname = $request->firstname;
            $update->lastname = $request->lastname;
            $update->staff_role = $request->staff_role;
            $update->email = $request->email;
            $update->phone = $request->phone;
            $update->joining_date = $request->joining_date;
            $update->address = $request->address;
            $update->city = $request->city;
            $update->pincode = $request->pincode;
            $update->state = $request->state;
            $update->document_file = $rename;
            $save = $update->save();
        } else {
            $update->user_id = Session::get('user_id');
            $update->company_id = Session::get('company_id');
            $update->user_type = 1;
            $update->firstname = $request->firstname;
            $update->lastname = $request->lastname;
            $update->staff_role = $request->staff_role;
            $update->email = $request->email;
            $update->phone = $request->phone;
            $update->joining_date = $request->joining_date;
            $update->address = $request->address;
            $update->city = $request->city;
            $update->pincode = $request->pincode;
            $update->state = $request->state;
            $save = $update->save();
        }
        if ($save) {
            return redirect('manager/view-tele-team')->with('success', 'User update successfully!');
        }
    }

    public function Manager_Tele_Delete($id)
    {
        $delete_id = Crypt::decrypt($id);
        $delete = Telemarketing::find($delete_id);
        $delete->archive = 1;
        $delete->save();
        return back()->with('success', 'Record delete successfully!');
    }
    public function Manager_Tele_Archive(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tele_person')
                ->where('archive', 1)
                ->where('user_type', 1)
                ->where('user_id', Session::get('user_id'))
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm text-danger m-1" href="' . url('manager/mactive-tele-team', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-arrow-clockwise"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('managerend.archive-mtele-team');
    }

    public function Manager_Tele_Active($id)
    {
        $archive_id = Crypt::decrypt($id);
        $activate = Telemarketing::find($archive_id);
        $activate->archive = 0;
        $activate->save();
        return back()->with('success', 'Team Active successfully!');
    }

    public function Manager_Tele_Password(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $pid = Crypt::decrypt($request->pid);
        $change_password = Telemarketing::find($pid);
        $change_password->password = Hash::make($request->password);
        $pass_update = $change_password->save();
        if ($pass_update) {
            return back()->with('password', 'Password update successfully!');
        }
    }

    public function view_details_teleMteam_modal(Request $request)
    {
        $teleID = Crypt::decrypt($request->id);
        $data = Telemarketing::find($teleID);
        return response()->json(array('data' => $data));
    }
}
