<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\employee;
use App\Models\leave;
use App\Models\agent;
use App\Models\programs;
use App\Models\Privilege;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;

class statusController extends Controller
{

    public function Privilege(){

        $data = employee::all();

        return view ('backend.privileges' , compact('data'));

    }

    private function getUserPrivilegePermission($user_id, $program_id) {

        // dd($user_id , $program_id);
        
        if($user_id!="" && $user_id!=null){
            // return "555555";
            return Privilege::where(['user_id' => $user_id, 'program_id' => $program_id])->first();
        }
        
    }

    private function createUserPrivilege($data) {

        $status = Privilege::create($data);

        if($status)
        {
            return true;
        }
        return false;
    }

    private function getUserPrivilegeById($id)
    {
        return Privilege::findById($id);
    }

    private function updateUserPrivilegeById($id, $data) {
        $status = Privilege::where('id', $id)->update($data);
        if($status)
        {
            return true;
        }

        return false;
    }

    private function exceptionpPivilegeHandling($error)
    {
        $moduleObj = getModuleById(2);
        if($moduleObj)
        {
            $obj = \App\Components\AuditReportManager::getInstance();
            $data = array('name' => $moduleObj->Description, 'data' => $error, 'user_id' => Auth::guard('employee')->user()->id);
            $obj->save($data);
        }
    }


    public function Privilegeview(Request $request){

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        $module_id = null;
       // Total records
       $countData = programs::select('count(*) as allcount');

       if($request->user_id == null) {
           $countData->whereNull('programs.id');
       }

       
       $totalRecordswithFilter = $countData->count();
       $records = programs::select('programs.*')->orderBy('id', 'Asc')->skip($start)->take($rowperpage);
         
       if($request->user_id == null) {
           $records->whereNull('programs.id');
       }
      

       $list = $records->get();
       $data_arr = array();
       
       foreach($list as $sno => $record){
           $id = $record->id;
           $UserId = $record->user_id;
           $RoleId = $record->role_id;
           //$action = "<a href='{{ url('department/edit/'.$record->id) }}' target='_blank'><i class='fa fa-edit' style='color:blue' aria-hidden='true'></i></a>";

           $action = '<i class="fa fa-edit update fa-2x" style="color:blue;cursor:pointer" data-id="'.$record->id.'"></i>'; //'<a href="'.$url.'" target="_blank"><i class="fa fa-edit" style="color:blue"></i></a>';
           $action .= ' ';
           $action .= '<i class="fa fa-trash delete fa-2x" style="color:red;cursor:pointer" data-id="'.$record->id.'"></i>';


           $user_id = $request->user_id;
           $role_id = $request->role_id;
           
           $program_id = $record->id;

           $userPrivilegeObj = $this->getUserPrivilegePermission($user_id, $program_id);
           
           $pk = 0;
           $View_Option = $Add_Option = $Modify_Option  = $Delete_Option = '';
           if($userPrivilegeObj) {
               $pk = $userPrivilegeObj->id;
               if($userPrivilegeObj->view_priv == 1) {
                   $View_Option = 'checked';
               }
               if($userPrivilegeObj->add_priv == 1) {
                   $Add_Option = 'checked';
               }
               if($userPrivilegeObj->modify_priv == 1) {
                   $Modify_Option = 'checked';
               }
               if($userPrivilegeObj->del_priv == 1) {
                   $Delete_Option = 'checked';
               }
           }

           $view = '<input type="hidden" name="View_Option['.$id.']" value="0" /><input type="checkbox" class="View_Option" name="View_Option['.$id.']" value="1" '.$View_Option.'  />';
           $add = '<input type="hidden" name="Add_Option['.$id.']" value="0" /><input type="checkbox" class="Add_Option" name="Add_Option['.$id.']" value="1"  '.$Add_Option.'   />';
           $edit = '<input type="hidden" name="Modify_Option['.$id.']" value="0" /><input type="checkbox" class="Modify_Option" name="Modify_Option['.$id.']" value="1"  '.$Modify_Option.'   />';
           $delete = '<input type="hidden" name="Delete_Option['.$id.']" value="0" /><input type="checkbox" class="Delete_Option" name="Delete_Option['.$id.']" value="1"  '.$Delete_Option.'   />';

           $data_arr[] = array(
             "id" => ++$sno,
             "description" => $record->description,
             'view' => $view,
             'add' => $add,
             'edit' => $edit,
             'delete' => $delete,
           );
        }

        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecordswithFilter,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
        );

        echo json_encode($response);
    }

    public function handleprivilege(Request $request){
        //    dd($request->all());
            try
            {
                // return "11111";
                if ($request->isMethod('post'))
                {
                    // return "222222";
    
                    $userId = $request->user_id;
                    // dd($userId);
                    $params = array();
                    foreach($request->View_Option as $programId => $viewoption) {
                        $addoption = $modifyoption = $deleteoption = 0;
    
                        if(isset($request->Add_Option[$programId])) {
                            $addoption = $request->Add_Option[$programId];
                        }
    
                        if(isset($request->Modify_Option[$programId])) {
                            $modifyoption = $request->Modify_Option[$programId];
                        }
    
                        if(isset($request->Delete_Option[$programId])) {
                            $deleteoption = $request->Delete_Option[$programId];
                        }

                        $params = array('user_id' => $userId, 'program_id' => $programId, 'view_priv' => $viewoption, 'add_priv' => $addoption, 'modify_priv' => $modifyoption,
                        'del_priv' => $deleteoption
                        );

                        // dd($params);

                        $isObj = $this->getUserPrivilegePermission($userId , $programId);
                        // dd($isObj);
    
                        if($isObj)
                        {
                            // return "333333";
                            $this->updateUserPrivilegeById($isObj->id, $params);
    
                        } else {
                            $this->createUserPrivilege($params);
                        }
    
                    }
                    return response()->json(array('status'=>'success', 'message' => 'Privileges Saved.'));
                    //return response()->json(array('status'=>'success'));
                }
            }
            catch (\Throwable $e)
            {
                $error = $e->getMessage().', File Path = '.$e->getFile().', Line Number = '.$e->getLine();
                return response()->json(array('status'=>'exceptionError'));
            }
    
        }

    public function status(){
        return view('backend.status.status');
    }

    public function addsattus(Request $request){
    //    dd($request->all());
        $status = $request->status;

        $request->validate([
            'status' => 'required',
        ]);

        $status_master = DB::table('status_master')->insert(['status_name' => $status]);

        if($status_master)
    {
         return response()->json(['status' => "success"]);
    }
    return response()->json(['status' => "error"]);
    
        
    }

    public function viewstatus(Request $request){

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

        $status_master = DB::table('status_master');

        if ($searchValue != null) {
            $status_master->where(function($query) use ($searchValue) {
                $query->where('status_name', 'like', '%' . $searchValue . '%');
            });
        }

        $totalRecordswithFilter = DB::table('status_master')->count();
        $totalRecords = $totalRecordswithFilter;

        $status_master = $status_master->get();
        $data_arr = array();

        foreach($status_master as $key => $val){

            $id = $val->id;
            $name = $val->status_name;

            // $action = '<a class="dropdown-items text-success send" href="' . route('view-agent', ['id' => Crypt::encrypt($id) , 'view' => 1]) . '" style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
            $action = '&nbsp;<a href="javascript:void(0);" class="text-primary edit" data-id="'.$id.'"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>';
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

    public function deletestatus(Request $request){

        // dd($request->all());

        $id = $request->id;
        $update = $request->update;

        if($update){
            $delete = DB::table('status_master')->where('id' , $update)->first();
            // dd($delete);
        }else{
            $delete = DB::table('status_master')->where('id' , $id)->delete();
        }

    if($delete)
    {
         return response()->json(['status' => "success" , 'data' => $delete]);
    }
    return response()->json(['status' => "error"]);

    }

    public function updatestatus(Request $request){
        // dd($request->all());
        $updateid = $request->updateid;
        $status   = $request->status;

        $request->validate([
            'status' => 'required',
        ]);

        $status_master = DB::table('status_master')->where('id' , $updateid)->update(['status_name' => $status]);

        if($status_master)
    {
         return response()->json(['status' => "success"]);
    }
    return response()->json(['status' => "error"]);
    }

    public function admindivice(){

        // $employee =  employee::all();/

        return view('backend.device.index');

    }

    public function managerdivice(){
        return view('managerend.device');
    }

    public function add_divice(){
        $employee =  employee::all();
        return view('managerend.add_device' , compact('employee'));
    }

    public function adddivice(){
        $employee =  employee::all();
        return view('backend.device.add' , compact('employee'));
    }

    public function adddivices(Request $request){

        // dd($request->all());

        $emp_id = $request->emp_id;
        $employee = $request->employee;

        $request->validate([
            'Asset' => 'required',
            'Name' => 'required',
            'Model' => 'required',
            // 'Serial' => 'required',
            // 'Category' => 'required',
            // 'Location' => 'required',
            // 'Warranty' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg, pdf'
        ]);
    
        $imagePath = "0";

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
        }
    
        $data = [
            'asset_id' => $request->Asset,
            // 'emp_id' => $emp_id,
            'emp_name' => $employee,
            "status" => $request->status,
            'name' => $request->Name,
            'modal' => $request->Model,
            'serial' => $request->Serial,
            'category' => $request->Category,
            'location' => $request->Location,
            'date' => $request->Purchase,
            'purchased' => $request->Purchased,
            'price' => $request->Price,
            'warranty' => $request->warranty,
            'notes'    => $request->notes,
            'doc' => $imagePath,
        ];
    
        $insert = DB::table('device')->insert($data);
    
        if ($insert) {
            // return "111111";
            return back()->with('success', 'Add Successfully');
        } else {
            // return "222222";
            return back()->with('error', 'failed');
        }

    }

    public function updatedeive(Request $request){

        $request->validate([
            'Asset' => 'required',
            'Name' => 'required',
            'Model' => 'required',
            // 'Serial' => 'required',
            // 'Category' => 'required',
            // 'Location' => 'required',
            // 'Warranty' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg, pdf'
        ]);
    
        $imagePath = "0";

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
        }
    
        $data = [
            'asset_id' => $request->Asset,
            'name' => $request->Name,
            // "status" => $request->status,
            'modal' => $request->Model,
            'serial' => $request->Serial,
            'category' => $request->Category,
            'location' => $request->Location,
            'date' => $request->Purchase,
            'purchased' => $request->Purchased,
            'price' => $request->Price,
            'warranty' => $request->warranty,
            'notes'    => $request->notes,
            'doc' => $imagePath,
        ];
    
        $insert = DB::table('device')->where('id' , $request->id)->update($data);
    
        if ($insert) {
            // return "111111";
            return back()->with('success', 'Add Successfully');
        } else {
            // return "222222";
            return back()->with('error', 'failed');
        }


    }

    public function assestviewDevice(Request $request){

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

        $status_master = DB::table('device')->join('employee' , 'device.emp_name' , '=' , 'employee.id')->select('device.*'  , 'employee.firstname as firstname' , 'employee.lastname as lastname');

        if ($searchValue != null) {
            $status_master->where(function($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            });
        }

        $totalRecordswithFilter = $status_master->count();
        $totalRecords = $totalRecordswithFilter;

        $status_master = $status_master->get();
        $data_arr = array();

        foreach($status_master as $key => $val){

            $id = $val->id;
            $employee = $val->firstname . " " . $val->lastname;
            $name = $val->name;
            $modal = $val->modal;
            $serial = $val->serial;
            $date  = $val->date;
            $category = $val->category;
            $price = $val->price;
            $asset_id = $val->asset_id; 
            $status  = $val->status;
            $location = $val->location;
            $purchased  = $val->purchased;
            $notes =  $val->notes;

            if($status == 1){
                $status = "in use";
            }elseif($status == 2){
                $status = "Available";
            }elseif($status == 3){
                $status = "Out for repair";
            }elseif($status == 4){
                $status = "Broken/unfixable";
            }else{
                $status = "-";
            }

            // $action = '<a class="dropdown-items text-success send" href="' . route('view-agent', ['id' => Crypt::encrypt($id) , 'view' => 1]) . '" style="float:left;" data-id="'.$id.'" ><i class="bi bi-eye" aria-hidden="true"></i></a>';
            $action = '&nbsp;<a href="' . route('assetedit', ['id' => $id , 'manager' => 1]) . '" class="text-primary"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>';
            $action .= '&nbsp;<a href="javascript:void(0);" class="text-danger delete" data-id="'.$id.'"><i class="bi bi-trash" aria-hidden="true" ></i></a>';

            $data_arr[] = array(
                "employee" => $employee,
              "id" => ++$start,
              "name" => $name,
              "modal" => $modal,
              "serial" => $serial,
              "date"  => $date,
              "status" => $status,
              "price" => $price,
              "category" => $category,
              "asset_id" => $asset_id,
              "location" => $location,
              "purchased" => $purchased,
              "notes"   => $notes,
              "warranty"  => $val->warranty,
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

    public function assestdelete(Request $request){

        // dd($request->all());
        $id = $request->id;

        $delete = DB::table('device')->where('id' , $id)->delete();

        if($delete){
             return response()->json(['status' => "success"]);
        } 
        return response()->json(['status' => "error"]);

    }

    public function assetedit(Request $request){

        // dd($request->all());

        $id = $request->id;
        $manager = $request->manager;

        $data = DB::table('device')->where('id' , $id)->first();

        if($manager == 1){
              return view('managerend.edit_device' , compact('data'));
        }

        return view('backend.device.edit' , compact('data'));

    }

}
