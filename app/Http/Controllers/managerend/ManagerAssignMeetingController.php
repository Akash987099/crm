<?php

namespace App\Http\Controllers\managerend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\frontend\Client;
use App\Models\marketend\Meeting;
use App\Models\agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\employee;
use Carbon\Carbon;
use App\Models\backend\Services;
use Yajra\DataTables\DataTables;

class ManagerAssignMeetingController extends Controller
{

    public function manager_repoer(){
        $employee = employee::all();
        return view('managerend.report' , compact('employee'));
    }

    public function manager_data(Request $request){


        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $columnIndex = $columnIndex_arr[0]['column']; 
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];

        $currentDate = Carbon::now('Asia/Kolkata')->toDateString();

        // $data = DB::table('attendance')
        // ->leftJoin('employee', 'attendance.user_id', '=', 'employee.id')
        // ->select('attendance.*', 'employee.staffid as staffid', 'employee.firstname', 'employee.lastname')
        // ->orderBy('attendance.id', 'desc');

        $data = agent::leftjoin('employee' , 'agent.user_id' , '=' , 'employee.id')->select('agent.*');

        if(Auth::guard('manager')->check()){

            $empid = employee::where('user_id' , Auth::guard('manager')->user()->id)->pluck('id');
           $data->whereIn('employee.user_id' , $empid);
        }

    if ($request->username != null) {
        $data->where('employee.id', $request->username);
    }

    // dd($request->all());

    if($request->fromdate != NULL && $request->todate != NULL){
        $data->whereBetween('created_ate', [$request->fromdate, $request->todate]);
    }

    $data = $data->get();

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;

        $data_arr = array();

        foreach($data as $key => $val){
            $id = $val->id;
            $name = $val->name;
            $contact = $val->contact;

            $email = $val->email;
            $district = $val->district;
            $district .= $val->state;
            $rrn_no = $val->rrn_no;
            $total_amount = $val->total_amount;
            $payment_re = $val->payment_re;
            $document_add = $val->document_add;

            // dd($val->image);
          
            $data_arr[] = array(
              "id" => ++$start,
              "name" => $name,
              "contact" => $contact,
              "email"   => $email,
              "rrn_no"     => $rrn_no,
              "total_amount"   => $total_amount,
              "payment_re"   => $payment_re,
              'document_add' => $document_add
            );

        }

        $response = array(
            "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr,
        );

        // dd($response);
        echo json_encode($response); 

    }

    public function View_Manager_Assign_Meating(Request $request)
    {
        $client_data = DB::table('clients')
            ->where('assign_meating', Session::get('user_id'))
            ->where('typeofuser', 1)
            ->where('archive', 0)
            ->get();
        if ($request->ajax()) {
            $data = $client_data;
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if ($row->meeting_status != 1) {
                        $btn = '<a class="btn btn-warning btn-sm m-1" title="Attend Meeting" href="' . route('manager.edit-massign-meeting', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-person"></i></a>';
                    }
                    $btn .= '<a class="btn btn-info btn-sm m-1 client_id" title="View Data" data-id=' . Crypt::encrypt($row->id) . '><i class="bi bi-eye"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('managerend.view-massign-meeting');
    }


    public function Edit_Massign_meeting($id)
    {

        $clientId = Crypt::decrypt($id);
        $ashign_meeting = Client::find($clientId);
        return view('managerend.edit-massign-meeting', compact('ashign_meeting'));
    }


    public function Add_assign_meeting(Request $request)
    {
        $request->validate([
            'client_name' => 'required',
            'company_name' => 'required',
            'phone' => 'required|numeric|digits:10',
            'status' => 'required|not_in:0',

        ]);

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
                    $path = "assets/uploads/meeting/visitingCard/" . $update_meeting->visiting_card;
                    $path2 = "assets/uploads/meeting/shopImage/" . $update_meeting->shop_img;
                    $path3 = "assets/uploads/meeting/amount_pic/" . $update_meeting->amount_pic;

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
                    $update_meeting->user_type = 3;
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
                    $save_meeting = $update_meeting->save();
                }
            } elseif (isset($request->status) && $request->status == 2) {
                if ($request->followup_date == '') {
                    return back()->with('faild', 'Please select follow up date!');
                } else {
                    $update_meeting->user_id = Session::get('user_id');
                    $update_meeting->clientid = Crypt::decrypt($request->cltid);
                    $update_meeting->user_type = 3;
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
                $update_meeting->user_type = 3;
                $update_meeting->type = 1;
                $update_meeting->client_name = $request->client_name;
                $update_meeting->company_name = $request->company_name;
                $update_meeting->phone = $request->phone;
                $update_meeting->email = $request->email;
                $update_meeting->residual = $request->residual;
                $update_meeting->followup_date = '';
                $update_meeting->status = $request->status;
                $save_meeting = $update_meeting->save();
            } else {
                return redirect(route('market.View-assign-meating'));
            }
            if ($save_meeting && $request->status == 1) {
                DB::table('clients')->where('id', Crypt::decrypt($request->cltid))
                    ->update(['meeting_status' => $request->status]);
                return redirect(route('manager.view-meeting-manager'))->with('success', 'The deal has been closed, now add more services.');
            } else {
                DB::table('clients')->where('id', Crypt::decrypt($request->cltid))
                    ->update(['meeting_status' => $request->status]);
                return redirect(route('manager.massign-meeting'));
            }
        } else {

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
                    $add_meeting->user_type = 3;
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
                    $add_meeting->user_type = 3;
                    $add_meeting->type = 1;
                    $add_meeting->client_name = $request->client_name;
                    $add_meeting->company_name = $request->company_name;
                    $add_meeting->phone = $request->phone;
                    $add_meeting->email = $request->email;
                    $add_meeting->followup_date = $request->followup_date;
                    $add_meeting->residual = '';
                    $save_meeting = $add_meeting->save();
                }
            } elseif (isset($request->status) && $request->status == 3) {
                $add_meeting->user_id = Session::get('user_id');
                $add_meeting->clientid = Crypt::decrypt($request->cltid);
                $add_meeting->user_type = 3;
                $add_meeting->type = 1;
                $add_meeting->client_name = $request->client_name;
                $add_meeting->company_name = $request->company_name;
                $add_meeting->phone = $request->phone;
                $add_meeting->email = $request->email;
                $add_meeting->followup_date = '';
                $add_meeting->residual = $request->residual;
                $save_meeting = $add_meeting->save();
            } else {
                return redirect(route('manager.massign-meeting'));
            }

            if ($save_meeting && $request->status == 1) {
                DB::table('clients')->where('id', Crypt::decrypt($request->cltid))
                    ->update(['meeting_status' => $request->status]);
                return redirect(route('manager.view-meeting-manager'))->with('success', 'The deal has been closed, now add more services.');
            } else {
                DB::table('clients')->where('id', Crypt::decrypt($request->cltid))
                    ->update(['meeting_status' => $request->status]);
                return redirect(route('manager.massign-meeting'));
            }
        }
    }

    public function Model_viewClientData(Request $request)
    {
        $arr = [];
        $service = [];
        $client_id = Crypt::decrypt($request->id);
        $data = Client::where('id', $client_id)->first();
        if ($data->user_type == 1) {
            $team_user = "Admin";
        } else {
            $team_user = DB::table('tele_person')->where('id', $data->user_id)->first();
        }
        $decode = json_decode($data->service);
        array_push($arr, $decode);
        foreach ($arr as $row) {
            $client_service = Services::find($row);
            foreach ($client_service as $row2) {
                $service[] = $row2;
            }
        }
        return response()->json(array('data' => $data, 'service' => $service, 'team_user' => $team_user));
    }

    public function Select_servicePrice(Request $request)
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
