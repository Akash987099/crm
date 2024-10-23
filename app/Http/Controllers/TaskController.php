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

class TaskController extends Controller
{
     Public function task(){

        $employee = employee::all();

        return view('pages.task' , compact('employee'));
     }

     public function Addtask(Request $request){

        // dd($request->all());

        $data = [

            'emp_id' => $request->empid,
            'name'  => $request->name,
            'target' => $request->target,
            'fromdate' => $request->fromdate,
            'todate' => $request->todate,

        ];

        $insert = DB::table('task')->insert($data);

        if($insert){
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error']);

     }

     public function taskAjax(Request $request){

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


        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $data = DB::table('task')->join('employee' , 'task.emp_id' , '=' , 'employee.id')->select('task.*' , 'employee.firstname as firstname' , 'employee.lastname as lastname' , 'employee.staffid as staffid');
        

    //    dd($data->get());

        if ($searchValue != null) {
            $data->where(function($query) use ($searchValue) {
                $query->where('task.name', 'like', '%' . $searchValue . '%');
            });
        }

    
        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;

        $data =  $data->get();
        $data_arr = array();


        foreach($data as $key => $val){
            $id = $val->id;
            $staffid = $val->staffid;
            $name = $val->firstname;
            $name .= $val->lastname;

            $task = $val->name;
            $target = $val->target;
            $fromdate = $val->fromdate;
            $todate = $val->todate;

            $status = DB::table('amount_pay')->where('employee_id' , $id)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->first();


            $action = '&nbsp;<a href=" ' . route("amount-view" , ['id' => $id]) .'  " class="text-success view" data-id="'.$id.'"><i class="bi bi-eye" aria-hidden="true" ></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="text-primary edit" data-id="'.$id.'"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';
            

            $data_arr[] = array(
              "id" => ++$start,
              "staffid" => $staffid,
              'name' => $name,
              'task'  => $task,
              'target' => $target,
              'fromdate' => $fromdate,
              'todate' => $todate,
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

     public function Deletetask(Request $request){

        // dd($request->all());
        $delete = $request->id;
        $update = $request->update;

        if($delete){
            $data = DB::table('task')->where('id' , $delete)->delete();
        }

        if($update){
            $data = DB::table('task')->where('id' , $update)->first();
        }

       if($data){
        return response()->json(['status' => 'success' , 'data' => $data]);
       }
       return response()->json(['status' => 'error']);

     }

     public function updatetask(Request $request){

        // dd($request->all());

        $updateid = $request->updateid;

        $data = [

            'emp_id' => $request->empid,
            'name'  => $request->name,
            'target' => $request->target,
            'fromdate' => $request->fromdate,
            'todate' => $request->todate,

        ];

        $insert = DB::table('task')->where('id' , $updateid)->update($data);

        if($insert){
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error']);

     }

     public function emptask(Request $request){

      $id = Auth::guard('employee')->user()->id;

    //   dd($id);

    //   DB::table('task')->where('emp_id' , $id)->get();

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


      $currentMonth = Carbon::now()->month;
      $currentYear = Carbon::now()->year;
      
      $data =  DB::table('task')->where('emp_id' , $id)->orderBy('id', 'desc') ;
      

  //    dd($data->get());

      if ($searchValue != null) {
          $data->where(function($query) use ($searchValue) {
              $query->where('task.name', 'like', '%' . $searchValue . '%');
          });
      }

  
      $totalRecordswithFilter = $data->count();
      $totalRecords = $totalRecordswithFilter;

      $data =  $data->get();
      $data_arr = array();


      foreach($data as $key => $val){
          $id = $val->id;

          $task = $val->name;
          $target = $val->target;
          $fromdate = $val->fromdate;
          $todate = $val->todate;

          $status = DB::table('amount_pay')->where('employee_id' , $id)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->first();


          $action = '&nbsp;<a href=" ' . route("emp-report" , ['id' => $id]) .'  " class="text-success view" data-id="'.$id.'">Add Task Report</a>';
        //   $action .= '&nbsp;<a href="javascript:void(0);" class="text-primary edit" data-id="'.$id.'"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>';
        //   $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';
          

          $data_arr[] = array(
            "id" => ++$start,
            'task'  => $task,
            'target' => $target,
            'fromdate' => $fromdate,
            'todate' => $todate,
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

     public function empreport(Request $request){

        // dd($request->all());
        
        $id = $request->id;

      $data =  DB::table('task')->where('emp_id' , $id)->first();

      return view('pages.add-task-report' , compact('data'));


     }

     public function Addtaskreport(Request $request){

        // dd($request->all());

        $taskid = $request->taskid;
        $amount = $request->amount;
        $details  = $request->details;

        $id = Auth::guard('employee')->user()->id;

        // file

        $data  = [

            'emp_id' => $id,
            'task_id' => $taskid,
            'task_amount' => $amount,
            'details' => $details,

        ];

        if ($request->hasFile('image')) {
            $document = $request->file('image');
            $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $document->getClientOriginalExtension();
            $uniqueName = $originalName . '_' . uniqid() . '.' . $extension;
            $documentPath = $document->move('image', $uniqueName , 'public');
            
            $data['image'] = $documentPath;
        }

        $insert = DB::table('task_report')->insert($data);

        if($insert){

            return response()->json(['status' => "success"]);

        }

           return response()->json(['status' => "error"]);

     }

}
