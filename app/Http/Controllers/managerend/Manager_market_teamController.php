<?php

namespace App\Http\Controllers\managerend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\backend\Marketing_user;
use Yajra\DataTables\DataTables;

class Manager_market_teamController extends Controller
{
    public function Manager_View_marketTeam(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('marketing_users')
                ->where('user_id', Session::get('user_id'))
                ->where('user_type', 1)
                ->where('archived', 0)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1 marketing" data-id=' . Crypt::encrypt($row->id) . '><i class="bi bi-eye"></i></a>';
                    $btn .= '<a class="btn btn-primary btn-sm m-1" href="' . url('manager/edit-market-mteam', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                    $btn .= '<a class="btn btn-danger btn-sm m-1" href="' . url('manager/delete-market-mteam', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('managerend.view-market-mteam');
    }

    public function Manager_Market_team()
    {
        return view('managerend.madd-market-team');
    }

    public function Manager_Market_team_submit(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'staff_id' => 'required',
            'staff_role' => 'required',
            'email' => 'required|unique:marketing_users,email',
            'phone' => 'required',
            'joining_date' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'password' => 'required|confirmed',
            'state' => 'required'
        ]);

        $add_market = new Marketing_user();

        if (isset($request->document_file) && $request->document_file != "") {
            $path = "assets/uploads/marketing/" . $request->document_file;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('document_file');
            $exten = $file->getClientOriginalExtension();
            $rename = time() . "." . $exten;
            $file->move('assets/uploads/marketing/', $rename);

            $add_market->company_id = Session::get('company_id');
            $add_market->user_id = Session::get('user_id');
            $add_market->user_type = 1;
            $add_market->firstname = $request->firstname;
            $add_market->lastname = $request->lastname;
            $add_market->staff_id = $request->staff_id;
            $add_market->staff_role = $request->staff_role;
            $add_market->email = $request->email;
            $add_market->phone = $request->phone;
            $add_market->joining_date = $request->joining_date;
            $add_market->address = $request->address;
            $add_market->city = $request->city;
            $add_market->pincode = $request->pincode;
            $add_market->password = Hash::make($request->password);
            $add_market->state = $request->state;
            $add_market->document_file = $rename;
            $add_market->created_date = date('d-m-Y');
            $add_market->created_time = time();
            $add_market->ip_address = $_SERVER['REMOTE_ADDR'];

            $save = $add_market->save();
        } else {
            $add_market->company_id = Session::get('company_id');
            $add_market->user_id = Session::get('user_id');
            $add_market->user_type = 1;
            $add_market->firstname = $request->firstname;
            $add_market->lastname = $request->lastname;
            $add_market->staff_id = $request->staff_id;
            $add_market->staff_role = $request->staff_role;
            $add_market->email = $request->email;
            $add_market->phone = $request->phone;
            $add_market->joining_date = $request->joining_date;
            $add_market->address = $request->address;
            $add_market->city = $request->city;
            $add_market->pincode = $request->pincode;
            $add_market->password = Hash::make($request->password);
            $add_market->state = $request->state;
            $add_market->created_date = date('d-m-Y');
            $add_market->created_time = time();
            $add_market->ip_address = $_SERVER['REMOTE_ADDR'];
            $save = $add_market->save();
        }

        if ($save) {
            return back()->with('success', 'Marketing User Create successfully!');
        }
    }

    public function Edit_market_manager_team($id)
    {
        $mid = Crypt::decrypt($id);
        $edit_marketing = Marketing_user::find($mid);
        return view('managerend.edit-market-mteam', compact('edit_marketing'));
    }
    public function Update_market_manager_team(Request $request)
    {
        $edit_id = Crypt::decrypt($request->id);
        $update_user = Marketing_user::find($edit_id);
        if (isset($update_user->email) && $update_user->email != $request->email) {
            $request->validate([
                'firstname' => 'required',
                'staff_role' => 'required',
                'email' => 'required|email|unique:marketing_users,email',
                'phone' => 'required',
                'joining_date' => 'required',
                'address' => 'required',
                'city' => 'required',
                'pincode' => 'required',
                'state' => 'required'
            ]);
        }


        if (isset($request->document_file) && $request->document_file != "") {
            $path = "assets/uploads/marketing/" . $update_user->document_file;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('document_file');
            $exten = $file->getClientOriginalExtension();
            $rename = time() . "." . $exten;
            $file->move('assets/uploads/marketing/', $rename);

            $update_user->company_id = Session::get('company_id');
            $update_user->user_id = Session::get('user_id');
            $update_user->user_type = 1;
            $update_user->firstname = $request->firstname;
            $update_user->lastname = $request->lastname;
            $update_user->staff_role = $request->staff_role;
            $update_user->email = $request->email;
            $update_user->phone = $request->phone;
            $update_user->joining_date = $request->joining_date;
            $update_user->address = $request->address;
            $update_user->city = $request->city;
            $update_user->pincode = $request->pincode;
            $update_user->state = $request->state;
            $update_user->document_file = $rename;
            $update = $update_user->save();
        } else {
            $update_user->company_id = Session::get('company_id');
            $update_user->user_id = Session::get('user_id');
            $update_user->user_type = 1;
            $update_user->firstname = $request->firstname;
            $update_user->lastname = $request->lastname;
            $update_user->staff_role = $request->staff_role;
            $update_user->email = $request->email;
            $update_user->phone = $request->phone;
            $update_user->joining_date = $request->joining_date;
            $update_user->address = $request->address;
            $update_user->city = $request->city;
            $update_user->pincode = $request->pincode;
            $update_user->state = $request->state;
            $update = $update_user->save();
        }

        if ($update) {
            return redirect('manager/view-market-mteam')->with('success', 'Updated successfully!');
        }
    }

    public function Delete_market_manager_team($id)
    {
        $delete_id = Crypt::decrypt($id);
        $delete = Marketing_user::find($delete_id);
        $delete->archived = 1;
        $delete->save();
        return back()->with('success', 'Marketing Delete Successfully!');
    }

    public function Archive_market_manager_team(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('marketing_users')
                ->where('archived', 1)
                ->where('user_type', 1)
                ->where('user_id', Session::get('user_id'))
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm text-danger m-1" href="' . url('manager/active-market-mteam', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-arrow-clockwise"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('managerend.archive-market-mteam');
    }
    public function Active_market_manager_team($id)
    {
        $active_id = Crypt::decrypt($id);
        $active = Marketing_user::find($active_id);
        $active->archived = 0;
        $active->save();
        return redirect('manager/view-market-mteam')->with('success', 'Active Marketing Successfully!');
    }

    public function Password_market_manager_team(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $paas_id = Crypt::decrypt($request->passid);
        $update_pass = Marketing_user::find($paas_id);
        $update_pass->password = Hash::make($request->password);
        $update = $update_pass->save();
        if ($update) {
            return back()->with('password', 'Password update Successfully!');
        }
    }
    public function view_details_market_Mteam_modal(Request $request)
    {
        $teleID = Crypt::decrypt($request->id);
        $data = Marketing_user::find($teleID);
        return response()->json(array('data' => $data));
    }
}
