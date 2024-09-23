<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\marketend\Meeting;
use App\Models\marketend\Account;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\backend\Services;
use Yajra\DataTables\DataTables;

class Meeting_Controller extends Controller
{
    public function ViewMeeting(Request $request)
    {

        if ($request->ajax()) {
            $data = DB::table('meetings')
                ->where('company_id', Session::get('company_id'))
                ->where('archive', 0)
                ->where('user_type', 1)
                ->where('type', 1)
                ->get();

            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1 text-white" title="View Data" href="' . route('backend.meeting-details', ['meetingid' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-eye"></i></a>';
                    if ($row->status == 1) {
                        $btn .= '<a class="btn btn-warning btn-sm m-1 text-white" title="Payment Details" href="' . route('backend.bill-pay', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-cash"></i></a>';
                    }
                    if (!DB::table('payment_details')->where('meeting_id', $row->id)->exists()) {
                        $btn .= '<a class="btn btn-primary btn-sm m-1" title="Update" href="' . route('backend.edit-meeting', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                        $btn .= '<a class="btn btn-info btn-sm m-1" title="Add Service" href="' . route('backend.add-meeting-service', ['meetingid' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-plus-circle-fill"></i></a>';
                    }

                    $btn .= '<a class="btn btn-danger btn-sm m-1" title="Delete" href="' . route('backend.delete-meeting', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.meeting.view-meeting');
    }




    public function Add_meeting()
    {
        return view('backend.meeting.add-meeting');
    }
    public function CreateMeeting(Request $request)
    {
        $request->validate([
            'client_name' => 'required|unique:meetings,client_name',
            'phone' => 'required|numeric|min:10',
            'email' => 'email|unique:meetings,email',
            'status' => 'required|not_in:0',
        ]);

        $add_meeting = new Meeting();

        if (isset($request->status) && $request->status == 1) {

            $request->validate([
                'visiting_card' => 'required|mimes:jpeg,jpg,png',
                'shop_img' => 'required|mimes:jpeg,jpg,png',
                'amount_pic' => 'required|mimes:jpeg,jpg,png'
            ]);

            $path = "assets/uploads/meeting/visitingCard/" . $request->visiting_card;
            $path2 = "assets/uploads/meeting/shopImage/" . $request->shop_img;
            $path3 = "assets/uploads/meeting/shopImage/" . $request->amount_pic;

            if (File::exists($path) && File::exists($path2) && File::exists($path3)) {
                File::delete($path);
                File::delete($path2);
                File::delete($path3);
            }
            $file = $request->file('visiting_card');
            $exten = $file->getClientOriginalExtension();
            $visiting_rename = time() . rand() . "." . $exten;
            $file->move("assets/uploads/meeting/visitingCard/", $visiting_rename);

            $file2 = $request->file('shop_img');
            $exten2 = $file2->getClientOriginalExtension();
            $shopimg = time() . rand() . "." . $exten2;
            $file2->move("assets/uploads/meeting/shopImage/", $shopimg);

            $file3 = $request->file('amount_pic');
            $exten3 = $file3->getClientOriginalExtension();
            $amount_rename = time() . rand() . "." . $exten3;
            $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

            $add_meeting->company_id = Session::get('company_id');
            $add_meeting->user_type = 1;
            $add_meeting->type = 1;
            $add_meeting->client_name = $request->client_name;
            $add_meeting->company_name = $request->company_name;
            $add_meeting->phone = $request->phone;
            $add_meeting->email = $request->email;
            $add_meeting->keywords = $request->keywords;
            $add_meeting->visiting_card = $visiting_rename;
            $add_meeting->shop_img = $shopimg;
            $add_meeting->status = $request->status;
            $add_meeting->amount_pic = $amount_rename;
            $add_meeting->address = $request->address;
            $add_meeting->remark = $request->remark;
            $add_meeting->created_date = date('d-m-Y');
            $add_meeting->created_time = time();
            $add_meeting->ip_address = $_SERVER['REMOTE_ADDR'];
            $saveCall = $add_meeting->save();
        } elseif (isset($request->status) && $request->status == 2) {
            if ($request->followup_date == '') {
                return back()->with('faild', 'Please select follow up date!');
            } else {
                $add_meeting->company_id = Session::get('company_id');
                $add_meeting->user_type = 1;
                $add_meeting->type = 1;
                $add_meeting->client_name = $request->client_name;
                $add_meeting->company_name = $request->company_name;
                $add_meeting->phone = $request->phone;
                $add_meeting->email = $request->email;
                $add_meeting->keywords = $request->keywords;
                $add_meeting->followup_date = $request->followup_date;
                $add_meeting->residual = '';
                $add_meeting->status = $request->status;
                $add_meeting->address = $request->address;
                $add_meeting->remark = $request->remark;
                $add_meeting->created_date = date('d-m-Y');
                $add_meeting->created_time = time();
                $add_meeting->ip_address = $_SERVER['REMOTE_ADDR'];
                $saveCall = $add_meeting->save();
            }
        } elseif (isset($request->status) && $request->status == 3) {
            if ($request->residual == '') {
                return back()->with('faild', 'Please select residual date!');
            } else {
                $add_meeting->company_id = Session::get('company_id');
                $add_meeting->user_type = 1;
                $add_meeting->type = 1;
                $add_meeting->client_name = $request->client_name;
                $add_meeting->company_name = $request->company_name;
                $add_meeting->phone = $request->phone;
                $add_meeting->email = $request->email;
                $add_meeting->keywords = $request->keywords;
                $add_meeting->followup_date = '';
                $add_meeting->residual = $request->residual;
                $add_meeting->status = $request->status;
                $add_meeting->address = $request->address;
                $add_meeting->remark = $request->remark;
                $add_meeting->created_date = date('d-m-Y');
                $add_meeting->created_time = time();
                $add_meeting->ip_address = $_SERVER['REMOTE_ADDR'];
                $saveCall = $add_meeting->save();
            }
        }
        if ($saveCall) {
            return back()->with('success', 'The deal has been closed, now add more services.');
        }
    }




    public function Edit_meeting_Data($id)
    {
        $edit_meeting = Meeting::find(Crypt::decrypt($id));
        return view('backend.meeting.edit-meeting', compact('edit_meeting'));
    }

    public function Update_meeting_Data(Request $request)
    {
        $update_meting = Meeting::find(Crypt::decrypt($request->meetingid));

        $request->validate([
            'client_name' => 'required',
            'phone' => 'required|numeric|min:10',
            'status' => 'required|not_in:0',
            'visiting_card' => 'mimes:jpeg,jpg,png',
            'shop_img' => 'mimes:jpeg,jpg,png',
            'amount_pic' => 'mimes:jpeg,jpg,png'
        ]);
        if ($request->email != $update_meting->email) {
            $request->validate([
                'email' => 'email|unique:meetings,email',
            ]);
        }

        if (isset($request->status) && $request->status == 1) {

            if ($request->visiting_card != "" && $request->shop_img != "" && $request->amount_pic != "") {
                $path = "assets/uploads/meeting/visitingCard/" . $update_meting->visiting_card;
                $path2 = "assets/uploads/meeting/shopImage/" . $update_meting->shop_img;
                $path3 = "assets/uploads/meeting/amount_pic/" . $update_meting->amount_pic;

                if (File::exists($path) && File::exists($path2) && File::exists($path3)) {
                    File::delete($path);
                    File::delete($path2);
                    File::delete($path3);
                }
                $file = $request->file('visiting_card');
                $exten = $file->getClientOriginalExtension();
                $visiting_rename = time() . rand() . "." . $exten;
                $file->move("assets/uploads/meeting/visitingCard/", $visiting_rename);

                $file2 = $request->file('shop_img');
                $exten2 = $file2->getClientOriginalExtension();
                $shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $shopimg);

                $file3 = $request->file('amount_pic');
                $exten3 = $file3->getClientOriginalExtension();
                $amount_rename = time() . rand() . "." . $exten3;
                $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

                $update_meting->company_id = Session::get('company_id');
                $update_meting->user_type = 1;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->visiting_card = $visiting_rename;
                $update_meting->shop_img = $shopimg;
                $update_meting->status = $request->status;
                $update_meting->amount_pic = $amount_rename;
                $update_meting->address = $request->address;
                $update_meting->remark = $request->remark;
                $saveCall = $update_meting->save();
            } elseif ($request->visiting_card != "" && $request->shop_img == "" && $request->amount_pic == "") {
                $path = "assets/uploads/meeting/visitingCard/" . $update_meting->visiting_card;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('visiting_card');
                $exten = $file->getClientOriginalExtension();
                $visiting_rename = time() . rand() . "." . $exten;
                $file->move("assets/uploads/meeting/visitingCard/", $visiting_rename);

                $update_meting->company_id = Session::get('company_id');
                $update_meting->user_type = 1;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->visiting_card = $visiting_rename;
                $update_meting->status = $request->status;
                $update_meting->address = $request->address;
                $update_meting->remark = $request->remark;
                $saveCall = $update_meting->save();
            } elseif ($request->shop_img != "" && $request->visiting_card == "" && $request->amount_pic == "") {
                $path2 = "assets/uploads/meeting/shopImage/" . $update_meting->shop_img;

                if (File::exists($path2)) {
                    File::delete($path2);
                }
                $file2 = $request->file('shop_img');
                $exten2 = $file2->getClientOriginalExtension();
                $shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $shopimg);

                $update_meting->company_id = Session::get('company_id');
                $update_meting->user_type = 1;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->shop_img = $shopimg;
                $update_meting->status = $request->status;
                $update_meting->address = $request->address;
                $update_meting->remark = $request->remark;
                $saveCall = $update_meting->save();
            } elseif ($request->amount_pic != "" && $request->shop_img == "" && $request->visiting_card == "") {
                $path3 = "assets/uploads/meeting/amount_pic/" . $update_meting->amount_pic;
                if (File::exists($path3)) {
                    File::delete($path3);
                }

                $file3 = $request->file('amount_pic');
                $exten3 = $file3->getClientOriginalExtension();
                $amount_rename = time() . rand() . "." . $exten3;
                $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

                $update_meting->company_id = Session::get('company_id');
                $update_meting->user_type = 1;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->status = $request->status;
                $update_meting->amount_pic = $amount_rename;
                $update_meting->address = $request->address;
                $update_meting->remark = $request->remark;
                $saveCall = $update_meting->save();
            } elseif ($request->visiting_card != "" && $request->shop_img != "" && $request->amount_pic == "") {
                $path = "assets/uploads/meeting/visitingCard/" . $update_meting->visiting_card;
                $path2 = "assets/uploads/meeting/shopImage/" . $update_meting->shop_img;

                if (File::exists($path) && File::exists($path2)) {
                    File::delete($path);
                    File::delete($path2);
                }
                $file = $request->file('visiting_card');
                $exten = $file->getClientOriginalExtension();
                $visiting_rename = time() . rand() . "." . $exten;
                $file->move("assets/uploads/meeting/visitingCard/", $visiting_rename);

                $file2 = $request->file('shop_img');
                $exten2 = $file2->getClientOriginalExtension();
                $shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $shopimg);

                $update_meting->company_id = Session::get('company_id');
                $update_meting->user_type = 1;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->visiting_card = $visiting_rename;
                $update_meting->shop_img = $shopimg;
                $update_meting->status = $request->status;
                $update_meting->address = $request->address;
                $update_meting->remark = $request->remark;
                $saveCall = $update_meting->save();
            } elseif ($request->visiting_card != "" && $request->amount_pic != "" && $request->shop_img == "") {
                $path = "assets/uploads/meeting/visitingCard/" . $update_meting->visiting_card;
                $path3 = "assets/uploads/meeting/amount_pic/" . $update_meting->amount_pic;

                if (File::exists($path) && File::exists($path3)) {
                    File::delete($path);
                    File::delete($path3);
                }
                $file = $request->file('visiting_card');
                $exten = $file->getClientOriginalExtension();
                $visiting_rename = time() . rand() . "." . $exten;
                $file->move("assets/uploads/meeting/visitingCard/", $visiting_rename);

                $file3 = $request->file('amount_pic');
                $exten3 = $file3->getClientOriginalExtension();
                $amount_rename = time() . rand() . "." . $exten3;
                $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

                $update_meting->company_id = Session::get('company_id');
                $update_meting->user_type = 1;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->visiting_card = $visiting_rename;
                $update_meting->status = $request->status;
                $update_meting->amount_pic = $amount_rename;
                $update_meting->address = $request->address;
                $update_meting->remark = $request->remark;
                $saveCall = $update_meting->save();
            } elseif ($request->amount_pic != "" && $request->shop_img != "" && $request->visiting_card == "") {
                $path2 = "assets/uploads/meeting/shopImage/" . $update_meting->shop_img;
                $path3 = "assets/uploads/meeting/amount_pic/" . $update_meting->amount_pic;

                if (File::exists($path2) && File::exists($path3)) {
                    File::delete($path2);
                    File::delete($path3);
                }


                $file2 = $request->file('shop_img');
                $exten2 = $file2->getClientOriginalExtension();
                $shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $shopimg);

                $file3 = $request->file('amount_pic');
                $exten3 = $file3->getClientOriginalExtension();
                $amount_rename = time() . rand() . "." . $exten3;
                $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

                $update_meting->company_id = Session::get('company_id');
                $update_meting->user_type = 1;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->shop_img = $shopimg;
                $update_meting->status = $request->status;
                $update_meting->amount_pic = $amount_rename;
                $update_meting->address = $request->address;
                $update_meting->remark = $request->remark;
                $saveCall = $update_meting->save();
            } else {
                $update_meting->company_id = Session::get('company_id');
                $update_meting->user_type = 1;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->status = $request->status;
                $update_meting->address = $request->address;
                $update_meting->remark = $request->remark;
                $saveCall = $update_meting->save();
            }
        } elseif (isset($request->status) && $request->status == 2) {
            if ($request->followup_date == '') {
                return back()->with('faild', 'Please select follow up date!');
            } else {
                $update_meting->company_id = Session::get('company_id');
                $update_meting->user_type = 1;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->followup_date = $request->followup_date;
                $update_meting->residual = '';
                $update_meting->status = $request->status;
                $update_meting->address = $request->address;
                $update_meting->remark = $request->remark;
                $saveCall = $update_meting->save();
            }
        } elseif (isset($request->status) && $request->status == 3) {
            if ($request->residual == '') {
                return back()->with('faild', 'Please select residual date!');
            } else {
                $update_meting->company_id = Session::get('company_id');
                $update_meting->user_type = 1;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->followup_date = '';
                $update_meting->residual = $request->residual;
                $update_meting->status = $request->status;
                $update_meting->address = $request->address;
                $update_meting->remark = $request->remark;
                $saveCall = $update_meting->save();
            }
        }
        if ($saveCall) {
            return redirect(route('backend.view-meeeting'))->with('success', 'Meeting update successfully!');
        }
    }


    public function DeleteMeeting_Data($id)
    {
        $delete_id = Crypt::decrypt($id);
        $meeting_delete = Meeting::find($delete_id);
        $meeting_delete->archive = 1;
        $meeting_delete->save();
        return back()->with('success', 'Meeting Delete Successfully!');
    }

    public function View_archive_meeting(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('meetings')
                ->where('archive', 1)
                ->where('company_id', Session::get('company_id'))
                ->where('user_type', 1)
                ->where('type', 1)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1 text-white" href="' . route('backend.active-meeting', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-arrow-clockwise"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.meeting.view-archive-meeting');
    }

    public function ActiveMeeting($id)
    {
        $active_id = Crypt::decrypt($id);
        $active_meeting = Meeting::find($active_id);
        $active_meeting->archive = 0;
        $active_meeting->save();
        return back()->with('success', 'Meeting Activated');
    }



    public function AddMeetingService(Request $request)
    {
        $meeting = DB::table('meetings')
            ->where('company_id', Session::get('company_id'))
            ->where('archive', 0)
            ->where('user_type', 1)
            ->where('type', 1)
            ->where('id', Crypt::decrypt($request->meetingid))
            ->first();

        $temp_service = DB::table('service_temp')->where('company_id', Session::get('company_id'))->where('meetingid', Crypt::decrypt($request->meetingid))->get();

        return view('backend.meeting.add-meeting-service', compact('meeting', 'temp_service'));
    }

    public function AdminMeetingServiceSubmit(Request $request)
    {

        if ($request->serviceid != "" && $request->price != "" && $request->meetingid != "") {

            $temp_service = DB::table('service_temp')->insert([
                'company_id' => Session::get('company_id'),
                'meetingid' => Crypt::decrypt($request->meetingid),
                'serviceid' => $request->serviceid,
                'price' => $request->price,
                'tenure' => $request->tenure,
                'created_date' => date('d-m-Y H:i:s'),
                'created_time' => time(),
                'ip' => $_SERVER['REMOTE_ADDR']
            ]);

            if ($temp_service) {
                if ($request->discount != 0) {

                    $price = DB::table('service_temp')->where('company_id', Session::get('company_id'))->where('meetingid', Crypt::decrypt($request->meetingid))->sum('price');
                    $total  = ($price / 100) * $request->discount;

                    DB::table('meetings')
                        ->where('company_id', Session::get('company_id'))
                        ->where('archive', 0)
                        ->where('user_type', 1)
                        ->where('type', 1)
                        ->where('id', Crypt::decrypt($request->meetingid))
                        ->update([
                            'temp_value' => $total,
                            'blance' => $total
                        ]);
                } else {
                    $total = DB::table('service_temp')->where('company_id', Session::get('company_id'))->where('meetingid', Crypt::decrypt($request->meetingid))->sum('price');
                    DB::table('meetings')
                        ->where('company_id', Session::get('company_id'))
                        ->where('archive', 0)
                        ->where('user_type', 1)
                        ->where('type', 1)
                        ->where('id', Crypt::decrypt($request->meetingid))
                        ->update([
                            'temp_value' => $total,
                            'blance' => $total
                        ]);
                }
            }
        }
        return response()->json(['status' => 200]);
    }

    public function AdminMeetingServiceDiscount(Request $request)
    {
        if (isset($request->meetingid) && $request->meetingid != "") {
            $total = $request->total;
            $dis = $request->discount;

            $dis_price  = ($total / 100) * $dis;
            $total_amt =  $total - $dis_price;

            DB::table('meetings')
                ->where('company_id', Session::get('company_id'))
                ->where('archive', 0)
                ->where('user_type', 1)
                ->where('type', 1)
                ->where('id', Crypt::decrypt($request->meetingid))
                ->update([
                    'blance' => $total_amt,
                    'temp_value' => $total_amt,
                    'discount' => $dis
                ]);
            return back();
        }
    }

    public function AdminMeetingServiceDelete(Request $request)
    {
        if (isset($request->serviceid) && isset($request->meetingid)) {

            $service_delete = DB::table('service_temp')->where('id', Crypt::decrypt($request->serviceid))->where('meetingid', Crypt::decrypt($request->meetingid))->delete();

            if ($service_delete) {
                $total_amt = DB::table('service_temp')->where('meetingid', Crypt::decrypt($request->meetingid))->sum('price');
                $meeting_data = DB::table('meetings')->where('id', Crypt::decrypt($request->meetingid))->where('archive', 0)->where('user_type', 1)->where('type', 1)->where('company_id', Session::get('company_id'))->first();

                $dis_price  = ($total_amt / 100) * $meeting_data->discount;
                $total =  $total_amt - $dis_price;

                DB::table('meetings')
                    ->where('id', Crypt::decrypt($request->meetingid))
                    ->where('archive', 0)
                    ->where('user_type', 1)
                    ->where('type', 1)
                    ->where('company_id', Session::get('company_id'))
                    ->update([
                        'blance' => $total,
                        'temp_value' => $total,
                    ]);

                if ($total_amt == 0) {
                    DB::table('meetings')
                        ->where('id', Crypt::decrypt($request->meetingid))
                        ->where('archive', 0)
                        ->where('user_type', 1)
                        ->where('type', 1)
                        ->where('company_id', Session::get('company_id'))
                        ->update([
                            'temp_value' => 0,
                            'blance' => 0,
                            'discount' => 0
                        ]);
                }
            }
        }
        return response()->json(['status' => 200]);
    }

    public function AdminMeetingDetails(Request $request)
    {

        if (isset($request->meetingid) && $request->meetingid != "") {
            $meeting_data = Meeting::where('id', Crypt::decrypt($request->meetingid))->first();
            $temp_service = DB::table('service_temp')->where('meetingid', Crypt::decrypt($request->meetingid))->where('company_id', Session::get('company_id'))->get();
            $payment = DB::table('payment_details')->where('meeting_id', Crypt::decrypt($request->meetingid))->get();
        }
        return view('backend.meeting.meeting-details', compact('meeting_data', 'temp_service', 'payment'));
    }
}
