<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Marketing_user;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class marketController extends Controller
{
    public function View_list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('marketing_users')
                ->where('archived', 0)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-primary btn-sm m-1" title="Update" href="' . url('admin/marketing-edit', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                    $btn .= '<a class="btn btn-warning btn-sm m-1" title="Meetings" href="' . route('backend.marketofmeeting', ['marketid' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-calendar-event"></i></a>';
                    $btn .= '<a class="btn btn-info btn-sm m-1" title="Cold Call" href="' . route('backend.market.meetings-coldcall', ['marketid' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-c-square"></i></a>';
                    $btn .= '<a class="btn btn-danger btn-sm m-1" title="Delete" href="' . url('admin/delete-marketing', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.users.marketing');
    }

    public function Add_marketingUser()
    {
        return view('backend.users.add-marketing');
    }
    public function Create_marketingUser(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'staff_id' => 'required',
            'staff_role' => 'required',
            'email' => 'required|email|unique:marketing_users,email',
            'phone' => 'required',
            'joining_date' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'password' => 'required|confirmed',
            'state' => 'required'
        ]);

        if (isset($request->document_file) && $request->document_file != "") {
            $path = "assets/uploads/marketing/" . $request->document_file;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('document_file');
            $exten = $file->getClientOriginalExtension();
            $rename = time() . "." . $exten;
            $file->move('assets/uploads/marketing/', $rename);

            $add_market = new Marketing_user();
            $add_market->company_id = Session::get('company_id');
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
            $add_market = new Marketing_user();
            $add_market->company_id = Session::get('company_id');
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
            return back()->with('success', 'Record save successfully!');
        }
    }

    public function Edit_MarketingUser($id)
    {

        $mid = Crypt::decrypt($id);
        $edit_marketing = Marketing_user::find($mid);
        return view('backend.users.edit-marketing', compact('edit_marketing'));
    }
    public function Update_MarketingUser(Request $request)
    {
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

        $edit_id = Crypt::decrypt($request->id);
        $update_user = Marketing_user::find($edit_id);

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
            return redirect('admin/marketing')->with('success', 'Record update successfully!');
        }
    }


    public function View_archive_marketing()
    {
        return view('backend.users.archive-marketing');
    }

    public function View_archive_marketingList(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('marketing_users')
                ->where('archived', 1)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm text-danger m-1" href="' . url('admin/activate-marketing', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-arrow-clockwise"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function Delete_MarketingUser($id)
    {
        $delete_id = Crypt::decrypt($id);
        $delete = Marketing_user::find($delete_id);
        $delete->archived = 1;
        $delete->save();
        return back()->with('success', 'Record Delete Successfully!');
    }
    public function Activate_marketing($id)
    {
        $active_id = Crypt::decrypt($id);
        $active = Marketing_user::find($active_id);
        $active->archived = 0;
        $active->save();
        return back()->with('success', 'Record Activate Successfully!');
    }

    public function Change_pass_marketing(Request $request)
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
}
