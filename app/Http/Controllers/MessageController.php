<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\employee;
use App\Models\agent;
use App\Models\leave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Models\frontend\Client;
use DB;
use Carbon\Carbon;
use App\Models\File;

class MessageController extends Controller
{

    public function MangerMessage(){

        $employee = employee::where('manager_id' , Auth::guard('manager')->user()->id)->get();

        return view('managerend.message' , compact('employee'));

    }

    public function Addmessage(Request $request){

        // dd($request->all());

        $data = [

            'manager_id' => Auth::guard('manager')->user()->id,
            'emp_id' => $request->empid,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => '0',

        ];

        $data = DB::table('notification')->insert($data);

        if($data){
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);

    }

    public function messagelist(Request $request){

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

        // $user_id = NULL;
      
        

        // dd($user_id);


        $data = employee::where('employee.status' , 1);

        $data = DB::table('notification')->join('employee' , 'notification.emp_id' , '=' , 'employee.id')->select('notification.*' , 'employee.firstname' , 'employee.lastname');


        if($request->userdata != NULL){

            $data->where('notification.emp_id' , $request->userdata);

        }

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;

        $data = $data->get();
        $data_arr = array();
        

        foreach($data as $key => $val){
            $id = $val->id;
            $name = $val->firstname;
            $name .= $val->lastname;
            $subject = $val->subject;
            $message = $val->message;
            $date = $val->created_at ;
         
            $action = '<a class="dropdown-items text-success delete" href="javascript:void(0);" style="float:left;" data-id="'.$id.'" ><i class="bi bi-trash" aria-hidden="true"></i></a>';
           
            $data_arr[] = array(
              "id" => ++$start,
              "name" => $name,
              "action" => $action,
              "subject"  => $subject,
              'date'  => $date,
              'message'  => $message,
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
