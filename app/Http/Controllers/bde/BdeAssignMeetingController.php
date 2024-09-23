<?php

namespace App\Http\Controllers\bde;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use App\Models\frontend\Client;
use App\Models\marketend\Meeting;
use App\Models\backend\Services;

class BdeAssignMeetingController extends Controller
{

    public function SHOW_BDE_ASSIGN_MEETING(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('clients')->where('assign_meating', Session::get('user_id'))->where('typeofuser', 3)->where('archive', 0)->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info m-1 client_id" title="View Data" data-id=' . Crypt::encrypt($row->id) . '><i class="bi bi-eye"></i></a>';
                    if ($row->meeting_status != 1) {
                        $btn .= '<a class="btn btn-warning m-1" title="Meeting Attend" href="' . route('bde.assign-meeting', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-person"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('bdend.view-bde-assign-meeting');
    }


    public function EDIT_BDE_Assign_Meeting($id)
    {
        $clientId = Crypt::decrypt($id);
        $ashign_meating = Client::find($clientId);
        return view('bdend.assign-meeting', compact('ashign_meating'));
    }

    public function UPDATE_BDE_Assign_Meeting(Request $request)
    {
        if (DB::table('meetings')->where('clientid', Crypt::decrypt($request->cltid))->exists()) {
            $meetingid = DB::table('meetings')->where('clientid', Crypt::decrypt($request->cltid))->where('archive', 0)->first();
            $update_meeting = Meeting::find($meetingid->id);

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

                    $update_meeting->user_id = Session::get('user_id');
                    $update_meeting->clientid = Crypt::decrypt($request->cltid);
                    $update_meeting->user_type = 4;
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
                    $update_meeting->residual = '';
                    $update_meeting->followup_date = '';
                    $update_meeting->remark = $request->remark;
                    $update_meeting->created_date = date("d-m-Y");
                    $update_meeting->created_time = time();
                    $update_meeting->ip_address = $_SERVER['REMOTE_ADDR'];
                    $save_meeting = $update_meeting->save();
                }
            } elseif (isset($request->status) && $request->status == 2) {
                if ($request->followup_date == '') {
                    return back()->with('faild', 'Please select follow up date!');
                } else {
                    $update_meeting->user_id = Session::get('user_id');
                    $update_meeting->clientid = Crypt::decrypt($request->cltid);
                    $update_meeting->user_type = 4;
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
                $update_meeting->user_type = 4;
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
            if ($save_meeting && $request->status == 1) {
                DB::table('clients')->where('id', Crypt::decrypt($request->cltid))
                    ->update(['meeting_status' => $request->status, 'followup_date' => '', 'reschedule' => '']);
                return redirect(route('bde.view-bde-meeting'))->with('success', 'The deal has been closed, now add more services.');
            } else {
                DB::table('clients')->where('id', Crypt::decrypt($request->cltid))
                    ->update(['meeting_status' => $request->status, 'followup_date' => $request->followup_date, 'reschedule' => $request->residual]);
                return redirect(route('bde.show-assign-meeting'));
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
                    $add_meeting->user_type = 4;
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
                    $add_meeting->user_type = 4;
                    $add_meeting->type = 1;
                    $add_meeting->client_name = $request->client_name;
                    $add_meeting->company_name = $request->company_name;
                    $add_meeting->phone = $request->phone;
                    $add_meeting->email = $request->email;
                    $add_meeting->followup_date = $request->followup_date;
                    $add_meeting->residual = '';
                    $add_meeting->created_date = date("d-m-Y");
                    $add_meeting->created_time = time();
                    $add_meeting->ip_address = $_SERVER['REMOTE_ADDR'];
                    $save_meeting = $add_meeting->save();
                }
            } elseif (isset($request->status) && $request->status == 3) {
                $add_meeting->user_id = Session::get('user_id');
                $add_meeting->clientid = Crypt::decrypt($request->cltid);
                $add_meeting->user_type = 4;
                $add_meeting->type = 1;
                $add_meeting->client_name = $request->client_name;
                $add_meeting->company_name = $request->company_name;
                $add_meeting->phone = $request->phone;
                $add_meeting->email = $request->email;
                $add_meeting->followup_date = '';
                $add_meeting->residual = $request->residual;
                $add_meeting->created_date = date("d-m-Y");
                $add_meeting->created_time = time();
                $add_meeting->ip_address = $_SERVER['REMOTE_ADDR'];
                $save_meeting = $add_meeting->save();
            }

            if ($save_meeting && $request->status == 1) {
                DB::table('clients')->where('id', Crypt::decrypt($request->cltid))
                    ->update(['meeting_status' => $request->status, 'followup_date' => '', 'reschedule' => '']);
                return redirect(route('bde.view-bde-meeting'))->with('success', 'The deal has been closed, now add more services.');
            } else {
                DB::table('clients')->where('id', Crypt::decrypt($request->cltid))
                    ->update(['meeting_status' => $request->status, 'followup_date' => $request->followup_date, 'reschedule' => $request->residual]);
                return redirect(route('bde.show-assign-meeting'));
            }
        }
    }

    public function ModelBde_viewClientData(Request $request)
    {
        $data = Client::where('id', Crypt::decrypt($request->id))->first();
        if ($data->user_type == 1) {
            $team_user = "Admin";
        } else {
            $team_user = DB::table('tele_person')->where('id', $data->user_id)->first();
        }

        return response()->json(array('data' => $data,  'team_user' => $team_user));
    }

    public function BDESelect_servicePrice(Request $request)
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
}
