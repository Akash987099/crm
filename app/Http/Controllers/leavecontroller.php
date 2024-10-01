<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\leave;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;

class leavecontroller extends Controller
{
    public function leave(){
        return view('employee.leave');
    }

    public function managerleave(){
          return view('managerend.leave');
    }

    public function managerleaveAjax(Request $request){
        
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

        $data = DB::table('leave_master')
        ->leftJoin('employee', 'leave_master.employee_id', '=', 'employee.id')
        // ->whereDate('leave_master.created_at', $currentDate)
        ->select('leave_master.*' , 'employee.staffid as staffid' , 'employee.firstname' , 'employee.lastname')
        ->orderBy('leave_master.id', 'desc')
        ->get();

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;

        $data_arr = array();

        foreach($data as $key => $val){
            $id = $val->id;
            $login_time = $val->subject;
            $logout_time = $val->reason;
            $date = Carbon::parse($val->created_at)->format('d-m-Y');

            $emp = $val->staffid;
            $name = $val->firstname;
            $name .= $val->lastname;

            // $action = '<a class="dropdown-items text-success viewall" href="javascript:void(0);" style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
            $action = '&nbsp;<a href="javascript:void(0);"  class="text-primary edit" data-id="'.$id.'"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';

            $data_arr[] = array(
              "id" => ++$start,
              "login_time" => $login_time,
              "logout_time" => $logout_time,
              "date"   => $date,
            //   "image"     => $image,
              "name"   => $name,
              "emp"   => $emp,
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

    public function Addleave(Request $request){
        // dd($request->all());
       $empID =  Auth::guard('employee')->user()->id;
       $email =  Auth::guard('employee')->user()->email;

        // dd($empID);

        $request->validate([
            'subject' => 'required',
            'reason' => 'required',
        ]);

        $subject = $request->subject;
        $reason = $request->reason;

        $insert = leave::create(['employee_id' => $empID ,'subject' => $subject , 'reason' => $reason]);

        if($insert)
        {

            $subjectRecipient = $subject;
    
            $description = $reason ?? '-';
            $messageRecipient = strip_tags($description);
    
    
            $mail = Mail::raw($messageRecipient, function ($mail) use ($email, $subjectRecipient) {

                $mail->to($email)->subject($subjectRecipient);
    
            });

            return back()->with('success', 'Add Successfully');
        }
        return back()->with('error', 'failed');

    }

    public function leaveAjax(Request $request){

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

        $empID =  Auth::guard('employee')->user()->id;
        $data = leave::orderBy('id' , 'desc')->where('employee_id' , $empID)->get();

        $totalRecordswithFilter = leave::where('employee_id' , $empID)->count();
        $totalRecords = $totalRecordswithFilter;

        $data_arr = array();

        foreach($data as $key => $val){
            $id = $val->id;
            $subject = $val->subject;
            $date = Carbon::parse($val->created_at)->format('d-m-Y');

            // $action = '<a class="dropdown-items text-success viewall" href="javascript:void(0);" style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
            $action = '&nbsp;<a href="javascript:void(0);"  class="text-primary edit" data-id="'.$id.'"><i class="bi bi-eye" aria-hidden="true"></i></a>';
            // $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';

            $data_arr[] = array(
              "id" => ++$start,
              "subject" => $subject,
              "date"  => $date,
              "action" => $action,
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
}
