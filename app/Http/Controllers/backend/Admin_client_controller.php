<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use App\Models\frontend\Client;
use App\Models\frontend\Client_services;
use App\Models\backend\Services;
use App\Models\employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class Admin_client_controller extends Controller
{
    public function view_client()
    {
        return view('backend.clients.view-client');
    }

    public function leadclient(Request $request){

        $employeedata = employee::all();
        return view('backend.add-lead' , compact('employeedata'));

    }

    public function lead_client_submit(Request $request){
                //  dd($request->all());
        $request->validate([
            'client_name' => 'required',
            'company_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            // 'meating_time' => 'required',
            // 'meating_date' => 'required',
            // 'assign_meating' => 'required'
        ]);

        $insertGetId = DB::table('clients')->insertGetId([
            'user_id' => Session::get('user_id'),
            'client_name' => $request->client_name,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'meating_time' => $request->meating_time,
            'meating_date' => $request->meating_date,
            'assign_meating' => $request->assign_meating,
            'client_potential' => $request->client_potential,
            'typeofuser' => $request->typeofuser,
            'remark' => $request->remark,
            'created_date' => date('d-m-Y'),
            'created_time' => time(),
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ]);
        if ($insertGetId) {
            return back()->with('success', 'Client save successfully!');
        }

    }

    public function backend_lead(Request $request){
        return view('backend.lead');
    }

    public function manager_leads(Request $request){
        return view('managerend.lead');
        // return view('backend.lead');
    }

    public function manager_add_lead(){

        $employeedata = employee::all();
        $product = DB::table('product')->get();

        return view('managerend.add-lead' , compact('employeedata' , 'product'));
    }

    public function add_manager_lead(Request $request){

        $request->validate([
            'client_name' => 'required',
            'company_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            // 'meating_time' => 'required',
            // 'meating_date' => 'required',
            // 'assign_meating' => 'required'
        ]);

        $insertGetId = DB::table('clients')->insertGetId([
            'user_id' => Auth::guard('manager')->user()->id,
            'client_name' => $request->client_name,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'meating_time' => $request->meating_time,
            'meating_date' => $request->meating_date,
            // 'assign_meating' => $request->assign_meating,
            'product' => $request->product,
            'client_potential' => $request->client_potential,
            'typeofuser' => $request->typeofuser,
            'remark' => $request->remark,
            'created_date' => date('d-m-Y'),
            'created_time' => time(),
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ]);
        if ($insertGetId) {
            return back()->with('success', 'Client save successfully!');
        }

    }

    public function viewlistlead(Request $request){

        // dd($request->all());/s

        if ($request->ajax()) {
            $data = DB::table('clients')
                ->leftJoin('employee', 'clients.assign_meating', '=', 'employee.id');
        
            if (Auth::guard('manager')->check() && Auth::guard('manager')->user()->user_type == 2) {
                $empid = employee::where('user_id', Auth::guard('manager')->user()->id)->pluck('id');
                $data->whereIn('user_id', $empid);
            }
        
            $data->select(
                    'clients.*',
                    DB::raw("CONCAT(employee.firstname, ' ', employee.lastname) as employee_name")
                );
        
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1 lead_id" data-id="' . Crypt::encrypt($row->id) . '"> <i class="bi bi-eye"></i></a>';
                    $btn .= '<a class="btn btn-primary btn-sm m-1" href="' . route('lead.update-submit', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                    $btn .= '<a class="btn btn-danger btn-sm m-1" href="' . url('clients-delete', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->order(function ($query) {
                    $query->orderBy('clients.id', 'desc');  // Ensure the orderBy is applied correctly
                })
                ->make(true);
        }
        
        

    }

    public function Show_client(Request $request)
    {
        // dd($request->all());

        if ($request->ajax()) {

            $data = DB::table('clients')
                ->where('archive', 0)
                ->where('company_id', Session::get('company_id'))
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1 client_id" data-id=' . Crypt::encrypt($row->id) . '><i class="bi bi-eye"></i></a>';
                    $btn .= '<a class="btn btn-primary btn-sm m-1" href="' . route('backend.edit-client', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                    $btn .= '<a class="btn btn-danger btn-sm m-1" href="' . route('backend.client-delete', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create_client()
    {
        $employeedata = employee::all();

        return view('backend.clients.client-add' , compact('employeedata'));
    }
    public function Post_client(Request $request)
    {
       

        $rules = [

           'client_name' => 'required',
            'company_name' => 'required',
            'email' => 'required',
            // 'phone' => 'required|digits:10',
            // 'meating_time' => 'required',
            // 'meating_date' => 'required',
            'client_potential' => 'required',
         ];
         
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
    
        $path = '';
    
        if ($request->has('image')) {
            $imageData = $request->input('image'); 
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            $imageName = 'camera_capture_' . time() . '.png';
    
            $decodedImage = base64_decode($imageData);
            $path = 'images/' . $imageName;
    
            Storage::disk('public')->put($path, $decodedImage);
        }
    
        $insertGetId = DB::table('clients')->insertGetId([
            'company_id' => Session::get('company_id'),
            'user_id'  => Auth::guard('employee')->user()->id,
            'client_name' => $request->client_name,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'meating_time' => $request->meating_time,
            'meating_date' => $request->meating_date,
            'assign_meating' => $request->assign_meating,
            'client_potential' => $request->client_potential,
            'typeofuser' => $request->typeofuser,
            'remark' => $request->remark,
            'image'  => $path,
            'created_date' => date('d-m-Y'),
            'created_time' => time(),
            'ip_address' => $request->ip()
        ]);
    
        if ($insertGetId) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error']);
    }

    public function lead_client_update(Request $request){

        $id = $request->id;
        $ceid = Crypt::decrypt($id);
        $edit_client = Client::find($ceid);

        $service = DB::table('services')
            ->where('archive', 0)
            ->where('status', 0)
            ->select('id', 'service_name', 'service_price')
            ->get();

        $client_service = DB::table('clients_services')->where('client_tbl_id', $ceid)->get('client_services');

        $marketing_users = DB::table('marketing_users')->get();

        $employeedata = employee::all();

        return view('backend.update-lead', compact('edit_client', 'client_service', 'service', 'marketing_users' , 'employeedata'));
    }

    public function   lead_update_ajax(Request $request){

        $update_client = Client::find(Crypt::decrypt($request->clieid));

        $request->validate([
            'client_name' => 'required',
            'company_name' => 'required',
            'phone' => 'required|numeric|min:10',
            'address' => 'required',
            // 'meating_time' => 'required',
            // 'meating_date' => 'required',
            // 'client_potential' => 'required|not_in:0'
        ]);

        if ($request->email != $update_client->email) {
            $request->validate([
                'email' => 'email|unique:clients,email'
            ]);
        }
        $update_client->client_name = $request->client_name;
        $update_client->company_name = $request->company_name;
        $update_client->email = $request->email;
        $update_client->phone = $request->phone;
        $update_client->address = $request->address;
        $update_client->meating_time = $request->meating_time;
        $update_client->meating_date = $request->meating_date;
        $update_client->assign_meating = $request->assign_meating;
        $update_client->client_potential = $request->client_potential;
        $update_client->typeofuser = $request->typeofuser;
        $update_client->remark = $request->remark;
        $update_client = $update_client->save();

        if ($update_client) {
            return back()->with('success', 'Client update successfully!');
        }

    }

    public function Client_edit($id)
    {
        $clieid = Crypt::decrypt($id);
        $edit_client = Client::find($clieid);
        $client_service = DB::table('clients_services')->where('client_tbl_id', $clieid)->get('client_services');
        return view('backend.clients.client-edit', compact('edit_client', 'client_service'));
    }
    public function Client_Update(Request $request)
    {
        $update_client = Client::find(Crypt::decrypt($request->clieid));

        $request->validate([
            'client_name' => 'required',
            'company_name' => 'required',
            'phone' => 'required|numeric|min:10',
            'address' => 'required',
            'meating_time' => 'required',
            'meating_date' => 'required',
            'client_potential' => 'required|not_in:0'
        ]);

        if ($request->email != $update_client->email) {
            $request->validate([
                'email' => 'email|unique:clients,email'
            ]);
        }
        $update_client->client_name = $request->client_name;
        $update_client->company_name = $request->company_name;
        $update_client->email = $request->email;
        $update_client->phone = $request->phone;
        $update_client->address = $request->address;
        $update_client->meating_time = $request->meating_time;
        $update_client->meating_date = $request->meating_date;
        $update_client->assign_meating = $request->assign_meating;
        $update_client->client_potential = $request->client_potential;
        $update_client->typeofuser = $request->typeofuser;
        $update_client->remark = $request->remark;
        $update_client = $update_client->save();

        if ($update_client) {
            return redirect(route('backend.view-client'))->with('success', 'Client update successfully!');
        }
    }

    public function Client_Admin_Delete($id)
    {
        $delete_id = Crypt::decrypt($id);
        $delete_client = Client::find($delete_id);
        $delete_client->archive = 1;
        $delete_client->save();
        return back()->with('success', 'Client delete successfully!');
    }

    public function Views_client_Modal(Request $request)
    {
        $data = Client::where('id', Crypt::decrypt($request->id))->first();

        /*********************meeting assign user****************************************** */
        if (isset($data->typeofuser) && $data->typeofuser == 1) {
            $manager = DB::table('managers')->where('archive', 0)->where('id', $data->assign_meating)->first();
        } elseif (isset($data->typeofuser) && $data->typeofuser == 2) {
            $manager = DB::table('marketing_users')->where('archived', 0)->where('id', $data->assign_meating)->first();
        } elseif (isset($data->typeofuser) && $data->typeofuser == 3) {
            $manager = DB::table('bdes')->where('archive', 0)->where('id', $data->assign_meating)->first();
        } else {
            $manager = 'Admin';
        }
        /*********************end meeting assign user************************************** */

        /*********************team person*********************************** */
        if (isset($data->user_id)) {

            $lead_generate = DB::table('tele_person')
                ->where('id', $data->user_id)
                ->where('archive', 0)
                ->where('status', 0)
                ->first();
        } else {
            $lead_generate = "Admin";
        }

        /*********************end team person*********************************** */
        return response()->json(array('data' => $data, 'lead_generate' => $lead_generate, 'manager' => $manager));
    }


    public function View_Archive_Client(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('clients')
                ->where('archive', 1)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a data-toggle="tooltip" data-placement="top" title="Active Client" class="btn btn-info" href="' . route('backend.active-client', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-arrow-clockwise"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.clients.view-archive-client');
    }

    public function Active_archive_client($id)
    {
        $clientId = Crypt::decrypt($id);
        $active_client = Client::find($clientId);
        $active_client->archive = 0;
        $clientActive = $active_client->save();
        if ($clientActive) {
            return back()->with('success', 'Client Activated Successfully!');
        }
    }


    public function Type_Of_UserData(Request $request)
    {
        $userid = $request->id;

        if ($userid == 1) {
            $manager = DB::table('managers')
                ->where('archive', 0)
                ->select('id', 'name')
                ->get();
            return response()->json(array('status' => 100, 'data' => $manager));
        } elseif ($userid == 2) {
            $marketing = DB::table('marketing_users')
                ->where('archived', 0)
                ->select('id', 'firstname', 'lastname')
                ->get();
            return response()->json(array('status' => 200, 'data' => $marketing));
        } elseif ($userid == 3) {
            $bde = DB::table('bdes')
                ->where('archive', 0)
                ->select('id', 'bde_name')
                ->get();
            return response()->json(array('status' => 300, 'data' => $bde));
        }
    }
}
