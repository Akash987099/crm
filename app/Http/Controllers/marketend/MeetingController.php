<?php

namespace App\Http\Controllers\marketend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\marketend\Meeting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\backend\Services;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Request as Input;

class MeetingController extends Controller
{
    public function All_Meeting(Request $request)
    {

        if ($request->ajax()) {
            $data = DB::table('meetings')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 0)
                ->where('type', 1)
                ->where('user_type', 2)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1 text-white meeting_id" title="View Details" href="' . route('market.view-meeting-details', ['meetingid' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-eye"></i></a>';
                    if ($row->status == 1) {
                        $btn .= '<a class="btn btn-warning btn-sm m-1 text-white" title="Payment" href="' . route('market.will-pay', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-cash"></i></a>';
                    }
                    if ($row->status == 1) {
                        if (!DB::table('payment_details')->where('meeting_id', $row->id)->exists()) {
                            $btn .= '<a class="btn btn-primary btn-sm m-1" title="Edit" href="' . url('marketing/edit-meeting', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                            $btn .= '<a class="btn btn-info btn-sm m-1" title="Add Services" href="' . route('market.add-meeting-service', ['meetingid' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-plus-circle-fill"></i></a>';
                        }
                    }

                    $btn .= '<a class="btn btn-danger btn-sm m-1" title="Delete" href="' . url('marketing/meeting-delete', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('marketend.view-meeting');
    }

    public function MeetingServiceAdd(Request $request)
    {

        $meeting = DB::table('meetings')
            ->where('user_id', Session::get('user_id'))
            ->where('archive', 0)
            ->where('type', 1)
            ->where('user_type', 2)
            ->where('id', Crypt::decrypt($request->meetingid))
            ->first();

        $temp_service = DB::table('service_temp')->where('user_id', Session::get('user_id'))->where('meetingid', Crypt::decrypt($request->meetingid))->get();

        return view('marketend.addMeeting-service', compact('meeting', 'temp_service'));
    }

    public function MeetingServiceSubmit(Request $request)
    {
        if ($request->serviceid != "" && $request->price != "" && $request->meetingid != "") {

            $temp_service = DB::table('service_temp')->insert([
                'user_id' => Session::get('user_id'),
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
                    $price = DB::table('service_temp')->where('user_id', Session::get('user_id'))->where('meetingid', Crypt::decrypt($request->meetingid))->sum('price');
                    $total  = ($price / 100) * $request->discount;

                    DB::table('meetings')
                        ->where('user_id', Session::get('user_id'))
                        ->where('archive', 0)
                        ->where('user_type', 2)
                        ->where('type', 1)
                        ->where('id', Crypt::decrypt($request->meetingid))
                        ->update([
                            'temp_value' => $total,
                            'blance' => $total
                        ]);
                } else {
                    $total = DB::table('service_temp')->where('user_id', Session::get('user_id'))->where('meetingid', Crypt::decrypt($request->meetingid))->sum('price');
                    DB::table('meetings')
                        ->where('user_id', Session::get('user_id'))
                        ->where('archive', 0)
                        ->where('user_type', 2)
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


    public function DeleteMeeting_Service(Request $request)
    {
        if (isset($request->serviceid) && isset($request->meetingid)) {

            $service_delete = DB::table('service_temp')->where('id', Crypt::decrypt($request->serviceid))->where('meetingid', Crypt::decrypt($request->meetingid))->delete();

            if ($service_delete) {
                $total_amt = DB::table('service_temp')->where('meetingid', Crypt::decrypt($request->meetingid))->sum('price');
                $meeting_data = DB::table('meetings')->where('id', Crypt::decrypt($request->meetingid))->where('archive', 0)->where('user_type', 2)->where('type', 1)->where('user_id', Session::get('user_id'))->first();

                $dis_price  = ($total_amt / 100) * $meeting_data->discount;
                $total =  $total_amt - $dis_price;

                DB::table('meetings')
                    ->where('id', Crypt::decrypt($request->meetingid))
                    ->where('archive', 0)
                    ->where('user_type', 2)
                    ->where('type', 1)
                    ->where('user_id', Session::get('user_id'))
                    ->update([
                        'blance' => $total
                    ]);

                if ($total_amt == 0) {
                    DB::table('meetings')
                        ->where('id', Crypt::decrypt($request->meetingid))
                        ->where('archive', 0)
                        ->where('user_type', 2)
                        ->where('type', 1)
                        ->where('user_id', Session::get('user_id'))
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


    public function MeetingServiceDiscount(Request $request)
    {
        if (isset($request->meetingid) && $request->meetingid != "") {
            $total = $request->total;
            $dis = $request->discount;

            $dis_price  = ($total / 100) * $dis;
            $total_amt =  $total - $dis_price;

            DB::table('meetings')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 0)
                ->where('user_type', 2)
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


    public function ViewMeetingDetails(Request $request)
    {
        if (isset($request->meetingid) && $request->meetingid != "") {
            $meeting_data = Meeting::where('id', Crypt::decrypt($request->meetingid))->first();
            $temp_service = DB::table('service_temp')->where('meetingid', Crypt::decrypt($request->meetingid))->where('user_id', Session::get('user_id'))->get();
            $payment = DB::table('payment_details')->where('meeting_id', Crypt::decrypt($request->meetingid))->get();
        }
        return view('marketend.meeting-details', compact('meeting_data', 'temp_service', 'payment'));
    }


    public function Add_Meeting()
    {
        return view('marketend.add-meeting');
    }
    public function Create_Meeting(Request $request)
    {
        if (DB::table('meetings')->where('clientid', Crypt::decrypt($request->cltid))->exists()) {
            $meetingid = DB::table('meetings')->where('clientid', Crypt::decrypt($request->cltid))->where('archive', 0)->first();
            $update_meeting = Meeting::find($meetingid->id);

            if ($request->status == 0) {
                return back()->with('faild', 'Please select status');
            }

            if (isset($request->status) && $request->status == 1) {

                if ($request->visiting_card == '') {
                    return back()->with('faild', 'Please Visiting card image upload');
                } elseif ($request->shop_img == '') {
                    return back()->with('faild', 'Please shop front image upload');
                } elseif ($request->amount_pic == '') {
                    return back()->with('faild', 'Please amount image upload');
                } else {
                    $path = "assets/uploads/meeting/visitingCard/" . $request->visiting_card;
                    $path2 = "assets/uploads/meeting/shopImage/" . $request->shop_img;
                    $path3 = "assets/uploads/meeting/amount_pic/" . $request->amount_pic;
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
                    $rename_shopimg = time() . rand() . "." . $exten2;
                    $file2->move("assets/uploads/meeting/shopImage/", $rename_shopimg);

                    $file3 = $request->file('amount_pic');
                    $exten3 = $file3->getClientOriginalExtension();
                    $amount_rename = time() . rand() . "." . $exten3;
                    $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

                    $update_meeting->user_id = Session::get('user_id');
                    $update_meeting->clientid = Crypt::decrypt($request->cltid);
                    $update_meeting->user_type = 2;
                    $update_meeting->type = 1;
                    $update_meeting->client_name = $request->client_name;
                    $update_meeting->company_name = $request->company_name;
                    $update_meeting->phone = $request->phone;
                    $update_meeting->email = $request->email;
                    $update_meeting->keywords = $request->keywords;
                    $update_meeting->address = $request->address;
                    $update_meeting->visiting_card = $visiting_rename;
                    $update_meeting->shop_img = $rename_shopimg;
                    $update_meeting->amount_pic = $amount_rename;
                    $update_meeting->status = $request->status;
                    $update_meeting->payment_mode = $request->payment_mode;
                    $update_meeting->residual = '';
                    $update_meeting->followup_date = '';
                    $update_meeting->remark = $request->remark;
                    $save_meeting = $update_meeting->save();
                }
            } elseif (isset($request->status) && $request->status == 2) {
                if ($request->followup_date == '') {
                    return back()->with('faild', 'Please select follow up date!');
                } else {
                    $update_meeting->user_id = Session::get('user_id');
                    $update_meeting->clientid = Crypt::decrypt($request->cltid);
                    $update_meeting->user_type = 2;
                    $update_meeting->type = 1;
                    $update_meeting->client_name = $request->client_name;
                    $update_meeting->company_name = $request->company_name;
                    $update_meeting->phone = $request->phone;
                    $update_meeting->email = $request->email;
                    $update_meeting->followup_date = $request->followup_date;
                    $update_meeting->residual = '';
                    $update_meeting->status = $request->status;
                    $save_meeting = $update_meeting->save();
                }
            } elseif (isset($request->status) && $request->status == 3) {
                if ($request->residual == '') {
                    return back()->with('faild', 'Please select residual date!');
                }
                $update_meeting->user_id = Session::get('user_id');
                $update_meeting->clientid = Crypt::decrypt($request->cltid);
                $update_meeting->user_type = 2;
                $update_meeting->type = 1;
                $update_meeting->client_name = $request->client_name;
                $update_meeting->company_name = $request->company_name;
                $update_meeting->phone = $request->phone;
                $update_meeting->email = $request->email;
                $update_meeting->residual = $request->residual;
                $update_meeting->followup_date = '';
                $update_meeting->status = $request->status;
                $save_meeting = $update_meeting->save();
            }
            if ($save_meeting) {
                if ($request->status == 1) {
                    DB::table('clients')->where('id', Crypt::decrypt($request->cltid))
                        ->update(['meeting_status' => $request->status]);
                    return redirect(route('market.view-attend-meeting'))->with('success', 'The deal has been closed, now add more services.');
                } else {
                    DB::table('clients')->where('id', Crypt::decrypt($request->cltid))
                        ->update(['meeting_status' => $request->status]);
                    return redirect(route('market.View-assign-meating'));
                }
            }
        } else {
            $request->validate([
                'client_name' => 'required',
                'company_name' => 'required',
                'phone' => 'required|numeric|digits:10',
                'status' => 'required'
            ]);

            $add_meeting = new Meeting();
            if (isset($request->status) && $request->status == 1) {

                if ($request->visiting_card == '') {
                    return back()->with('faild', 'Please upload visiting cart image!');
                } elseif ($request->shop_img == '') {
                    return back()->with('faild', 'Please upload shop front image!');
                } elseif ($request->amount_pic == "") {
                    return back()->with('faild', 'Please upload amount image!');
                } else {

                    $path = "assets/uploads/meeting/visitingCard/" . $request->visiting_card;
                    $path2 = "assets/uploads/meeting/shopImage/" . $request->shop_img;
                    $path3 = "assets/uploads/meeting/amount_pic/" . $request->amount_pic;
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
                    $rename_shopimg = time() . rand() . "." . $exten2;
                    $file2->move("assets/uploads/meeting/shopImage/", $rename_shopimg);

                    $file3 = $request->file('amount_pic');
                    $exten3 = $file3->getClientOriginalExtension();
                    $amount_rename = time() . rand() . "." . $exten3;
                    $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);


                    $add_meeting->user_id = Session::get('user_id');
                    $add_meeting->clientid = Crypt::decrypt($request->cltid);
                    $add_meeting->user_type = 2;
                    $add_meeting->type = 1;
                    $add_meeting->client_name = $request->client_name;
                    $add_meeting->company_name = $request->company_name;
                    $add_meeting->phone = $request->phone;
                    $add_meeting->email = $request->email;
                    $add_meeting->keywords = $request->keywords;
                    $add_meeting->address = $request->address;
                    $add_meeting->visiting_card = $visiting_rename;
                    $add_meeting->shop_img = $rename_shopimg;
                    $add_meeting->amount_pic = $amount_rename;
                    $add_meeting->status = $request->status;
                    $add_meeting->remark = $request->remark;
                    $add_meeting->created_date = date("d-m-Y");
                    $add_meeting->created_time = time();
                    $add_meeting->ip_address = $_SERVER['REMOTE_ADDR'];
                    $save_meeting = $add_meeting->save();
                }
            } elseif (isset($request->status) && $request->status == 2) {
                if ($request->followup_date == '') {
                    return back()->with('faild', 'Please select follow up date!');
                } else {
                    $add_meeting->user_id = Session::get('user_id');
                    $add_meeting->clientid = Crypt::decrypt($request->cltid);
                    $add_meeting->user_type = 2;
                    $add_meeting->type = 1;
                    $add_meeting->client_name = $request->client_name;
                    $add_meeting->company_name = $request->company_name;
                    $add_meeting->phone = $request->phone;
                    $add_meeting->email = $request->email;
                    $add_meeting->keywords = $request->keywords;
                    $add_meeting->residual = '';
                    $add_meeting->followup_date = $request->followup_date;
                    $add_meeting->status = $request->status;
                    $add_meeting->created_date = date("d-m-Y");
                    $add_meeting->created_time = time();
                    $add_meeting->ip_address = $_SERVER['REMOTE_ADDR'];
                    $save_meeting = $add_meeting->save();
                }
            } elseif (isset($request->status) && $request->status == 3) {
                if ($request->residual == '') {
                    return back()->with('faild', 'Please select Reschedule date!');
                } else {
                    $add_meeting->user_id = Session::get('user_id');
                    $add_meeting->clientid = Crypt::decrypt($request->cltid);
                    $add_meeting->user_type = 2;
                    $add_meeting->type = 1;
                    $add_meeting->client_name = $request->client_name;
                    $add_meeting->company_name = $request->company_name;
                    $add_meeting->phone = $request->phone;
                    $add_meeting->email = $request->email;
                    $add_meeting->keywords = $request->keywords;
                    $add_meeting->followup_date = '';
                    $add_meeting->status = $request->status;
                    $add_meeting->residual = $request->residual;
                    $add_meeting->created_date = date("d-m-Y");
                    $add_meeting->created_time = time();
                    $add_meeting->ip_address = $_SERVER['REMOTE_ADDR'];
                    $save_meeting = $add_meeting->save();
                }
            } else {
                return redirect(route('market.View-assign-meating'));
            }

            if ($save_meeting) {
                if ($request->status == 1) {
                    DB::table('clients')->where('id', Crypt::decrypt($request->cltid))
                        ->update(['meeting_status' => $request->status]);
                    return redirect()->route('market.view-attend-meeting')->with('success', 'The deal has been closed, now add more services.');
                } else {
                    DB::table('clients')->where('id', Crypt::decrypt($request->cltid))
                        ->update(['meeting_status' => $request->status]);
                    return redirect(route('market.View-assign-meating'));
                }
            }
        }
    }


    public function Edit_Meeting($id)
    {
        $edit_meeting = Meeting::find(Crypt::decrypt($id));

        return view('marketend.edit-meeting', compact('edit_meeting'));
    }
    public function Update_Meeting_data(Request $request)
    {
        $update_meting = Meeting::find(Crypt::decrypt($request->meetid));
        $request->validate([
            'client_name' => 'required',
            'phone' => 'required|numeric|digits:10',
            'status' => 'required'
        ]);

        if (isset($request->status) && $request->status == 1) {

            if ($request->visiting_card != '' && $request->shop_img != '' && $request->amount_pic != '') {
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
                $rename_shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $rename_shopimg);

                $file3 = $request->file('amount_pic');
                $exten3 = $file3->getClientOriginalExtension();
                $amount_rename = time() . rand() . "." . $exten3;
                $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

                $update_meting->user_id = Session::get('user_id');
                $update_meting->clientid = Crypt::decrypt($request->clientid);
                $update_meting->user_type = 2;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->address = $request->address;
                $update_meting->visiting_card = $visiting_rename;
                $update_meting->shop_img = $rename_shopimg;
                $update_meting->amount_pic = $amount_rename;
                $update_meting->status = $request->status;
                $update_meting->residual = '';
                $update_meting->followup_date = '';
                $update_meting->remark = $request->remark;

                $save_meeting = $update_meting->save();
            } elseif ($request->visiting_card != '' && $request->shop_img == '' && $request->amount_pic == '') {
                $path = "assets/uploads/meeting/visitingCard/" . $update_meting->visiting_card;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('visiting_card');
                $exten = $file->getClientOriginalExtension();
                $visiting_rename = time() . rand() . "." . $exten;
                $file->move("assets/uploads/meeting/visitingCard/", $visiting_rename);

                $update_meting->user_id = Session::get('user_id');
                $update_meting->clientid = Crypt::decrypt($request->clientid);
                $update_meting->user_type = 2;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->address = $request->address;
                $update_meting->visiting_card = $visiting_rename;
                $update_meting->status = $request->status;
                $update_meting->residual = '';
                $update_meting->followup_date = '';
                $update_meting->remark = $request->remark;

                $save_meeting = $update_meting->save();
            } elseif ($request->shop_img != '' && $request->visiting_card == '' && $request->amount_pic == '') {
                $path2 = "assets/uploads/meeting/shopImage/" . $update_meting->shop_img;
                if (File::exists($path2)) {
                    File::delete($path2);
                }
                $file2 = $request->file('shop_img');
                $exten2 = $file2->getClientOriginalExtension();
                $rename_shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $rename_shopimg);

                $update_meting->user_id = Session::get('user_id');
                $update_meting->clientid = Crypt::decrypt($request->clientid);
                $update_meting->user_type = 2;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->address = $request->address;
                $update_meting->shop_img = $rename_shopimg;
                $update_meting->status = $request->status;
                $update_meting->residual = '';
                $update_meting->followup_date = '';
                $update_meting->remark = $request->remark;
                $save_meeting = $update_meting->save();
            } elseif ($request->amount_pic != '' && $request->shop_img == '' && $request->visiting_card == '') {
                $path3 = "assets/uploads/meeting/amount_pic/" . $update_meting->amount_pic;
                if (File::exists($path3)) {
                    File::delete($path3);
                }
                $file3 = $request->file('amount_pic');
                $exten3 = $file3->getClientOriginalExtension();
                $amount_rename = time() . rand() . "." . $exten3;
                $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

                $update_meting->user_id = Session::get('user_id');
                $update_meting->clientid = Crypt::decrypt($request->clientid);
                $update_meting->user_type = 2;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->address = $request->address;
                $update_meting->amount_pic = $amount_rename;
                $update_meting->status = $request->status;
                $update_meting->residual = '';
                $update_meting->followup_date = '';
                $update_meting->remark = $request->remark;
                $save_meeting = $update_meting->save();
            } elseif ($request->shop_img != '' && $request->visiting_card != '' && $request->amount_pic == '') {
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
                $rename_shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $rename_shopimg);

                $update_meting->user_id = Session::get('user_id');
                $update_meting->clientid = Crypt::decrypt($request->clientid);
                $update_meting->user_type = 2;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->address = $request->address;
                $update_meting->visiting_card = $visiting_rename;
                $update_meting->shop_img = $rename_shopimg;
                $update_meting->status = $request->status;
                $update_meting->residual = '';
                $update_meting->followup_date = '';
                $update_meting->remark = $request->remark;
                $save_meeting = $update_meting->save();
            } elseif ($request->visiting_card != '' && $request->amount_pic != '' && $request->shop_img == '') {
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

                $update_meting->user_id = Session::get('user_id');
                $update_meting->clientid = Crypt::decrypt($request->clientid);
                $update_meting->user_type = 2;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->address = $request->address;
                $update_meting->visiting_card = $visiting_rename;
                $update_meting->amount_pic = $amount_rename;
                $update_meting->status = $request->status;
                $update_meting->residual = '';
                $update_meting->followup_date = '';
                $update_meting->remark = $request->remark;
                $save_meeting = $update_meting->save();
            } elseif ($request->amount_pic != '' && $request->shop_img != '' && $request->visiting_card == '') {

                $path2 = "assets/uploads/meeting/shopImage/" . $update_meting->shop_img;
                $path3 = "assets/uploads/meeting/amount_pic/" . $update_meting->amount_pic;
                if (File::exists($path2) && File::exists($path3)) {
                    File::delete($path2);
                    File::delete($path3);
                }

                $file2 = $request->file('shop_img');
                $exten2 = $file2->getClientOriginalExtension();
                $rename_shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $rename_shopimg);

                $file3 = $request->file('amount_pic');
                $exten3 = $file3->getClientOriginalExtension();
                $amount_rename = time() . rand() . "." . $exten3;
                $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

                $update_meting->user_id = Session::get('user_id');
                $update_meting->clientid = Crypt::decrypt($request->clientid);
                $update_meting->user_type = 2;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->address = $request->address;
                $update_meting->shop_img = $rename_shopimg;
                $update_meting->amount_pic = $amount_rename;
                $update_meting->status = $request->status;
                $update_meting->residual = '';
                $update_meting->followup_date = '';
                $update_meting->remark = $request->remark;
                $save_meeting = $update_meting->save();
            } else {
                $update_meting->user_id = Session::get('user_id');
                $update_meting->clientid = Crypt::decrypt($request->clientid);
                $update_meting->user_type = 2;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->address = $request->address;
                $update_meting->status = $request->status;
                $update_meting->residual = '';
                $update_meting->followup_date = '';
                $update_meting->remark = $request->remark;
                $save_meeting = $update_meting->save();
            }
        } elseif (isset($request->status) && $request->status == 2) {
            if ($request->followup_date == '') {
                return back()->with('faild', 'Please select follow up date!');
            } else {
                $update_meting->user_id = Session::get('user_id');
                $update_meting->clientid = Crypt::decrypt($request->clientid);
                $update_meting->user_type = 2;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
                $update_meting->keywords = $request->keywords;
                $update_meting->followup_date = $request->followup_date;
                $update_meting->residual = '';
                $update_meting->status = $request->status;
                $save_meeting = $update_meting->save();
            }
        } elseif (isset($request->status) && $request->status == 3) {
            if ($request->residual == '') {
                return back()->with('faild', 'Please select residual date!');
            }
            $update_meting->user_id = Session::get('user_id');
            $update_meting->clientid = Crypt::decrypt($request->clientid);
            $update_meting->user_type = 2;
            $update_meting->type = 1;
            $update_meting->client_name = $request->client_name;
            $update_meting->company_name = $request->company_name;
            $update_meting->phone = $request->phone;
            $update_meting->email = $request->email;
            $update_meting->keywords = $request->keywords;
            $update_meting->residual = $request->residual;
            $update_meting->followup_date = '';
            $update_meting->status = $request->status;
            $save_meeting = $update_meting->save();
        } else {
            return redirect(route('market.view-attend-meeting'));
        }
        if ($save_meeting) {
            DB::table('clients')->where('id', Crypt::decrypt($request->clientid))
                ->update(['meeting_status' => $request->status]);
            return redirect(route('market.view-attend-meeting'))->with('success', 'Meeting update successfully!');
        }
    }

    public function Meeting_delete($id)
    {
        $deleet_id = Crypt::decrypt($id);
        $meeting_del = Meeting::find($deleet_id);
        $meeting_del->archive = 1;
        $meeting_del->save();
        return back()->with('success', 'Meeting Delete successfully!');
    }

    public function Archive_meeting(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('meetings')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 1)
                ->where('type', 1)
                ->where('user_type', 2)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm" href="' . url('marketing/active-meating', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-arrow-clockwise"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('marketend.archive-meeting');
    }

    public function Meeting_Active($id)
    {
        $active_Id = Crypt::decrypt($id);
        $active_meeting = Meeting::find($active_Id);
        $active_meeting->archive = 0;
        $active_meeting->save();
        return back()->with('success', 'Meeting Active Successfully!');
    }

    public function Select_service_get_price(Request $request)
    {

        $service_price_id = $request->id;

        if (is_array($service_price_id) && !empty($service_price_id)) {
            $amt = 0;
            foreach ($service_price_id as $id) {

                $price = DB::table('services')->where("id", $id)->value('service_price');
                $amt = $amt + floatval($price);
            }

            return response()->json(array('status' => 200, 'data' => $amt));
        } else {
            return response()->json(array('status' => 400, 'msg' => 'Please select company service'));
        }
    }
    public function SelectClientGetCompany(Request $request)
    {
        if (isset($request->id) && $request->id != "") {
            $clientdata = DB::table('clients')->where('id', $request->id)->first();
            return response()->json(array('status' => 200, 'clientData' => $clientdata));
        }
    }
}
