<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Bde;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class bdeController extends Controller
{

    public function View_bde(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('bdes')
                ->where('archive', 0)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-primary btn-sm m-1" title="Update" href="' . url('admin/edit-bde', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                    $btn .= '<a class="btn btn-warning btn-sm m-1" title="Meetings" href="' . route('backend.bde-meetings', ['bdeid' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-calendar-event"></i></a>';
                    $btn .= '<a class="btn btn-info btn-sm m-1" title="Cold Call" href="' . route('backend.bde-coldcall', ['bdeid' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-c-square"></i></a>';
                    $btn .= '<a class="btn btn-danger btn-sm m-1" title="Delete" href="' . url('admin/bde-delete', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.sales.bde');
    }


    public function Add_bde()
    {
        return view('backend.sales.add-bde');
    }
    public function Post_bde(Request $request)
    {
        $request->validate(
            [
                'bde_name' => 'required',
                'staff_id' => 'required',
                'email' => 'required|email|unique:bdes,email',
                'phone' => 'required|numeric|digits:10',
                'joining_date' => 'required',
                'password' => 'required|confirmed'
            ]
        );

        $add_manager = new Bde();

        if (isset($request->profile_pic) && $request->profile_pic != "") {
            $path = "assets/uploads/bde/" . $request->profile_pic;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('profile_pic');
            $extension = $file->getClientOriginalExtension();
            $rename = time() . "." . $extension;
            $file->move('assets/uploads/bde/', $rename);


            $add_manager->company_id = Session::get('company_id');
            $add_manager->bde_name = $request->bde_name;
            $add_manager->staff_id = $request->staff_id;
            $add_manager->email = $request->email;
            $add_manager->phone = $request->phone;
            $add_manager->joining_date = $request->joining_date;
            $add_manager->address = $request->address;
            $add_manager->city = $request->city;
            $add_manager->password = Hash::make($request->password);
            $add_manager->pincode = $request->pincode;
            $add_manager->state = $request->state;
            $add_manager->staff_role = $request->staff_role;
            $add_manager->profile_pic = $rename;
            $add_manager->created_date = date('d-m_Y');
            $add_manager->created_time = time();
            $add_manager->ip_address = $_SERVER['REMOTE_ADDR'];
            $save_manager = $add_manager->save();
        } else {

            $add_manager->company_id = Session::get('company_id');
            $add_manager->bde_name = $request->bde_name;
            $add_manager->staff_id = $request->staff_id;
            $add_manager->email = $request->email;
            $add_manager->phone = $request->phone;
            $add_manager->joining_date = $request->joining_date;
            $add_manager->address = $request->address;
            $add_manager->city = $request->city;
            $add_manager->password = Hash::make($request->password);
            $add_manager->pincode = $request->pincode;
            $add_manager->state = $request->state;
            $add_manager->staff_role = $request->staff_role;
            $add_manager->created_date = date('d-m_Y');
            $add_manager->created_time = time();
            $add_manager->ip_address = $_SERVER['REMOTE_ADDR'];
            $save_manager = $add_manager->save();
        }
        if ($save_manager) {
            return back()->with('success', 'B.D.E save successfully!');
        }
    }

    public function Edit_bde($id)
    {
        $edit_id = Crypt::decrypt($id);
        $edit_bde = Bde::where('id', $edit_id)->first();
        return view('backend.sales.edit-bde', compact('edit_bde'));
    }

    public function Update_bde(Request $request)
    {
        $edit_bid = Crypt::decrypt($request->bid);
        $update_bde = Bde::where('id', $edit_bid)->first();
        if ($request->email != $update_bde->email) {
            $request->validate(
                [
                    'bde_name' => 'required',
                    'email' => 'required|unique:bdes,email',
                    'phone' => 'required|numeric|digits:10',
                    'joining_date' => 'required'
                ]
            );
        }
        if (isset($request->profile_pic) && $request->profile_pic != "") {
            $path = "assets/uploads/bde/" . $request->profile_pic;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('profile_pic');
            $extension = $file->getClientOriginalExtension();
            $rename = time() . "." . $extension;
            $file->move('assets/uploads/bde/', $rename);

            $update_bde->company_id = Session::get('company_id');
            $update_bde->bde_name = $request->bde_name;
            $update_bde->email = $request->email;
            $update_bde->phone = $request->phone;
            $update_bde->joining_date = $request->joining_date;
            $update_bde->address = $request->address;
            $update_bde->city = $request->city;
            $update_bde->pincode = $request->pincode;
            $update_bde->state = $request->state;
            $update_bde->staff_role = $request->staff_role;
            $update_bde->profile_pic = $rename;
            $update_bde->created_date = date('d-m_Y');
            $update_bde->created_time = time();
            $update_bde->ip_address = $_SERVER['REMOTE_ADDR'];
            $update = $update_bde->save();
        } else {
            $update_bde->company_id = Session::get('company_id');
            $update_bde->bde_name = $request->bde_name;
            $update_bde->email = $request->email;
            $update_bde->phone = $request->phone;
            $update_bde->joining_date = $request->joining_date;
            $update_bde->address = $request->address;
            $update_bde->city = $request->city;
            $update_bde->pincode = $request->pincode;
            $update_bde->state = $request->state;
            $update_bde->staff_role = $request->staff_role;
            $update_bde->created_date = date('d-m_Y');
            $update_bde->created_time = time();
            $update_bde->ip_address = $_SERVER['REMOTE_ADDR'];
            $update = $update_bde->save();
        }

        if ($update) {
            return redirect('admin/bde')->with('success', 'B.D.E update successfully!');
        }
    }

    public function BDE_delete($id)
    {
        $delete_id = Crypt::decrypt($id);
        $delete_bde = Bde::where('id', $delete_id)->first();
        $delete_bde->archive = 1;
        $delete_bde->save();
        return back()->with('success', 'B.D.E delete successfully!');
    }

    public function BDE_password_update(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);
        $passid = Crypt::decrypt($request->passid);
        $bde_pass = Bde::where('id', $passid)->first();
        $bde_pass->password = Hash::make($request->password);
        $bde_pass->save();
        return back()->with('password', 'B.D.E Password Update!');
    }

    public function view_archive_bde(Request $request)
    {
        return view('backend.sales.archive-bde');
    }

    public function view_archive_bdedata(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('Bde')
                ->where('archive', 1)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Active B.D.E" class="btn btn-info btn-sm text-danger m-1" href="' . url('admin/active-bde', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-arrow-clockwise"></i></a>';
                    //$btn .= '<a class="btn btn-danger btn-sm m-1" href="' . url('admin/manager-delete', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function Active_bde($id)
    {
        $active_id = Crypt::decrypt($id);
        $active_bde = Bde::where('id', $active_id)->first();
        $active_bde->archive = 0;
        $active_bde->save();
        return back()->with('success', 'B.D.E Active successfully!');
    }

    public function Bde_Meetings($bdeid)
    {
        $meeting = DB::table('meetings')
            ->where('user_id', Crypt::decrypt($bdeid))
            ->where('user_type', 4)
            ->where('type', 1)
            ->where('archive', 0)
            ->get();

        $user = DB::table('bdes')
            ->where('id', Crypt::decrypt($bdeid))
            ->where('archive', 0)
            ->first();

        return view('backend.sales.bde-meetings', compact('meeting', 'user'));
    }

    public function Bde_Meetings_Details($meetingid)
    {
        $meeetingData = DB::table('meetings')
            ->where('id', Crypt::decrypt($meetingid))
            ->where('user_type', 4)
            ->where('type', 1)
            ->where('archive', 0)
            ->first();

        $temp_service = DB::table('service_temp')
            ->where('meetingid', Crypt::decrypt($meetingid))
            ->get();

        /**************************payment*************************************************/
        if (DB::table('payment_details')->where('meeting_id', $meeetingData->id)->exists()) {
            $payment = DB::table('payment_details')->where('meeting_id', $meeetingData->id)->get();
        } else {
            $payment = '';
        }
        /**************************end payment*********************************************/

        $client = DB::table('clients')->where('id', $meeetingData->clientid)->where('typeofuser', 3)->where('archive', 0)->first();
        if (isset($client->user_type) && $client->user_type == 0) {
            $given_meeting_user = DB::table('tele_person')->where('id', $client->user_id)->where('archive', 0)->first();
        } else {
            $given_meeting_user = 'Admin';
        }
        $user = DB::table('bdes')
            ->where('id', $meeetingData->user_id)
            ->where('archive', 0)
            ->where('status', 0)
            ->first();

        return view('backend.sales.bde-meeting-details', compact('meeetingData', 'user', 'given_meeting_user', 'payment', 'temp_service'));
    }

    public function Bde_Meetings_Delete($meetingid)
    {
        $delete = DB::table('meetings')
            ->where('id', Crypt::decrypt($meetingid))
            ->where('user_type', 4)
            ->where('type', 1)
            ->update([
                'archive' => 1
            ]);
        return back()->with('success', 'BDE Meeting Delete!');
    }

    public function Bde_Meetings_Archive(Request $request)
    {
        $meeting = DB::table('meetings')
            ->where('user_type', 4)
            ->where('type', 1)
            ->where('archive', 1)
            ->where('user_id', Crypt::decrypt($request->bdeid))
            ->get();

        $user = DB::table('bdes')
            ->where('id', Crypt::decrypt($request->bdeid))
            ->where('archive', 0)
            ->where('status', 0)
            ->first();


        return view('backend.sales.bde-archive-meeting', compact('user', 'meeting'));
    }

    public function Bde_Meetings_Active($id)
    {
        $active = DB::table('meetings')
            ->where('id', Crypt::decrypt($id))
            ->where('user_type', 4)
            ->where('type', 1)
            ->update([
                'archive' => 0
            ]);
        return back()->with('success', 'BDE Meeting Active!');
    }

    public function Bde_ColdCall(Request $request)
    {
        $meeting = DB::table('meetings')
            ->where('user_type', 4)
            ->where('type', 0)
            ->where('archive', 0)
            ->where('user_id', Crypt::decrypt($request->bdeid))
            ->get();

        $user = DB::table('bdes')
            ->where('id', Crypt::decrypt($request->bdeid))
            ->where('archive', 0)
            ->where('status', 0)
            ->first();

        return view('backend.sales.bde-coldcall', compact('user', 'meeting'));
    }

    public function Bde_ColdCall_Details(Request $request)
    {
        $meeetingData = DB::table('meetings')
            ->where('id', Crypt::decrypt($request->meetingid))
            ->where('user_type', 4)
            ->where('type', 0)
            ->where('archive', 0)
            ->first();

        $temp_service = DB::table('service_temp')->where('meetingid', Crypt::decrypt($request->meetingid))->get();
        /**************************payment*************************************************/
        if (DB::table('payment_details')->where('meeting_id', $meeetingData->id)->exists()) {
            $payment = DB::table('payment_details')->where('meeting_id', $meeetingData->id)->get();
        } else {
            $payment = '';
        }
        /**************************end payment*********************************************/

        $user = DB::table('bdes')
            ->where('id', $meeetingData->user_id)
            ->where('archive', 0)
            ->where('status', 0)
            ->first();

        return view('backend.sales.bde-coldcall-details', compact('meeetingData', 'user', 'payment', 'temp_service'));
    }
    public function Bde_ColdCall_Delete(Request $request)
    {
        $delete = DB::table('meetings')
            ->where('id', Crypt::decrypt($request->meetingid))
            ->where('user_type', 4)
            ->where('type', 0)
            ->update([
                'archive' => 1
            ]);
        return back()->with('success', 'BDE Cold Call Delete!');
    }

    public function Bde_ColdCall_Archive(Request $request)
    {
        $meeting = DB::table('meetings')
            ->where('user_type', 4)
            ->where('type', 0)
            ->where('archive', 1)
            ->where('user_id', Crypt::decrypt($request->bdeid))
            ->get();

        $user = DB::table('bdes')
            ->where('id', Crypt::decrypt($request->bdeid))
            ->where('archive', 0)
            ->where('status', 0)
            ->first();
        return view('backend.sales.bde-coldcall-archive', compact('user', 'meeting'));
    }

    public function Bde_ColdCall_Active(Request $request)
    {
        $active = DB::table('meetings')
            ->where('id', Crypt::decrypt($request->meetingid))
            ->where('user_type', 4)
            ->where('type', 0)
            ->update([
                'archive' => 0
            ]);
        return back()->with('success', 'BDE Cold Call Active!');
    }
}
