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

class employeecontroller extends Controller
{

    public function student(){
        return "11111";
    }

    public function manageremployee(Request $request){
        return view('managerend.employee');
    }

    public function manageraddemployee(){
        $Designation = Designation::all();
        $manager = DB::table('managers')->where('user_type' , 2)->get();
        return view('managerend.add_employee' , compact('Designation' , 'manager'));
    }

    public function employeeprofile (){

        $empDesignation = Designation::where('id' , Auth::guard('employee')->user()->desigantion_id)->first();

        return view('employee.profile' , compact('empDesignation'));
    }

    public function Eprofileupdate(Request $request){
        //    dd($request->all());
           $firstname = $request->firstname;
           $lastname  =  $request->lastname;
           $address   = $request->address;
           $phone    = $request->phone;
           $profile_pic = $request->profile_pic;

           $update =  employee::where('id' , Auth::guard('employee')->user()->id)
                      ->update([
                        'firstname' => $firstname,
                        'lastname'  => $lastname,
                        'address'   => $address,
                        'phone'     => $phone,
                      ]);

                    if($update){
                        return response()->json(['status' => 'success']);
                    }
                    return response()->json(['status' => 'error']);

    }

    public function employee(){

        return view('backend.admin.employee');
        
    }

    public function addemployee(Request $request){
        $Designation = Designation::all();
        $manager = DB::table('managers')->where('user_type' , 2)->get();
        return view('backend.admin.add_employee' , compact('Designation' , 'manager'));
    }

    public function Designation(){
        return view('backend.admin.Designation');
    }

    public function saveDesignation(Request $request){
        // dd($request->all());
       $Designation =  $request->Designation;

       $rules = [
        'Designation' => 'required',
    ];

   

   
$validator = Validator::make($request->all(), $rules );
if ($validator->fails()) {
    return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
}

       $insert = Designation::create(['Designation' => $Designation , 'user_id' => Session::get('user_id')]);

       if($insert)
		{
			return response()->json(array('status'=>'success', 'message' => 'Save Successfully!'));
		}
		return response()->json(array('status'=>'error', 'message' => "failed!"));

    }

    public function Desinationlist(Request $request){

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


        $data = Designation::all();
        $data = DB::table('designation');

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
            $Designation = $val->Designation;

            // $action = '<a class="dropdown-items text-success viewall" href="javascript:void(0);" style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
            $action = '&nbsp;<a href="javascript:void(0);"  class="text-primary edit" data-id="'.$id.'"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';

            $data_arr[] = array(
              "id" => ++$start,
              "Designation" => $Designation,
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

    public function Designationid(Request $request){
        // dd($request->all());
        $id = $request->id;
        $update = $request->update;

        if($update){
            $data = Designation::where('id' , $update)->first();
        }else{
            $data = Designation::where('id' , $id)->delete();
        }

        

        if($data)
		{
			return response()->json(array('status'=>'success' , 'data' => $data));
		}
		return response()->json(array('status'=>'error'));

    }

    public function Designationupdate(Request $request){
        // dd($request->all());
        $updateid = $request->updateid;
        $Designation = $request->Designation;

        $rules = [
            'Designation' => 'required',
        ];
    
    $validator = Validator::make($request->all(), $rules );
    if ($validator->fails()) {
        return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
    }

    $update = Designation::where('id' , $updateid)->update(['Designation' => $Designation]);

    if($update)
    {
        return response()->json(array('status'=>'success'));
    }
    return response()->json(array('status'=>'error'));

    }

    public function addemployees(Request $request){
        // dd($request->all());

    //    $admin =  Auth::guard('admin')->user();

    //    dd($admin);

        $firstname = $request->firstname;
        $lastname  = $request->lastname;
        $staff_id  = $request->staff_id;
        $staff_role = $request->staff_role;
        $email    = $request->email;
        $phone   = $request->phone;
        $joining_date = $request->joining_date;
        $address = $request->address;
        $city    = $request->city;
        $pincode  = $request->pincode;
        $password = $request->password;
        $password_confirmation  = $request->password_confirmation;
        $state = $request->state;
        $bankname = $request->bankname;
        $accountno = $request->accountno;
        $ifsccode = $request->ifsccode;
        $aadharcard = $request->aadharcard;
        $pan = $request->pan;

        $Sallery   = $request->Sallery;
        $CTC   = $request->CTC;

        $image = $request->image;
        $aadhar = $request->aadhar;
        $pancard = $request->pancard;
        $passbook = $request->passbook;
        $checkbook = $request->checkbook;

        $directory = 'documents/' . $staff_id;

        // $request->validate([
        //     'firstname' => 'required',
        //     'Sallery' => 'required',
        //     'CTC' => 'required',
        //     'staff_id' => 'required',
        //     // 'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|digits:10',
        //     // 'phone' => 'required|unique:employee,phone',
        //     'email' => 'required|unique:employee,email',
        //     'aadharcard' => 'required|unique:employee,aadhar',
        //     'pan' => 'required|unique:employee,pancard',
        //     'employee_type' => 'required',
        // ],
        // [
        //     'aadharcard.unique' => 'The Aadhar Card number has already been taken.',
        //     'pan.unique' => 'The PAN number has already been taken.',
        // ]);

        // return "1111";

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store($directory, 'public');
        }

        if ($request->hasFile('aadhar')) {
            $aadhar = $request->file('aadhar');
            $path = $aadhar->store($directory, 'public');
        }

        if ($request->hasFile('pancard')) {
            $pancard = $request->file('pancard');
            $path = $pancard->store($directory, 'public');
        }

        if ($request->hasFile('passbook')) {
            $passbook = $request->file('passbook');
            $path = $passbook->store($directory, 'public');
        }

        if ($request->hasFile('checkbook')) {
            $checkbook = $request->file('checkbook');
            $path = $checkbook->store($directory, 'public');
        }

        $user_id = '0';
        if (Auth::guard('manager')->check() && Auth::guard('manager')->user()->user_type == 2) {
            $user_id = Auth::guard('manager')->user()->id;
        }  

        $data = [

            'manager_id' => $user_id,

            // 'user_id' => $request->assignuser,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'staffid'  => $staff_id,
            'desigantion_id' => $staff_role,
            'email'  => $email,
            'phone' => $phone,
            'joinningdate' => $request->joining_date,
            'city'   => $city,
            'pincode' => $pincode,
            'address' => $address,
            'password' => Hash::make($password),
            'show_password' => $password,
            'state'  => $state,
            'aadhar' => $aadhar,
            'pancard' => $pancard,
            'bank' => $bankname,
            'bankacc' => $accountno,
            'ifsc' => $ifsccode,
            'aadhar' => $aadharcard,
            'pancard' => $pan,

            'image' => $image,
            'aadhardoc' => $aadhar,
            'pandoc'   => $pancard,
            'bankdoc'  => $passbook,
            'checkbook' => $checkbook,



        ];

        $insert = DB::table('employee')->insert($data);

        if($insert)
    {
        return back()->with('success', 'Add Successfully');
    }
    return back()->with('error', 'failed');

    }

    public function update_employee(Request $request){
        // dd($request->all());

        $id   = $request->id;
        $id = Crypt::decrypt($id);
       
        $view  = $request->view;

        $data = employee::where('id' , $id)->first();
        $Designation = Designation::all();
        $manager = DB::table('managers')->where('user_type' , 2)->get();
        // dd($data);

        return view('backend.admin.view_employee' , compact('Designation' , 'data' , 'manager'));

    }

    public function adminupdateemp(Request $request){

        $updateid = $request->updateid;

        $firstname = $request->firstname;
        $lastname  = $request->lastname;
        $staff_id  = $request->staff_id;
        $staff_role = $request->staff_role;
        $email    = $request->email;
        $phone   = $request->phone;
        $joining_date = $request->joining_date;
        $address = $request->address;
        $city    = $request->city;
        $pincode  = $request->pincode;
        $password = $request->password;
        $password_confirmation  = $request->password_confirmation;
        $state = $request->state;
        $bankname = $request->bankname;
        $accountno = $request->accountno;
        $ifsccode = $request->ifsccode;
        $aadharcard = $request->aadharcard;
        $pan = $request->pan;

        $Sallery   = $request->Sallery;
        $CTC   = $request->CTC;

        $image = $request->image;
        $aadhar = $request->aadhar;
        $pancard = $request->pancard;
        $passbook = $request->passbook;
        $checkbook = $request->checkbook;

        $directory = 'documents/' . $staff_id;

        // $request->validate([
        //     'firstname' => 'required',
        //     'Sallery' => 'required',
        //     'CTC' => 'required',
        //     'staff_id' => 'required',
        //     'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|digits:10',
        //     'email' => 'required',
        // ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store($directory, 'public');
        }

        if ($request->hasFile('aadhar')) {
            $aadhar = $request->file('aadhar');
            $path = $aadhar->store($directory, 'public');
        }

        if ($request->hasFile('pancard')) {
            $pancard = $request->file('pancard');
            $path = $pancard->store($directory, 'public');
        }

        if ($request->hasFile('passbook')) {
            $passbook = $request->file('passbook');
            $path = $passbook->store($directory, 'public');
        }

        if ($request->hasFile('checkbook')) {
            $checkbook = $request->file('checkbook');
            $path = $checkbook->store($directory, 'public');
        }

        $data = [

            'user_id' => $request->assignuser,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'staffid'  => $staff_id,
            'desigantion_id' => $staff_role,
            'email'  => $email,
            'phone' => $phone,
            'joinningdate' => $joining_date,
            'city'   => $city,
            'pincode' => $pincode,
            'address' => $address,
            'password' => Hash::make($password),
            'state'  => $state,
            'aadhar' => $aadhar,
            'pancard' => $pancard,
            'bank' => $bankname,
            'bankacc' => $accountno,
            'ifsc' => $ifsccode,
            'aadhar' => $aadharcard,
            'pancard' => $pan,

            'image' => $image,
            'aadhardoc' => $aadhar,
            'pandoc'   => $pancard,
            'bankdoc'  => $passbook,
            'checkbook' => $checkbook,



        ];

        // $insert = employee::where('id' , $updateid)->update($data);
        $insert = DB::table('employee')->where('id' , $updateid)->update($data);

        if($insert)
    {
        return back()->with('success', 'Updat Successfully');
    }
    return back()->with('error', 'failed');



    }

    public function viewemployee(Request $request){
     
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

        if (Auth::guard('manager')->check()) {
            // dd('dfheghgh');
            $user_id = Auth::guard('manager')->user()->id;
            // dd($user_id);
            $data->where('employee.user_id', $user_id)->orwhere('manager_id' , $user_id);
        }        
        
        
        $data->leftjoin('designation' , 'employee.desigantion_id' , 'designation.id')->select('employee.*' , 'designation.Designation as Designation');

        if ($searchValue != null) {
            $data->where(function($query) use ($searchValue) {
                $query->where('employee.firstname', 'like', '%' . $searchValue . '%')
                      ->orwhere('employee.lastname' , 'like', '%' . $searchValue . '%')
                    ->orwhere('employee.staffid' , 'like', '%' . $searchValue . '%')
                    ->orwhere('employee.phone' , 'like', '%' . $searchValue . '%');
            });
        }

        if($request->userdata != NULL){

            $data->where('employee.user_type' , $request->userdata);

        }

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;

        $data = $data->get();
        $data_arr = array();
        

        foreach($data as $key => $val){
            $id = $val->id;
            $name = $val->firstname;
            $name .= $val->lastname;
            $phone = $val->phone;
            $email = $val->email;
            $staff_id = $val->staffid;
            $date = $val->joinningdate;
            $roll =  $val->Designation;
            // $status = $val->check_status;

           if ($val->check_status == 0) {
            $status = '<a class="dropdown-items btn btn-success btn-sm tglbtn" href="javascript:void(0);" style="float:left;" data-id="'.$id.'" >Active</a>';
             }elseif($val->check_status == 1){
            $status = '<a class="dropdown-items btn btn-danger btn-sm tglbtn" href="javascript:void(0);" style="float:left;" data-id="'.$id.'" >Deactive</a>';
             }

         
            $action = '<a class="dropdown-items text-success send" href="javascript:void(0);" style="float:left;" data-id="'.$id.'" ><i class="bi bi-envelope" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="' . route('update_employee', ['id' => Crypt::encrypt($id) , 'view' => 1]) . '"  class="text-primary edit" data-id="'.$id.'"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="btn btn-primary btn-sm reset" data-id="'.$id.'">Reset Password</a>';
            $action .= '&nbsp;<a href="' . route('employeeLogin', ['id' => Crypt::encrypt($id)]) . '" class="btn btn-primary btn-sm reset" data-id="'.$id.'">Login</a>';

            $data_arr[] = array(
              "id" => ++$start,
              "name" => $name,
              "action" => $action,
              "phone"  => $phone,
              'date'  => $date,
              'email'  => $email,
              'staff_id' => $staff_id,
              'status'  => $status,
              'roll'  => $roll,
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

    public function employeechangeStatus(Request $request){

        // dd($request->all());
        $id = $request->id;

        $currentStatus = Employee::where('id', $id)->value('check_status');
        
        $update = Employee::where('id', $id)->update([
            'check_status' => $currentStatus == 0 ? 1 : 0,
        ]);

        if($update){
             return response()->json(['status' => 'success']);
        }
              return response()->json(['status' => 'error']);

    }

    public function userChangepass(Request $request){

        // dd($request->all());
        $newpassword = $request->newpassword;
        $confirmpassword = $request->confirmpassword;
      
        $rules = [
            'newpassword' => 'required',
            'confirmpassword' => 'required|same:newpassword',
        ];
    
        $customMessages = [
            'confirmpassword.same' => 'The new password and confirm password must match.',
            'newpassword.required' => 'The new password field is required.',
            'confirmpassword.required' => 'The confirm password field is required.',
        ];        
            
        $validator = Validator::make($request->all(), $rules, $customMessages);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        $password = Hash::make($request->newpassword);

        $changeid = $request->changeid;

        if($request->changeid == NULL){
               $changeid = Auth::guard('employee')->user()->id;
        }

        $change = DB::table('employee')->where('id' , $changeid)->update([
            'password' => $password,
            'show_password' => $request->newpassword,
        ]);

        if($change){
          return response()->json(['status' => 'success', 'message' => "Suucessfully Password Change"]);
        }else{
            return response()->json(['status' => 'error', 'message' => "Failed! Password Change"]);
        }

    }

    public function deleteemployee(Request $request){
        // dd($request->all());
        $id  = $request->id;
        $archive = $request->archive;

        if($id){
          $update =  employee::where('id' , $id)->delete();
        }elseif($archive){
            $update =  employee::where('id' , $archive)->delete();
        }

        if($update)
    {
        return response()->json(array('status'=>'success'));
    }
    return response()->json(array('status'=>'error'));

    }

    public function archiveemployee(){
        return view('backend.admin.delete_employee');
    }

    public function archiveemployeeview(Request $request){


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


        $data = employee::where('employee.status' , 0)->join('designation' , 'employee.desigantion_id' , 'designation.id')->select('employee.*' , 'designation.Designation as Designation');

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;

        $data = $data->get();
        $data_arr = array();
        

        foreach($data as $key => $val){
            $id = $val->id;
            $name = $val->firstname;
            $name .= $val->lastname;
            $phone = $val->phone;
            $email = $val->email;
            $staff_id = $val->staffid;
            $date = $val->joinningdate;
            $roll =  $val->Designation;

            // $action = '<a class="dropdown-items text-success viewall" href="javascript:void(0);" style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
            $action = '&nbsp;<a href="javascript:void(0);"  class="text-primary delete" data-id="'.$id.'"><i class="bi bi-arrow-clockwise" aria-hidden="true"></i></a>';
            // $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';

            $data_arr[] = array(
              "id" => ++$start,
              "name" => $name,
              "action" => $action,
              "phone"  => $phone,
              'date'  => $date,
              'email'  => $email,
              'staff_id' => $staff_id,
              'roll'  => $roll,
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


    public function employeeLogin(Request $request){
        // dd($request->all());
        
        if ($request->has('id')) {

            $id = Crypt::decrypt($request->id);

        } else {

            $id = 1; 
        }

        $logindata = employee::where('id' , $id)->first();
        return view('employee.login' , compact('logindata'));
    }

    public function employeeLogins(Request $request)
    {

        //  return "55555";    
        
        // $current_time = Carbon::now()->setTimezone('Asia/Kolkata');
        // $start_time = Carbon::createFromTime(9, 0, 0, 'Asia/Kolkata'); // 9:00 AM
        // $end_time = Carbon::createFromTime(18, 0, 0, 'Asia/Kolkata'); // 6:00 PM

        // if ($current_time->lt($start_time) || $current_time->gt($end_time)) {
        //     return response()->json(['status' => "timeout", 'message' => 'Login is allowed only between 9 AM and 6 PM IST.']);
        // }

        $credentials = $request->only('email', 'password');

        $employee = Employee::where('email', $request->email)->first();
        
        if ($employee && $employee->check_status == 0) {
            if (Auth::guard('employee')->attempt($credentials)) {

                return response()->json(['status' => 'success']);
                // return redirect()->route('index');
            } else {
                return back()->withErrors(['password' => 'Invalid password']);
            }
        } else {
            return back()->withErrors(['email' => 'Invalid credentials or account is inactive']);
        }
        
    }

    public function employeelogout(Request $request){

        Auth::guard('employee')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('employeeLogin');

    }


    public function index(){
        $empID =  Auth::guard('employee')->user()->id;
        $leave = leave::where('employee_id' , $empID)->count();
        $lead = Client::where('user_id' , Auth::guard('employee')->user()->id)->count();
        $agent = agent::where('user_id' , Auth::guard('employee')->user()->id)->count();
        return view('employee.index' , compact('leave' , 'lead' , 'agent'));
    }
  
    public function AddAccount(Request $request){

        // dd($request->all());

        $id = $request->id;
        $debit = $request->debit;
        $creadit = $request->creadit;
        $status = $request->status;
        $total  = $request->total;
        $description = $request->description;

        $data = [

            'emp_id' => $id,
            'debit' => $debit,
            'creadit' => $creadit,
            'status' => $status,
            'total' => $total,
            'description' => $description

        ];

        $insert = DB::table('account_manage')->insert($data);

        return response()->json(['status' => 'success']);

    }

    //  agent start

    public function agentmaster(Request $request){

        $product = DB::table('product')->get();
       return view('backend.agent.index' , compact('product'));
    }

    public function AddAgent(Request $request){
        $product = DB::table('product')->get();
        return view('backend.agent.add' , compact('product'));
    }

    public function Product(){
        return view('backend.product');
    }

    public function AddProduct(Request $request){
        // dd($request->all());

        $product = $request->product;

        $rules = [
            'product' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
         return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
         }

         $insert = DB::table('product')->insert(['name' => $product]);

         if ($insert) {

            return response()->json(['status' => 'success', 'message' => 'Update Successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed!']);
        }

    }

    public function VIEWProduct(Request $request){

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


        $data = DB::table('product');

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

            $action = '<a class="dropdown-items text-success viewall" href="javascript:void(0);" style="float:left;" data-id="'.$id.'" ><i class="bi bi-pencil" aria-hidden="true"></i></a>';
            // $action = '&nbsp;<a href="javascript:void(0);"  class="text-primary delete" data-id="'.$id.'"><i class="bi bi-arrow-clockwise" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';

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

    public function deleteProduct(Request $request){

        // dd($request->all());

        $id  = $request->id;
        $update = $request->update;

        if($update != NULL){
            $delete = DB::table('product')->where('id' , $update)->first();
        }else{
            $delete = DB::table('product')->where('id' , $id)->delete();
        }
       

        if ($delete) {

           return response()->json(['status' => 'success', 'message' => 'Update Successfully' , 'data' => $delete]);
       } else {
           return response()->json(['status' => 'error', 'message' => 'Failed!']);
       }

    }

    public function updateproduct(Request $request){

        // dd($request->all());

        $updateid = $request->updateid;
        $product  = $request->product;

        $rules = [
            'product' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
         return response()->json(['status' => 'error' , 'message' => $validator->errors()]);
         }

         $insert = DB::table('product')->where('id' , $updateid)->update(['name' => $product]);

         if ($insert) {

            return response()->json(['status' => 'success', 'message' => 'Update Successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed!']);
        }

    }

    public function accountManager(Request $request){

        $data = DB::table('account_manage')->join('employee' , 'account_manage.emp_id' , '=' , 'employee.id')->get();

        return view('managerend.account-manager' , compact('data'));

    }

    public function accountview(Request $request){

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


        $data = DB::table('employee');

       
        if ($searchValue != null) {
            $data->where(function($query) use ($searchValue) {
                $query->where('firstname', 'like', '%' . $searchValue . '%');
            });
        }

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;

        $data = $data->get();
        $data_arr = array();
        
        // dd($data);
        foreach($data as $key => $val){
            $id = $val->id;
            $name = $val->firstname;
            $name .= ' ' .$val->lastname;

            $action = '<a class="dropdown-items text-success viewall" href=" ' . route('account-details' , ['id' => $id]) .' " style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
            
            $data_arr[] = array(
              "id" => ++$start,
              "name" => $name,
              'email' => $val->email,
              'phone' => $val->phone,
              'ctc'  => $val->ctc,
              "action" => $action,
            );

        }

        $response = array(
            "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr,
        );

        echo json_encode($response); 

    }

    public function accountdetails(Request $request){

        // return response()->json(['status' => 'pending']);

        // dd($request->all());

        $id = $request->id;

        $employee = employee::where('id' , $id)->first();
        $amount_pay = DB::table('amount_pay')->where('employee_id' , $id)->get();
        $pfms = DB::table('amount_pay')->where('employee_id' , $id)->sum('pfms');
        $profession = DB::table('amount_pay')->where('employee_id' , $id)->sum('profession');
        $extra = DB::table('amount_pay')->where('employee_id' , $id)->sum('extra');
        $amount = DB::table('amount_pay')->where('employee_id' , $id)->sum('amount');

        $totalamount = $pfms + $profession + $extra + $amount ;


        return view('managerend.account-details' , compact('employee' , 'totalamount' , 'amount_pay'));

    }

}
