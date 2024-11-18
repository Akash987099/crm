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
use Illuminate\Support\Str;
use App\Models\backend\Services;
use App\Models\agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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


    // manager

    public function Magent(){
        return view('managerend.agent');
    }

    public function MagentList(Request $request){

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

        // $state_search = $request->input('state_search');

        $data = Agent::where('manager_id' , Auth::guard('manager')->user()->id)->leftJoin('product', 'agent.project', '=', 'product.id')
        ->select('agent.*', 'product.name as project');
        // ->orderBy('agent.id', 'desc');
    
    // Add the search filtera
    if ($searchValue != null) {
        $data->where(function($query) use ($searchValue) {
            $query->where('agent.name', 'like', '%' . $searchValue . '%')
                  ->orWhere('agent.email', 'like', '%' . $searchValue . '%')
                  ->orWhere('agent.contact', 'like', '%' . $searchValue . '%')
                  ->orWhere('product.name', 'like', '%' . $searchValue . '%');
                  // Add more columns here if needed
        });
    }

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;

        $data = $data->orderBy('agent.id', 'desc')->get();
        $data_arr = array();
        

        foreach($data as $key => $val){
            $id = $val->id;
            $name = $val->name;
            $phone = $val->contact;
            $email = $val->email;
            $staff_id = $val->rrn_no;
            $payment_re = $val->payment_re;
            $payment_due =  $val->payment_due;
            $project   = $val->project;

           $district = $val->district;
           $state  = $val->state;
           $employee = $val->employee;
           $pincode  = $val->pincode;
           $aadhar_card =  $val->aadhar_card;
           $pan_card   = $val->pan_card;
           $lead_source = $val->lead_source;
           $document_add = $val->document_add;


            // $action = '<a class="dropdown-items text-success send" href="' . route('admin-view-agent', ['id' => Crypt::encrypt($id) , 'view' => 1]) . '" style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
            $action = '&nbsp;<a href="' . route('m_view_agent', ['id' => Crypt::encrypt($id) , 'view' => 2]) . '" class="text-primary edit"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';
            // $action .= '&nbsp;<a href="javascript:void(0);" class="btn btn-success btn-sm approve" data-id="'.$id.'">Approve</a>';
            // $action .= '&nbsp;<a href="javascript:void(0);" class="btn btn-danger btn-sm delete" data-id="'.$id.'">Reject</a>';

            $data_arr[] = array(
              "id" => ++$start,
              "name" => $name,
              "action" => $action,
              "phone"  => $phone,
              'email'  => $email,
              'staff_id' => $staff_id,
              'project'  => $project,
              'payment_re' => $payment_re,
              'payment_due' => $payment_due,
              'district'  => $district,
              'state'  => $state,
              'employee'  => $employee,
              'pincode'  => $pincode,
              'aadhar_card'  => $aadhar_card,
              'pan_card'  => $pan_card,
              'lead_source'  => $lead_source,
              'document_add'  => $document_add,
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

    public function MadminAddagent(){

        $product = DB::table('product')->get();
        // return view('managerend.add_agent')
        return view('managerend.add_agent' , compact('product'));

    }


    public function Maddagents(Request $request){

        $pincode = $request->pincode;
        $pancardno = $request->pancardno;
        $aadharcardno = $request->aadharcardno;
        $lead   = $request->lead;

        $name = $request->name;
        $contact = $request->contact;
        $email = $request->email;
        $District = $request->District;
        $Project = $request->Project;
        $Employee = $request->Employee;
        $RRN   = $request->RRN;
        $Payment = $request->Payment;
        $Due   = $request->Due;
        $aadharcard = $request->aadharcard;
        $aadhar   = $request->aadhar;
        $State = $request->State;

        $request->validate([
            'name' => 'required|string',
            'contact' => 'required|string',
            'email' => 'required|email',
            'District' => 'required|string',
            'Project' => 'required|string',
            'Employee' => 'required|string',
            'RRN' => 'required|string',
            'Payment' => 'required|numeric',
            'Due' => 'required|numeric',
            'aadharcard.*' => 'required|string',
            // 'aadharaddress.*' => 'required|string',
            'State'    => 'required',
            'adharaddress'    => 'required',
            'pincode'    => 'required',
             'aadhar.*' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $documents = [];
        $emailFolder = $request->email; 

        if ($request->hasFile('aadhar')) {
            foreach ($request->file('aadhar') as $key => $file) {
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        
                $cleanFileName = Str::slug($originalFileName);

                $extension = $file->getClientOriginalExtension();
                $fileName = $cleanFileName . '.' . $extension;
        
                $destinationPath = public_path("documents/{$emailFolder}");
        
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $file->move($destinationPath, $fileName);
        
                $documents[] = [
                    'aadharcard' => $request->input('aadharcard')[$key],
                    // 'aadharaddress' => $request->input('aadharaddress')[$key],
                    'file_path' => "documents/{$emailFolder}/{$fileName}",
                ];
            }
        }
        
        
        $id = 0;

        
        if($request->empl == 1){
            $id = Auth::guard('employee')->user()->id;
        }

        $data = [
            'manager_id' => Auth::guard('manager')->user()->id,
            'user_id' => $id,
            'name' => $name,
            'contact' => $contact,
            'email' => $email,
            'district' => $District,
            'employee' => $Employee,
            'rrn_no' => $RRN,
            'total_amount' => $Payment + $Due,
            'payment_re' => $Payment,
            'payment_due' => $Due,
            'state' => $State,
            'project' => $Project,
            'document_add' => $request->adharaddress,
            'document_name' => json_encode($request->aadharcard),
            'docuemnts' => json_encode($documents),
            'pan_card'  => $pancardno,
            'pincode'  => $pincode,
            'aadhar_card' => $aadharcardno,
            'lead_source' => $lead
        ];

        $insert = agent::create($data);

       
if($insert)
    {
        return back()->with('success', 'Add Successfully');
    }
    return back()->with('error', 'failed');

    }

    public function m_view_agent(Request $request){


        $id = Crypt::decrypt($request->id);
        $view = $request->view;

        // Fetch the agent using the decrypted ID
        // $agent = agent::where('id', $id)->first();
        $product = DB::table('product')->get();
        
        $agent = agent::where('agent.id', $id)->join('product' , 'agent.project' , '=' , 'product.id')->select('agent.*' , 'product.name as projectname')->first();
        
        if($agent->document_name == Null || $agent->docuemnts == NULL){
        $document_name = 0;
        $documents = 0;
        }else{
        $document_name = json_decode($agent->document_name, true); 
        $documents = json_decode($agent->docuemnts, true); 
        }

        $folderPath = public_path("documents/{$agent->email}");

        if (file_exists($folderPath)) {
            $files = array_diff(scandir($folderPath), array('.', '.. the folder and to make it clickable for download or viewing.', '..'));
        } else {
            $files = [];
        }
        
        $filesContent = [];
        
        foreach ($files as $file) {
            $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
            if (pathinfo($filePath, PATHINFO_EXTENSION) === 'txt') {
                $filesContent[$file] = file_get_contents($filePath);
            } else {
                $filesContent[$file] = 'Non-text file';
            }
        }
        
        return view('managerend.m_view_agent', compact('agent', 'document_name', 'documents' , 'view', 'product' , 'files' , 'filesContent'));
    }

    public function Mupdateagents(Request $request){

        $name = $request->name;
        $contact = $request->contact;
        $email = $request->email;
        $pincode = $request->pincode;
        $district = $request->District;
        $adharAddress = $request->adharaddress;
        $state = $request->State;
        $project = $request->Project;
        $employee = $request->Employee;
        $rrn = $request->RRN;
        $leadSource = $request->lead_source;
        $payment = $request->Payment;
        $due = $request->Due;
        $aadharCard = $request->aadharcard;
    
        $request->validate([
            'name' => 'required|string',
            'contact' => 'required|string',
            'email' => 'required|email',
            'District' => 'required|string',
            'Project' => 'required|string',
            'Employee' => 'required|string',
            'RRN' => 'required|string',
            'Payment' => 'required|numeric',
            'Due' => 'required|numeric',
            'aadharcard.*' => 'required|string',
            'State' => 'required',
        ]);
    
        $documents = [];
        $emailFolder = $request->email; 
    
        $agent = Agent::findOrFail($request->id);
        $existingDocuments = json_decode($agent->documents, true);
    
        // Ensure existingDocuments is an array
        if (!is_array($existingDocuments)) {
            $existingDocuments = [];
        }
    
        if ($request->hasFile('aadhar')) {
            foreach ($request->file('aadhar') as $key => $file) {
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $cleanFileName = Str::slug($originalFileName);
                $extension = $file->getClientOriginalExtension();
                $fileName = $cleanFileName . '.' . $extension;
                $emailFolder = $request->input('email');
    
                $destinationPath = public_path("documents/{$emailFolder}");
    
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
    
                $file->move($destinationPath, $fileName);
    
                $documents[] = [
                    'aadharcard' => $request->input('aadharcard')[$key],
                    'file_path' => "documents/{$emailFolder}/{$fileName}",
                ];
            }
    
            // Merge existing documents with new documents
            $allDocuments = array_merge($existingDocuments, $documents);
        } else {
            $allDocuments = $existingDocuments;
        }
    
        $data = [
            'name' => $name,
            'contact' => $contact,
            'email' => $email,
            'district' => $district,
            'employee' => $employee,
            'rrn_no' => $rrn,
            'payment_re' => $payment,
            'payment_due' => $due,
            'state' => $state,
            'project' => $project,
            'document_add' => $adharAddress,
            'document_name' => json_encode($aadharCard),
            'docuemnts' => json_encode($allDocuments),
        ];
    
        $update = agent::where('id', $request->id)->update($data);
    
        if ($update) {
            return back()->with('success', 'Updated Successfully');
        }
        return back()->with('error', 'Update Failed');

    }
  
    // Route::get('/agents', [Tele_HomeController::class, 'agent'])->name('agent');
    // Route::get('/agent/lists', [Tele_HomeController::class, 'agentList'])->name('agent-list');
    // Route::get('/agent/list/invoices', [Tele_HomeController::class, 'agentGetbyid'])->name('agent-Getbyid');
    // Route::get('/agent/list/singles', [Tele_HomeController::class, 'exportSingle'])->name('exportSingle');

}
