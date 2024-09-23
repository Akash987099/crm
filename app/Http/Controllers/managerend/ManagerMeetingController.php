<?php

namespace App\Http\Controllers\managerend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\marketend\Meeting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\backend\Services;
use App\Models\marketend\Account;
use Yajra\DataTables\DataTables;

class ManagerMeetingController extends Controller
{
    public function View_meeting_manager(Request $request)
    {

        if ($request->ajax()) {
            $data = DB::table('meetings')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 0)
                ->where('type', 1)
                ->where('user_type', 3)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1" href="' . route('manager.manager-meeting-details', ['meetingid' => Crypt::encrypt($row->id)]) . '" title="View Data"> <i class="bi bi-eye"></i></a>';
                    if ($row->status == 1) {
                        $btn .= '<a class="btn btn-warning btn-sm m-1 text-white" title="Payment Details" href="' . route('manager.bill-payment', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-cash"></i></a>';
                    }
                    if ($row->status == 1) {
                        if (!DB::table('payment_details')->where('meeting_id', $row->id)->exists()) {
                            $btn .= '<a class="btn btn-primary btn-sm m-1" title="Update" href="' . route('manager.Edit-meeting-manager', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                            $btn .= '<a class="btn btn-info btn-sm m-1" title="Add Services " href="' . route('manager.add-meeting-service', ['meetingid' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-plus-circle-fill"></i></a>';
                        }
                    }
                    $btn .= '<a class="btn btn-danger btn-sm m-1" title="Delete" href="' . url('manager/delete-meeting-manager', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('managerend.view-meeting-manager');
    }


    public function Edit_meeting_manager($id)
    {
        $edit_meeting = Meeting::find(Crypt::decrypt($id));
        return view('managerend.edit-meeting-manager', compact('edit_meeting'));
    }
    public function Update_meeting_manager(Request $request)
    {
        $update_meting = Meeting::find(Crypt::decrypt($request->meetingid));

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
                $update_meting->user_type = 3;
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
                $update_meting->user_type = 3;
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
                $update_meting->user_type = 3;
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
                $update_meting->user_type = 3;
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
                $update_meting->user_type = 3;
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
                $update_meting->user_type = 3;
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
                $update_meting->user_type = 3;
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
                $update_meting->user_type = 3;
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
                $update_meting->user_type = 3;
                $update_meting->type = 1;
                $update_meting->client_name = $request->client_name;
                $update_meting->company_name = $request->company_name;
                $update_meting->phone = $request->phone;
                $update_meting->email = $request->email;
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
            $update_meting->user_type = 3;
            $update_meting->type = 1;
            $update_meting->client_name = $request->client_name;
            $update_meting->company_name = $request->company_name;
            $update_meting->phone = $request->phone;
            $update_meting->email = $request->email;
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
            return redirect()->route('manager.view-meeting-manager')->with('success', 'Attend Meeting Update Successfully!');
        }
    }
    public function Archive_meeting_manager(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('meetings')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 1)
                ->where('type', 1)
                ->where('user_type', 3)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1 text-white" href="' . url('manager/active-meeting-manager', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-arrow-clockwise"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('managerend.archive-meeting-manager');
    }
    public function Delete_meeting_manager($id)
    {
        $delete_id = Crypt::decrypt($id);
        $meeting_delete = Meeting::find($delete_id);
        $meeting_delete->archive = 1;
        $meeting_delete->save();
        return back()->with('success', 'Meeting Delete Successfully!');
    }
    public function Active_meeting_manager($id)
    {
        $active_id = Crypt::decrypt($id);
        $active_meeting = Meeting::find($active_id);
        $active_meeting->archive = 0;
        $active_meeting->save();
        return redirect('manager/view-meeting-manager')->with('success', 'Meeting Active Successfully!');
    }

    public function Select_ClientGet_Company(Request $request)
    {
        if (isset($request->id) && $request->id != "") {
            $clientdata = DB::table('clients')->where('id', $request->id)->first();
            return response()->json(array('status' => 200, 'clientData' => $clientdata));
        }
    }

    public function MeetinModalData(Request $request)
    {
        $arr = [];
        $service = [];
        if (isset($request->meetingid) && $request->meetingid != "") {

            $data = DB::table('meetings')->where('id', Crypt::decrypt($request->meetingid))->first();

            $decode = json_decode($data->service);
            array_push($arr, $decode);
            foreach ($arr as $row) {
                $comp_service = Services::find($row);
                foreach ($comp_service as $row2) {
                    $service[] = $row2;
                }
            }
            return response()->json(array('data' => $data, 'service' => $service));
        }
    }

    public function SelectServiceGet_price(Request $request)
    {
        if (is_array($request->id) && !empty($request->id)) {
            $amt = 0;
            foreach ($request->id as $id) {
                $price = DB::table('services')->where("id", $id)->value('service_price');
                $amt = $amt + floatval($price);
            }

            return response()->json(array('status' => 200, 'data' => $amt));
        } else {
            return response()->json(array('status' => 400, 'msg' => 'Please select company service'));
        }
    }

    public function ManagerAddMeetingService(Request $request)
    {
        $meeting = DB::table('meetings')
            ->where('user_id', Session::get('user_id'))
            ->where('archive', 0)
            ->where('type', 1)
            ->where('user_type', 3)
            ->where('id', Crypt::decrypt($request->meetingid))
            ->first();

        $temp_service = DB::table('service_temp')->where('user_id', Session::get('user_id'))->where('meetingid', Crypt::decrypt($request->meetingid))->get();

        return view('managerend.meeting-add-service', compact('meeting', 'temp_service'));
    }

    public function ManagerAddMeetingSubmit(Request $request)
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
                        ->where('user_type', 3)
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
                        ->where('user_type', 3)
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


    public function ManagerAddMeetingDiscount(Request $request)
    {
        if (isset($request->meetingid) && $request->meetingid != "") {
            $total = $request->total;
            $dis = $request->discount;

            $dis_price  = ($total / 100) * $dis;
            $total_amt =  $total - $dis_price;

            DB::table('meetings')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 0)
                ->where('user_type', 3)
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

    public function ManagerAddMeetingDelete(Request $request)
    {

        if (isset($request->serviceid) && isset($request->meetingid)) {

            $service_delete = DB::table('service_temp')->where('id', Crypt::decrypt($request->serviceid))->where('meetingid', Crypt::decrypt($request->meetingid))->delete();

            if ($service_delete) {
                $total_amt = DB::table('service_temp')->where('meetingid', Crypt::decrypt($request->meetingid))->sum('price');
                $meeting_data = DB::table('meetings')->where('id', Crypt::decrypt($request->meetingid))->where('archive', 0)->where('user_type', 3)->where('type', 1)->where('user_id', Session::get('user_id'))->first();

                $dis_price  = ($total_amt / 100) * $meeting_data->discount;
                $total =  $total_amt - $dis_price;

                DB::table('meetings')
                    ->where('id', Crypt::decrypt($request->meetingid))
                    ->where('archive', 0)
                    ->where('user_type', 3)
                    ->where('type', 1)
                    ->where('user_id', Session::get('user_id'))
                    ->update([
                        'blance' => $total,
                        'temp_value' => $total,
                    ]);

                if ($total_amt == 0) {
                    DB::table('meetings')
                        ->where('id', Crypt::decrypt($request->meetingid))
                        ->where('archive', 0)
                        ->where('user_type', 3)
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
    public function ManagerAddMeetingDetails(Request $request)
    {
        if (isset($request->meetingid) && $request->meetingid != "") {
            $meeting_data = Meeting::where('id', Crypt::decrypt($request->meetingid))->first();
            $temp_service = DB::table('service_temp')->where('meetingid', Crypt::decrypt($request->meetingid))->where('user_id', Session::get('user_id'))->get();
            $payment = DB::table('payment_details')->where('meeting_id', Crypt::decrypt($request->meetingid))->get();
        }
        return view('managerend.manager-meeting-details', compact('meeting_data', 'temp_service', 'payment'));
    }
}
