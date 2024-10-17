<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\letter;
use App\Models\employee;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Mail;

class PayrollController extends Controller
{

    public function pay(Request $request){

        $employee = employee::all();

        return view('pages.pay' , compact('employee'));

    }

    public function payAjax(Request $request){

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
        
        $data = employee::leftJoin('attendance', 'attendance.user_id', '=', 'employee.id')
        ->leftJoin('leave_master', 'leave_master.employee_id', '=', 'employee.id')
        ->select(
            'employee.id',
            'employee.staffid',  'employee.firstname',  'employee.lastname', 'employee.sallery', // You can add other employee columns as needed
            DB::raw('COUNT(attendance.id) as total_attendance'),
            DB::raw('COUNT(leave_master.id) as total_leaves')
        )
        ->where(function ($query) use ($currentMonth, $currentYear) {
            $query->whereMonth('attendance.created_ate', $currentMonth)
                  ->whereYear('attendance.created_ate', $currentYear)
                  ->orWhereNull('attendance.created_ate');
        })
        ->where(function ($query) use ($currentMonth, $currentYear) {
            $query->whereMonth('leave_master.created_at', $currentMonth)
                  ->whereYear('leave_master.created_at', $currentYear)
                  ->orWhereNull('leave_master.created_at');
        })
        ->groupBy('employee.id', 'employee.staffid' , 'employee.firstname',  'employee.lastname', 'employee.sallery'); // Add any other employee fields you want to group by
        // ->get();

    //    dd($data->get());

        if ($searchValue != null) {
            $data->where(function($query) use ($searchValue) {
                $query->where('Designation', 'like', '%' . $searchValue . '%');
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
            $total_attendance = $val->total_attendance;
            $total_leaves = $val->total_leaves;

            $sallery = $val->sallery ?? '0';
            $paysallery = $sallery * $total_attendance;

            // $action = '<a class="dropdown-items text-success viewall" href="javascript:void(0);" style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
            $action = '&nbsp;<a href="javascript:void(0);"  class="text-primary pay" data-id="'.$id.'"><i class="bi bi-paypal" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger hold" data-id="'.$id.'"><i class="bi bi-envelope" aria-hidden="true" ></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="text-success view" data-id="'.$id.'"><i class="bi bi-eye" aria-hidden="true" ></i></a>';

            $data_arr[] = array(
              "id" => ++$start,
              "staffid" => $staffid,
              'name' => $name,
              'total_attendance' => $total_attendance,
              'total_leaves' => $total_leaves,
              'sallery' => $sallery,
              'paysallery' => $paysallery,
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

    public function payamount(Request $request){

        // dd($request->all());

        $id = $request->id;

        $employee = employee::where('id' , $id)->first();

        // dd($employee);

        


    }

}
