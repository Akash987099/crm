<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Telemarketing;
use App\Models\backend\Services;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Yajra\DataTables\DataTables;

class telemarketController extends Controller
{
    public function Telemarketing(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tele_person')
                ->where('archive', 0)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1 telemarketing" title="View Data" data-id=' . Crypt::encrypt($row->id) . '><i class="bi bi-eye"></i></a>';
                    $btn .= '<a class="btn btn-warning btn-sm m-1" title="Lead Generate" href="' . route('backend.telemarket.assign-meeting', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-calendar-event"></i></a>';
                    $btn .= '<a class="btn btn-warning btn-sm m-1" title="Calls History" href="' . route('backend.tele.call-history', ['teleid' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-telephone-fill"></i></a>';
                    $btn .= '<a class="btn btn-primary btn-sm m-1" title="Update" href="' . url('admin/edit-telemarketing', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                    $btn .= '<a class="btn btn-danger btn-sm m-1" title="Archive" href="' . url('admin/delete-tele', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.users.telemarketing');
    }


    public function view_details_telemarketing_modal(Request $request)
    {
        $teleID = Crypt::decrypt($request->id);
        $data = Telemarketing::find($teleID);
        return response()->json(array('data' => $data));
    }





    public function create_telemarketing()
    {
        $services = Services::all();
        return view('backend.users.add-telemarketing', compact('services'));
    }

    public function AddTelemarketing(Request $request)
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

    public function Edit_telemarketing($id)
    {
        $tid = Crypt::decrypt($id);
        $teleAll = Telemarketing::find($tid);
        return view('backend.users.edit-telemarketing', compact('teleAll'));
    }

    public function Update_telemarketing(Request $request)
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

            $update->company_id = Session::get('company_id');
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
            $update->company_id = Session::get('company_id');
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
            return redirect('admin/telemarketing')->with('success', 'User update successfully!');
        }
    }

    public function Delete_telemarketing($id)
    {
        $delete_id = Crypt::decrypt($id);
        $delete = Telemarketing::find($delete_id);
        // $delete->archive = 1;
        $delete->delete();
        return back()->with('success', 'Record delete successfully!');
    }
    public function Archive_telemarketing()
    {
        return view('backend.users.archive-telemarketing');
    }

    public function Archive_telemarketing_list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tele_person')
                ->where('archive', 1)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm text-danger m-1" href="' . url('admin/active-telemarketing', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-arrow-clockwise"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }



    public function Active_telemarketing($id)
    {
        $archive_id = Crypt::decrypt($id);
        $activate = Telemarketing::find($archive_id);
        $activate->archive = 0;
        $activate->save();
        return back()->with('success', 'Record Activated successfully!');
    }
    //////////////////////////END TELEMARKETING USER///////////////////////////////////////////////
    public function Change_passwordT(Request $request)
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

    public function Telemarket_Assign_Meeting($id)
    {
        $assign_meeting = DB::table('clients')->where('user_id', Crypt::decrypt($id))->where('archive', 0)->get();
        $telemarket = DB::table('tele_person')->where('id', Crypt::decrypt($id))->where('archive', 0)->first();

        return view('backend.meeting-assign.assign-meeting', compact('assign_meeting', 'telemarket'));
    }
    public function TelemarketAssignMeeting_Details(Request $request)
    {
        if (isset($request->assignid)) {
            $meeetingData = DB::table('clients')->where('id', Crypt::decrypt($request->assignid))->where('archive', 0)->first();
            $user = DB::table('tele_person')->where('id', $meeetingData->user_id)->where('archive', 0)->first();
            return view('backend.meeting-assign.meeting-assign-details', compact('meeetingData', 'user'));
        }
    }

    public function TelemarketAssignMeeting_Delete(Request $request)
    {
        $assign_meeting = DB::table('clients')
            ->where('id', Crypt::decrypt($request->assignid))
            ->update([
                'archive' => 1
            ]);
        if ($assign_meeting) {
            return back()->with('success', 'Assign Meeting Archive Successfully!');
        }
    }

    public function TelemarketAssignMeeting_Archive(Request $request)
    {

        $assign_meeting = DB::table('clients')
            ->where('user_type', 0)
            ->where('archive', 1)
            ->where('user_id', Crypt::decrypt($request->marketid))
            ->get();

        $user = DB::table('tele_person')
            ->where('id', Crypt::decrypt($request->marketid))
            ->where('archive', 0)->first();
        return view('backend.meeting-assign.archive-assign-meeting', compact('user', 'assign_meeting'));
    }

    public function TelemarketAssignMeeting_Active($id)
    {
        $assign_meeting = DB::table('clients')
            ->where('id', Crypt::decrypt($id))
            ->update([
                'archive' => 0
            ]);
        if ($assign_meeting) {
            return back()->with('success', 'Assign Meeting Activate!');
        }
    }

    public function TeleCall_History(Request $request)
    {
        $user = DB::table('tele_person')
            ->where('id', Crypt::decrypt($request->teleid))
            ->where('archive', 0)->first();
        $data = DB::table('calling')->where('user_id', Crypt::decrypt($request->teleid))->where('archive', 0)->get();

        return view('backend.users.telemarket-call-history', compact('data', 'user'));
    }
}
