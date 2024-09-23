<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\employee;
use App\Models\leave;
use App\Models\agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Purifier;
use Illuminate\Support\Facades\Storage;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class agentcontroller extends Controller
{

    public function adminagent(){
        return view('backend.admin.agent');
    }

    public function agent_view(Request $request){

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

        $data = Agent::leftJoin('product', 'agent.project', '=', 'product.id')
        ->select('agent.*', 'product.name as project');
        // ->orderBy('agent.id', 'desc');
    
    // Add the search filter
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


            $action = '<a class="dropdown-items text-success send" href="' . route('admin-view-agent', ['id' => Crypt::encrypt($id) , 'view' => 1]) . '" style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="' . route('admin-view-agent', ['id' => Crypt::encrypt($id) , 'view' => 2]) . '" class="text-primary edit"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="btn btn-success btn-sm approve" data-id="'.$id.'">Approve</a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="btn btn-danger btn-sm delete" data-id="'.$id.'">Reject</a>';

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

    public function addagents(Request $request){

        // dd($request->all()); 

        
        
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

    public function updateagents(Request $request){

        // dd($request->all());

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

    public function Addview(Request $request){


        

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


        $data = agent::leftjoin('product' , 'agent.project' , '=' , 'product.id')
        ->where('agent.user_id' , Auth::guard('employee')->user()->id)
        ->select('agent.*' , 'product.name as project')
        ->orderBy('id' , 'desc');

        // dd($data->get());

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;

        $data = $data->get();
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

            $action = '<a class="dropdown-items text-success send" href="' . route('view-agent', ['id' => Crypt::encrypt($id) , 'view' => 1]) . '" style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="' . route('view-agent', ['id' => Crypt::encrypt($id) , 'view' => 2]) . '" class="text-primary edit"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';

            $data_arr[] = array(
              "id" => ++$start,
              "name" => $name,
              "action" => $action,
              "phone"  => $phone,
              'email'  => $email,
              'staff_id' => $staff_id,
              'project'  => $project,
              'payment_re' => $payment_re,
              'payment_due' => $payment_due
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

    public function admin_Add_agent(Request $request){

        $product = DB::table('product')->get();
       return view('backend.admin.add_agent' , compact('product'));

    }

    public function deleteagent(Request $request){
        // dd($request->all());
        $id = $request->id;

        $agent = agent::where('id', $id)->delete();
        

        if($agent){
             return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'failed']);

    }

    public function viewagent(Request $request){
        // dd($request->all());

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
        
        
        return view('backend.agent.view', compact('agent', 'document_name', 'documents' , 'view', 'product'));
        
    }

    public function admin_view_agent(Request $request){

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
        
        return view('backend.admin.agent-view', compact('agent', 'document_name', 'documents' , 'view', 'product' , 'files' , 'filesContent'));

    }
    
    public function getpincode(Request $request){
        // dd($request->all());
        $value = $request->value;
        
        $data = DB::table('cities')->where('pincode' , $value)->first();
        $region_id = $data->region_id;
        $state = DB::table('regions')->where('id' , $region_id)->first();
        $description = $state->description;
        $name    = $data->name;
        
        $data = [
            'city' => $name,
            'state' => $description,
            ];
            
            return $data;
        
    }

    public function importagents(Request $request){

        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $path = $request->file('file')->getRealPath();
        $rows = Excel::toArray([], $path)[0];

        foreach ($rows as $row) 
        {

            $data = [
                'name' => $row[0],
                'contact' => $row[1],
                'email' => $row[2],
                'district' => $row[3],
                'state' => $row[4],
                'pincode' => $row[5],

                'employee' => $row[6],
                'rrn_no' => $row[7],

                'payment_re' => $row[8],
                'payment_due' => $row[9],

                'aadhar_card' => $row[10],
                'pan_card' => $row[11],
                'lead_source' => $row[12],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $insert = agent::create();

           
        }

        return response()->json(['status' => 'success']);

    }

    public function admin_messages(Request $request){

        return view('backend.message');

    }

    public function messagessave(Request $request){

        // dd($request->all());

        $message = $request->message;

        $rules = [

            'message' => 'required',
            
         ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
        }

        $insert = DB::table('messages')->insert(['message' => $message]);

        if($insert){
            return response()->json(['status' => 'success' , 'message' => "Add message successfully"]);
        }else{
            return response()->json(['status' => 'error' , 'message' => "Failed add messages"]);
        }

    }

    public function view_messages(Request $request){

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


        $data = DB::table('messages')
        ->orderBy('id' , 'desc');

        // dd($data->get());

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;

        $data = $data->get();
        $data_arr = array();
        

        foreach($data as $key => $val){
            $id = $val->id;
            // $name = $val->message;
            $name = strip_tags($val->message);

            // dd($name);

            // $action = '<a class="dropdown-items text-success send" href="' . route('view-agent', ['id' => Crypt::encrypt($id) , 'view' => 1]) . '" style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
           
            $action = '<button class="btn btn-primary sendmail" data-id=" ' .$id .' ">send message </button>';
            // $action .= '&nbsp;&nbsp;<a class="dropdown-items text-success send" href="' . route('view-agent', ['id' => Crypt::encrypt($id) , 'view' => 1]) . '" style="float:left;" data-id="'.$id.'" ><i class="bi bi-trash" aria-hidden="true"></i></a>';
           

            $data_arr[] = array(
              "id" => ++$start,
              "name" => $name,
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

    public function sendmailajax(Request $request){

        // dd($request->all());

        $id = $request->id;

        $update = DB::table('messages')->where('id' , $id)->update(['status' => 1 ,'updated_at' => Carbon::now() ]);

        if($update){
            return response()->json(['status' => 'success' , 'message' => "Send successfully"]);
        }else{
            return response()->json(['status' => 'error' , 'message' => "Failed add messages"]);
        }

    }

    public function getMessages(Request $request){

        $today = Carbon::today()->toDateString(); 

        $data = DB::table('messages')
            ->where('status', 1)
            ->whereDate('updated_at', $today); 
    
        $totalmessage = $data->count();
    
        $data = $data->get();
    
        return response()->json([
            'status' => 'success',
            'totaldata' => $totalmessage,
            'data' => $data
        ]);

    }

    public function employee_notification_view(){

        return view('employee.notification');

    }

    public function notification_viewGet(Request $request){

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


        $data = DB::table('messages')->where('status' ,1)
        ->orderBy('updated_at' , 'desc');

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;

        $data = $data->get();
        $data_arr = array();
        

        foreach($data as $key => $val){
            $id = $val->id;
            $name = strip_tags($val->message);
            $name = substr($name, 0, 25);

            $action = '';
  
            if(ViewPermission(2)){
            $action = '<a class="dropdown-items text-success send" href="' . route('notification_viewGetID', ['id' => Crypt::encrypt($id) , 'view' => 1]) . '" style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
            }

            $data_arr[] = array(
              "id" => ++$start,
              "name" => $name,
              "date" => $val->updated_at,
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

    public function notification_viewGetID(Request $request){

        $id = Crypt::decrypt($request->id);

        $data = DB::table('messages')->where('id' , $id)->first();
        // dd($data);
        
        $name = strip_tags($data->message);

        return view('employee.notification-view' , compact('name'));

    }

}
