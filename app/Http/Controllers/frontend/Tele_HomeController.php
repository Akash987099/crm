<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\frontend\Client;
use App\Models\backend\Services;
use App\Models\agent;

class Tele_HomeController extends Controller
{

    public function agent(){
        return view('frontend.agent');
    }

    public function agentList(Request $request){
        
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

        $data = DB::table('agent');
       
        if ($searchValue != null) {
            $data->where(function($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            });
        }

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;

        $data = $data->get();
        $data_arr = array();

        foreach($data as $key => $val){

            $id = $val->id;
            $name = $val->name;
            $contact = $val->contact;
            $email = $val->email;
            $payment_re = $val->payment_re;
            $payment_due = $val->payment_due;
           

            $action = '<a class="dropdown-items text-success send btn btn-primary btn-sm text-light" href="' . route('agent-Getbyid', ['id' => Crypt::encrypt($id)]) . '" style="float:left;" data-id="'.$id.'" >invoice</a>';
            $action .= '&nbsp;<a href="' . route('exportSingle', ['id' => Crypt::encrypt($id)]) . '" class="text-light btn btn-primary btn-sm">Export</a>';
            // $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';

            // $action = "<button class='btn btn-primary btn-sm'>invoice</button>";

            $data_arr[] = array(
              "id" => ++$start,
              "action" => $action,
              "name" => $val->name,
            "contact" => $val->contact,
             "email" => $val->email,
            "payment_re" => $val->payment_re,
            "payment_due" => $val->payment_due,
            "total_amount" => $val->total_amount,
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

    public function agentGetbyid(Request $request){

        $id = Crypt::decrypt($request->id);

        // dd($id);

        $data = agent::where('id', $id)->first();
    
        if (!$data) {
            return redirect()->back()->withErrors(['msg' => 'Agent not found']);
        }
    
        $randomNumber = rand(1000000, 9999999);
    
        $invoiceId = "1" . $randomNumber . $id;
        $currentDate = now()->format('d/m/Y');
    
        return view('backend.invoice', compact('data', 'invoiceId' , 'currentDate'));

    }

    public function exportSingle(Request $request){

        $id = Crypt::decrypt($request->id);
        $agent = agent::where('id', $id)->first();

        if (!$agent) {
            return redirect()->back()->with('error', 'Agent not found');
        }
    
        $data = [
            ['ID', 'Name', 'Contact', 'Email', 'Payment Received', 'Payment Due', 'Total Amount'],
            [
                $agent->id,
                $agent->name,
                $agent->contact,
                $agent->email,
                $agent->payment_re,
                $agent->payment_due,
                $agent->total_amount,
            ]
        ];
    
        return Excel::download(new \App\Exports\ArrayExport($data), 'agent_' . $agent->id . '.xlsx');
    }

    public function TELE_HOME()
    {
        $total_lead = DB::table('clients')
            ->where('user_type', 0)
            ->where('user_id', '=', Session::get('user_id'))
            ->count();

        $calls = DB::table('calling')
            ->where('user_type', 0)
            ->where('user_id', '=', Session::get('user_id'))
            ->count();

        $now = date('d-m-Y');
        $today_call = DB::table('calling')
            ->where('user_type', 0)
            ->where('user_id', '=', Session::get('user_id'))
            ->where('created_date', '=', $now)
            ->count();

        $reject_call = DB::table('calling')
            ->where('user_id', '=', Session::get('user_id'))
            ->where('user_type', 0)
            ->where('status', 1)
            ->count();
        $recent_leads = DB::table('clients')
            ->where('user_type', 0)
            ->orderBy('id', 'desc')
            ->where('user_id', '=', Session::get('user_id'))
            ->limit(10)
            ->get();

        return view('frontend.home', compact('today_call', 'calls', 'total_lead', 'reject_call', 'recent_leads'));
    }


    public function RECENT_LEAD(Request $request)
    {

        $arr = [];
        $service = [];
        $meeting_id = Crypt::decrypt($request->id);
        $data = Client::where('id', $meeting_id)->first();

        if ($data->typeofuser == 1 && $data->user_type == 0) {
            $manager = DB::table('managers')->where('id', $data->assign_meating)->first();
        } elseif ($data->typeofuser == 2 && $data->user_type == 0) {
            $manager = DB::table('marketing_users')->where('id', $data->assign_meating)->first();
        } elseif ($data->typeofuser == 3 && $data->user_type == 0) {
            $manager = DB::table('bdes')->where('id', $data->assign_meating)->first();
        }

        $decode = json_decode($data->service);
        array_push($arr, $decode);
        foreach ($arr as $row) {
            $comp_service = Services::find($row);
            foreach ($comp_service as $row2) {
                array_push($service, $row2->service_name);
            }
        }




        return response()->json(array('data' => $data, 'service' => $service, 'manager' => $manager));
    }

    public function asset(){
        return view('frontend.asset');
    }
}
