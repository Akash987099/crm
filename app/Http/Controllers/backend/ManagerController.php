<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\backend\Users;
use App\Models\backend\Manager;
use Yajra\DataTables\DataTables;

class ManagerController extends Controller
{

    public function View_manager(Request $request)
    {
        // return "5555";

        if ($request->ajax()) {
            $data = DB::table('managers')
                ->where('archive', 0)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-primary btn-sm m-1" title="Update" href="' . url('admin/edit-manager', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                    $btn .= '<a class="btn btn-warning btn-sm m-1" title="Meetings" href="' . route('backend.manager.meetings', ['managerid' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-calendar-event"></i></a>';
                    $btn .= '<a class="btn btn-info btn-sm m-1" title="Cold Calls" href="' . route('backend.manager-coldcall', ['managerid' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-c-square"></i></a>';
                    $btn .= '<a class="btn btn-danger btn-sm m-1" title="Delete" href="' . url('admin/manager-delete', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.sales.manager');
    }


    public function Add_Manager()
    {
        return view('backend.sales.add-manager');
    }
    public function Create_Manager(Request $request)
    {

        // dd($request->all());
        $request->validate(
            [
                'name' => 'required',
                'staff_id' => 'required',
                'email' => 'required|unique:users,email',
                'phone' => 'required|numeric|digits:10',
                'joining_date' => 'required',
                'user_type'   => 'required',
                'password' => 'required|confirmed'
            ]
        );

        $add_manager = new Manager();

        if (isset($request->profile_pic) && $request->profile_pic != "") {
            $path = "assets/uploads/manager/" . $request->profile_pic;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('profile_pic');
            $extension = $file->getClientOriginalExtension();
            $rename = time() . "." . $extension;
            $file->move('assets/uploads/manager/', $rename);

            

            $add_manager->company_id = Session::get('company_id');
            $add_manager->name = $request->name;
            $add_manager->user_type = $request->user_type;
            $add_manager->staff_id = $request->staff_id;
            $add_manager->role_type = 'manager';
            $add_manager->email = $request->email;
            $add_manager->phone = $request->phone;
            $add_manager->joining_date = $request->joining_date;
            $add_manager->address = $request->address;
            $add_manager->city = $request->city;
            $add_manager->password = Hash::make($request->password);
            $add_manager->pincode = $request->pincode;
            $add_manager->state = $request->state;
            $add_manager->profile_pic = $rename;
            $add_manager->created_date = date('d-m_Y');
            $add_manager->created_time = time();
            $add_manager->ip_address = $_SERVER['REMOTE_ADDR'];
            $save_manager = $add_manager->save();
        } else {
            $add_manager->company_id = Session::get('company_id');
            $add_manager->name = $request->name;
            $add_manager->staff_id = $request->staff_id;
            $add_manager->role_type = 'manager';
            $add_manager->email = $request->email;
            $add_manager->phone = $request->phone;
            $add_manager->joining_date = $request->joining_date;
            $add_manager->address = $request->address;
            $add_manager->city = $request->city;
            $add_manager->password = Hash::make($request->password);
            $add_manager->user_type = $request->user_type;
            $add_manager->pincode = $request->pincode;
            $add_manager->state = $request->state;
            $add_manager->created_date = date('d-m_Y');
            $add_manager->created_time = time();
            $add_manager->ip_address = $_SERVER['REMOTE_ADDR'];
            $save_manager = $add_manager->save();
        }
        if ($save_manager) {
            return back()->with('success', 'Manager save successfully!');
        }
    }

    public function Edit_manager($id)
    {
        $mid = Crypt::decrypt($id);
        $edit_manager = Manager::find($mid);
        return view('backend.sales.edit-manager', compact('edit_manager'));
    }
    public function Update_manager(Request $request)
    {
        $edit_mid = Crypt::decrypt($request->mid);
        $update_manager = Manager::find($edit_mid);
        if ($request->email != $update_manager->email) {
            $request->validate(
                [
                    'manager_name' => 'required',
                    'email' => 'required|unique:managers,email',
                    'phone' => 'required|numeric|digits:10',
                    'joining_date' => 'required',
                ]
            );
        }
        if (isset($request->document_file) && $request->document_file != "") {
            $path = "assets/uploads/manager/" . $update_manager->document_file;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('document_file');
            $extension = $file->getClientOriginalExtension();
            $rename = time() . "." . $extension;
            $file->move('assets/uploads/manager/', $rename);

            $update_manager->company_id = Session::get('company_id');
            $update_manager->name = $request->name;
            $update_manager->role_type = 'manager';
            $update_manager->email = $request->email;
            $update_manager->phone = $request->phone;
            $update_manager->joining_date = $request->joining_date;
            $update_manager->address = $request->address;
            $update_manager->city = $request->city;
            $update_manager->pincode = $request->pincode;
            $update_manager->state = $request->state;
            $update_manager->document_file = $rename;
            $update_manager->created_date = date('d-m_Y');
            $update_manager->created_time = time();
            $update_manager->ip_address = $_SERVER['REMOTE_ADDR'];
            $update = $update_manager->save();
        } else {
            $update_manager->company_id = Session::get('company_id');
            $update_manager->name = $request->name;
            $update_manager->role_type = 'manager';
            $update_manager->email = $request->email;
            $update_manager->phone = $request->phone;
            $update_manager->joining_date = $request->joining_date;
            $update_manager->address = $request->address;
            $update_manager->city = $request->city;
            $update_manager->pincode = $request->pincode;
            $update_manager->state = $request->state;
            $update_manager->created_date = date('d-m_Y');
            $update_manager->created_time = time();
            $update_manager->ip_address = $_SERVER['REMOTE_ADDR'];
            $update = $update_manager->save();
        }

        if ($update) {
            return redirect('admin/manager')->with('success', 'Manager update successfully!');
        }
    }

    public function Delete_manager($id)
    {
        $delete_id = Crypt::decrypt($id);
        $delete_manager = Manager::where('id', $delete_id)->delete();
        // $delete_manager->archive = 1;
        // $delete_manager->save();
        return back()->with('success', 'Manager delete successfully!');
    }
    public function View_Archive_manager()
    {
        $manager = DB::table('managers')->where('company_id', Session::get('user_id'))->get();
        return view('backend.sales.archive-manager', compact('manager'));
    }

    public function Manager_archive_list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('managers')
                ->where('archive', 1)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Active Manager" class="btn btn-info btn-sm text-danger m-1" href="' . url('admin/active-manager', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-arrow-clockwise"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function Activate_manager($id)
    {

        $active_id = Crypt::decrypt($id);
        $active_manager = Manager::where('id', $active_id)->first();
        $active_manager->archive = 0;
        $active_manager->save();
        return back()->with('success', 'Manager active successfully!');
    }

    public function Manager_passwordChange(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);
        $passid = Crypt::decrypt($request->passid);
        $manager_pass = Manager::where('id', $passid)->first();
        $manager_pass->password = Hash::make($request->password);
        $manager_pass->save();
        return back()->with('password', 'Manager password update!');
    }

    public function Manager_Meeting($managerid)
    {
        $meeting = DB::table('meetings')
            ->where('user_id', Crypt::decrypt($managerid))
            ->where('user_type', 3)
            ->where('type', 1)
            ->where('archive', 0)
            ->get();

        $user = DB::table('managers')
            ->where('id', Crypt::decrypt($managerid))
            ->where('archive', 0)
            ->first();
        return view('backend.sales.manager-meeting', compact('meeting', 'user'));
    }

    public function Manager_Meeting_Details($meetingid)
    {

        $meeetingData = DB::table('meetings')
            ->where('id', Crypt::decrypt($meetingid))
            ->where('user_type', 3)
            ->where('type', 1)
            ->where('archive', 0)
            ->first();

        $temp_service = DB::table('service_temp')->where('meetingid', Crypt::decrypt($meetingid))->get();
        /**************************payment*************************************************/
        if (DB::table('payment_details')->where('meeting_id', $meeetingData->id)->exists()) {
            $payment = DB::table('payment_details')->where('meeting_id', $meeetingData->id)->get();
        } else {
            $payment = '';
        }
        /**************************end payment*********************************************/
        $client = DB::table('clients')->where('id', $meeetingData->clientid)->where('typeofuser', 1)->where('archive', 0)->first();
        if (isset($client->user_type) && $client->user_type == 0) {
            $given_meeting_user = DB::table('tele_person')->where('id', $client->user_id)->where('archive', 0)->first();
        } else {
            $given_meeting_user = 'Admin';
        }
        $user = DB::table('managers')
            ->where('id', $meeetingData->user_id)
            ->where('archive', 0)
            ->where('status', 0)
            ->first();
        return view('backend.sales.manager-meeting-details', compact('meeetingData', 'user', 'given_meeting_user', 'payment', 'temp_service'));
    }

    public function Manager_Meeting_Archive($meetingid)
    {
        $delete = DB::table('meetings')
            ->where('id', Crypt::decrypt($meetingid))
            ->where('user_type', 3)
            ->where('type', 1)
            ->update([
                'archive' => 1
            ]);
        return back()->with('success', 'Manager Meeting Delete!');
    }

    public function Manager_Archive_meeting_List(Request $request)
    {
        $meeting = DB::table('meetings')
            ->where('user_type', 3)
            ->where('type', 1)
            ->where('archive', 1)
            ->where('user_id', Crypt::decrypt($request->managerid))
            ->get();

        $user = DB::table('managers')
            ->where('id', Crypt::decrypt($request->managerid))
            ->where('archive', 0)
            ->where('status', 0)
            ->first();

        return view('backend.sales.manager-meetings-archive', compact('meeting', 'user'));
    }

    public function Manager_Meeting_Active($id)
    {

        $active = DB::table('meetings')
            ->where('id', Crypt::decrypt($id))
            ->where('user_type', 3)
            ->where('type', 1)
            ->update([
                'archive' => 0
            ]);
        return back()->with('success', 'Manager Meeting Active!');
    }

    public function Manager_ColdCall($managerid)
    {
        $meeting = DB::table('meetings')
            ->where('user_id', Crypt::decrypt($managerid))
            ->where('user_type', 3)
            ->where('type', 0)
            ->where('archive', 0)
            ->get();

        $user = DB::table('managers')
            ->where('id', Crypt::decrypt($managerid))
            ->where('archive', 0)
            ->first();
        return view('backend.sales.manager-coldcall', compact('meeting', 'user'));
    }

    public function Manager_ColdCall_Details($meetingid)
    {
        $meeetingData = DB::table('meetings')
            ->where('id', Crypt::decrypt($meetingid))
            ->where('user_type', 3)
            ->where('type', 0)
            ->where('archive', 0)
            ->first();

        $temp_service = DB::table('service_temp')->where('meetingid', Crypt::decrypt($meetingid))->get();
        /**************************payment*************************************************/
        if (DB::table('payment_details')->where('meeting_id', $meeetingData->id)->exists()) {
            $payment = DB::table('payment_details')->where('meeting_id', $meeetingData->id)->get();
        } else {
            $payment = '';
        }
        /**************************end payment*********************************************/
        $user = DB::table('managers')
            ->where('id', $meeetingData->user_id)
            ->where('archive', 0)
            ->where('status', 0)
            ->first();
        return view('backend.sales.manager-coldcall-details', compact('meeetingData', 'user', 'payment', 'temp_service'));
    }

    public function Manager_ColdCall_Delete($meetingid)
    {
        $delete = DB::table('meetings')
            ->where('id', Crypt::decrypt($meetingid))
            ->where('user_type', 3)
            ->where('type', 0)
            ->update([
                'archive' => 1
            ]);
        return back()->with('success', 'Manager Cold Call Deleted');
    }
    public function ManagerColdCall_Archive(Request $request)
    {
        if (isset($request->managerid) && $request->managerid != '') {
            $archiveColdcal = DB::table('meetings')
                ->where('user_type', 3)
                ->where('type', 0)
                ->where('user_id', '=', Crypt::decrypt($request->managerid))
                ->where('archive', 1)
                ->get();
        } else {
            $archiveColdcal = '';
        }

        return view('backend.sales.manager-coldcall-archive', compact('archiveColdcal'));
    }

    public function ManagerColdCall_Active(Request $request)
    {

        $active = DB::table('meetings')
            ->where('id', Crypt::decrypt($request->meetingid))
            ->where('user_type', 3)
            ->where('type', 0)
            ->update([
                'archive' => 0
            ]);
        return back()->with('success', 'Manager Cold Call Active');
    }
}
