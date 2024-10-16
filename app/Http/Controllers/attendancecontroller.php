<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\employee;
use App\Models\leave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\frontend\Client;
use App\Models\File;

class attendancecontroller extends Controller
{
    public function Eattendance (){
        return view('employee.attendance');
    }

    public function hiring(){
        return view('managerend.hiring');
    }

    public function hiringSave(Request $request){
        // return "111111";
        // dd($request->all());

        // $rules = [ 
        //     'name' => 'required,',
        //     'phone' => 'required',
        //     'email'        => 'required',
        //     'dob'    => 'required',
        //     'country'  => 'required',
        //     'city'  => 'required',
        //     'state' => 'required',
        //     'address' => 'required',
        //     'pincode' => 'required',
        //     'doc' => 'required|mimes:pdf,doc,docx,jpg,png|max:2048', 


        //  ];
    
        // $validator = Validator::make($request->all(), $rules);
    
        // if ($validator->fails()) {
        //     return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        // }

        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $dob   = $request->dob;
        $country = $request->country;
        $city = $request->city;
        $state = $request->state;
        $address = $request->address;
        $pincode = $request->pincode;

        $imageName = "Null";
        if ($request->hasFile('doc')) {
            $image = $request->file('doc');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('doc'), $imageName);
        }

        $insert = DB::table('hiring')->insert([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'dob'  => $dob,
            'country' => $country,
            'city' => $city,
            'state' => $state,
            'address' => $address,
            'pincode' => $pincode,
            'documents' => $imageName,
        ]);

        if($insert){
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }

    public function hiringupdate(Request $request){

        // dd($request->all());
        $updateid = $request->updateid;

        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $dob   = $request->dob;
        $country = $request->country;
        $city = $request->city;
        $state = $request->state;
        $address = $request->address;
        $pincode = $request->pincode;

        // $imageName = "Null";
        // if ($request->hasFile('doc')) {
        //     $image = $request->file('doc');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('doc'), $imageName);
        // }

        $insert = DB::table('hiring')->where('id' , $updateid)->update([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'dob'  => $dob,
            'country' => $country,
            'city' => $city,
            'state' => $state,
            'address' => $address,
            'pincode' => $pincode,
            // 'documents' => $imageName,
        ]);

        if($insert){
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);

    }

    public function hiringAjax(Request $request){

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


        $data = DB::table('hiring');;

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;

        $data_arr = array();

        $list = $data->get();

        foreach($list as $key => $val){

            $id = $val->id;
            $name = $val->name;

            
            $date = Carbon::parse($val->dob)->format('d-m-Y');

            $action = '&nbsp;<a href="javascript:void(0);"  class="text-primary edit" data-id="'.$id.'"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';

            $data_arr[] = array(
              "id" => ++$start,
              'name' => $name,
              'phone' => $val->phone,
              'email' => $val->email,
              "date"   => $date,
              'address' => $val->address,
              "action"     => $action,
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

    public function hiringdelete(Request $request){

        // dd($request->all());

        $delete = $request->id;
        $update = $request->update;

        if($delete) {
            $data = DB::table('hiring')->where('id' , $delete)->delete();
        }

        if($update){
            $data = DB::table('hiring')->where('id' , $update)->first();
        }

        return response()->json(['status' => 'success' , 'data' => $data]);

    }

    public function manager_attendance(){
        $employee = employee::all();
        return view('managerend.attendance' , compact('employee'));
    }

    public function EattendanceList(Request $request){

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


        $data = DB::table('attendance')->where('user_id' , Auth::guard('employee')->user()->id)->orderby('id' , 'desc')->get();

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;

        $data_arr = array();

        foreach($data as $key => $val){
            $id = $val->id;
            $login_time = $val->login_time;
            $logout_time = $val->logout_time;
            // $imageUrl = asset('public/".$val=->image."')
            // dd($imageUrl);
            $date = Carbon::parse($val->created_ate)->format('d-m-Y');

            $emp = Auth::guard('employee')->user()->staffid;
            $staffpath = str_replace('#', '', $emp);

               $image = '<img src="' . asset('storage/app/public/attendance/' . $staffpath . '/' . $val->image) . '" alt="Attendance Image" style="width: 100px; height: auto;">';


            // $action = '<a class="dropdown-items text-success viewall" href="javascript:void(0);" style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
            $action = '&nbsp;<a href="javascript:void(0);"  class="text-primary edit" data-id="'.$id.'"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';

            $data_arr[] = array(
              "id" => ++$start,
              "login_time" => $login_time,
              "logout_time" => $logout_time,
              "date"   => $date,
              "image"     => $image,
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

    public function employee_save_attendane(Request $request){

        $request->validate([
            'image' => 'required',
        ]);

        // $check = 

        $imageData = $request->input('image'); 
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $imageName = 'camera_capture_' . time() . '.png';
    
        $decodedImage = base64_decode($imageData);

        $id = Auth::guard('employee')->user()->id;
    
        $employee = employee::where('id', $id)->first();
        
        $staffpath = str_replace('#', '', $employee->staffid);
    
        $directory = 'attendance/' . $staffpath;
    
        $path = Storage::disk('public')->put($directory . '/' . $imageName, $decodedImage);

        $todayDate =  Carbon::today('Asia/Kolkata');
        $todayAttendance = DB::table('attendance')
            ->where('user_id', $id)
            ->whereRaw('DATE(created_ate) = ?', [$todayDate])
            ->first();

        if ($todayAttendance) {
            return response()->json(['status' => 'error']);
        }
    
        if ($path) {

            DB::table('attendance')->insert([
                'user_id' => $id,
                'login_time' => Carbon::now('Asia/Kolkata'),
                'image' => $imageName,
                'created_ate' => $todayDate,
            ]);

            return response()->json(['status' => 'success']);
        } else {
            return back()->with('error', 'Failed to upload the image.');
        }
    
    }  

    public function Admin_attendance(Request $request){

        $employee = employee::all();
        return view('backend.admin.attendance' , compact('employee'));
    }

    public function Admin_attendance_view(REquest $request){

        // dd($request->all());

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
        

        $data = DB::table('attendance')
        ->leftJoin('employee', 'attendance.user_id', '=', 'employee.id')
        ->select('attendance.*', 'employee.staffid as staffid', 'employee.firstname', 'employee.lastname')
        ->orderBy('attendance.id', 'desc');

        if (Auth::guard('manager')->check() && Auth::guard('manager')->user()->user_type == 2) {
            $user_id = Auth::guard('manager')->user()->id;
            // $employee_ids = employee::where('user_id', $user_id)->pluck('id');
            $data->where('employee.user_id', $user_id);
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
            $login_time = $val->login_time;
            $logout_time = $val->logout_time;
            $date = Carbon::parse($val->created_ate)->format('d-m-Y');

            $emp = $val->staffid;
            $name = $val->firstname;
            $name .= $val->lastname;

            // dd($val->image);
            $staffpath = str_replace('#', '', $emp);

               $image = '<img src="' . asset('storage/app/public/attendance/' . $staffpath . '/' . $val->image) . '" alt="Attendance Image" style="width: 100px; height: auto;">';


            // $action = '<a class="dropdown-items text-success viewall" href="javascript:void(0);" style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
            // $action = '&nbsp;<a href="javascript:void(0);"  class="text-primary edit" data-id="'.$id.'"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>';
            $action = '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';

            $data_arr[] = array(
              "id" => ++$start,
              "login_time" => $login_time,
              "logout_time" => $logout_time,
              "date"   => $date,
              "image"     => $image,
              "name"   => $name,
              "emp"   => $emp,
              'action' => $action
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

    public function deleteattenance(Request $request){
        // dd($request->all());

        $data = DB::table('attendance')->where('id' , $request->id)->delete();

        if($data){
            return response()->json(['status' => 'success']);
        }

    }

    public function admin_leave(Request $request){

        return view('backend.admin.leave');

    }

    public function admin_leaveAjax(Request $request){
        
        // dd($request->all());
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

        $data = DB::table('leave_master')->where('leave_master.status' , NULL)
        ->leftJoin('employee', 'leave_master.employee_id', '=', 'employee.id')
        ->whereDate('leave_master.created_at', $currentDate)
        ->select('leave_master.*' , 'employee.staffid as staffid' , 'employee.firstname' , 'employee.lastname')
        ->orderBy('leave_master.id', 'desc')
        ->get();

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;

        $data_arr = array();

        foreach($data as $key => $val){
            $id = $val->id;
            $subject = $val->subject;
            $reason = $val->reason;
            $date = Carbon::parse($val->created_at)->format('d-m-Y');

            $emp = $val->staffid;
            $name = $val->firstname;
            $name .= $val->lastname;

            // $action = '<a class="dropdown-items text-success viewall" href="javascript:void(0);" style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
            $action = '&nbsp;<a href="javascript:void(0);"  class="text-white btn btn-primary approve" data-id="'.$id.'">Approve</a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger btn btn-primary reject" data-id="'.$id.'">Reject</a>';

            $data_arr[] = array(
              "id" => ++$start,
              "subject" => $subject,
              "reason" => $reason,
              "date"   => $date,
            //   "image"     => $image,
              "name"   => $name,
              "emp"   => $emp,
              'action' => $action
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

    public function approvedleave(Request $request){
        // dd($request->all());
        $id = $request->id;

        $leave = leave::where('id' , $id)->update(['status' => 1]);

        if($leave){
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'success']);
        
    }

    public function rejectleave(Request $request){

        $id = $request->id;

        $leave = leave::where('id' , $id)->update(['status' => 0]);

        if($leave){
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'success']);

    }


    public function admin_Allemployee(Request $request){

        return view('report.employee');

    }

    

    public function admin_Allemployee_Ajax(Request $request){
        
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


        $data = DB::table('employee')
        ->leftjoin('designation' , 'employee.desigantion_id' , 'designation.id')
        ->select('employee.*' , 'designation.Designation as Designation');

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
            $address  =  $val->address;
            // $aadhar = $val->aadhar;
            // $pancrd = $val->pancard;

            $agentre = DB::table('agent')->where('user_id' , $id)->sum('payment_re');
            $payment_due = DB::table('agent')->where('user_id' , $id)->sum('payment_due');
    
            // dd($roll);

            // $action = '<a class="dropdown-items text-success send" href="javascript:void(0);" style="float:left;" data-id="'.$id.'" ><i class="bi bi-envelope" aria-hidden="true"></i></a>';
            // $action .= '&nbsp;<a href="javascript:void(0);"  class="text-primary edit" data-id="'.$id.'"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>';
            // $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';

            $data_arr[] = array(
              "id" => ++$start,
              "name" => $name,
              "phone"  => $phone,
              'date'  => $date,
              'email'  => $email,
              'staff_id' => $staff_id,
              'roll'  => $roll,
              'address' => $address,
              "payment_re" => $agentre,
              "payment_due"  => $payment_due,
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

    public function employee_file($parentId = null){

        // dd($parentId);
        $parent = File::find($parentId);
        $files = File::where('parent_id', $parentId)->where('user_id' , Auth::guard('employee')->user()->id)->get();
        return view('employee.file_management' , compact('files', 'parent'));
    }

    public function admin_file($parentId = null){
        //  dd($parentId);
        $parent = File::find($parentId);
        $files = File::where('parent_id', $parentId)->get();
        // dd($files);    
        return view('backend.file_management' , compact('files', 'parent'));
    }

    public function createFolder(Request $request)
    {

        // dd($request->all());
        $staffid = $request->staffid;
        $staffpath = str_replace('#', '', $staffid);
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:files,id',
            'staffid'  => 'required',
        ]);

        $check = File::where('staff_id' , $staffid)->first();
      
        // dd($check);

        if($check){

            return back()->with('error', 'Staff Id Already  exit!!');
           
        }else{
               

                $file =  File::create([
                    'name' => $request->name,
                    'path' => '',
                    'is_folder' => true,
                    'staff_id' => $staffpath,
                    'parent_id' => $request->parent_id,
                ]);
        
                if($file){
                    return back()->with('success', 'Folder created successfully');
                }
            }

       
    }

    public function EcreateFolder(Request $request){

        // dd($request->all());

        $staffid = $request->staffid;
        $staffpath = str_replace('#', '', $staffid);
        $request->validate([
            'name' => 'required|string|max:255',
            'staffid'  => 'required',
        ]);

        $check = File::where('staff_id' , $staffid)->first();
      
        // dd($check);

        if($check){
            //  return "1111";
            return back()->with('error', 'Staff Id Already  exit!!');
           
        }else{
               
            // return "2222";
                $file =  File::create([
                    'user_id' => Auth::guard('employee')->user()->id,
                    'name' => $request->name,
                    'path' => '',
                    'is_folder' => true,
                    'staff_id' => $staffpath,
                    'parent_id' => $request->parent_id,
                ]);
        
                if($file){
                    return back()->with('success', 'Folder created successfully');
                }else{
                    return back()->with('error', 'Failed!!');
                }
            }
       

    }

    public function EuploadFile(Request $request){

        // dd($request->all());

        $parent_id = $request->parent_id;

        $request->validate([
            'file' => 'required|mimes:jpeg,png,bmp,gif,svg,webp,pdf',
             'parent_id' => 'required',
        ]);
    
        // $parent = File::find($request->parent_id);
    
        $folderName = $parent_id ;
        $staffpath = str_replace('#', '', $folderName);
    
        $directory = 'uploads/' . $staffpath;
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }
    
        $file = $request->file('file');
        $path = $file->store($directory, 'public');
    
        $filenew =  DB::table('images')->insert([
            'user_id' => Auth::guard('employee')->user()->id,
            'image' => $file->getClientOriginalName(),
            'path' => $path,
            'staff_id' => $parent_id,
            'path' => $path,
            // 'parent_id' => $request->parent_id,
        ]);

        if($filenew){
            return response()->json(['status' =>  'success']);
        }else{
            return response()->json(['status' => 'error']);
        }

    }

    public function employee_file_view(Request $request){

        $id = $request->id;

        $filenew =  DB::table('images')->where('staff_id' , $id)->get();

        // dd($filenew);

        return view('employee.file_view' , compact('filenew'));

    }

    public function uploadFile(Request $request)
    {

        // dd($request->all());
        $parent_id = $request->parent_id;

        $request->validate([
            'file' => 'required|mimes:jpeg,png,bmp,gif,svg,webp,pdf',
             'parent_id' => 'required',
        ]);
    
        // $parent = File::find($request->parent_id);
    
        // $staffpath = $parent_id ;
        // $staffpath = str_replace('#', '', $folderName);
    
        $directory = 'uploads/' . $parent_id;

        // dd($directory);
        
        if (!Storage::disk('public')->exists($directory)) {
            // return "22222222";
            Storage::disk('public')->makeDirectory($directory);
        }

        // return "11111";
    
        $file = $request->file('file');
        $path = $file->store($directory, 'public');
    
        $filenew =  DB::table('images')->insert([
            'image' => $file->getClientOriginalName(),
            'path' => $path,
            'staff_id' => $parent_id,
            'path' => $path,
            // 'parent_id' => $request->parent_id,
        ]);

        if($filenew){
            return response()->json(['status' =>  'success']);
        }else{
            return response()->json(['status' => 'error']);
        }
    
       
    }

    public function deleteFile($id)
    {
        $file = File::find($id);

        if ($file->is_folder) {
            foreach ($file->children as $child) {
                $this->deleteFile($child->id);
            }
        } else {
            Storage::disk('public')->delete($file->path);
        }

        $file->delete();

        return back()->with('success', 'File/folder deleted successfully');
    }

    public function file_view(Request $request){

        // dd($request->all());
        $id = $request->id;

        $filenew =  DB::table('images')->where('staff_id' , $id)->get();

        // dd($filenew);

        return view('backend.file_view' , compact('filenew'));

    }

}
