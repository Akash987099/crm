<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\frontend\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use App\Models\frontend\Client_services;
use App\Models\employee;
use App\Models\backend\Services;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function Client()
    {
        $service = DB::table('services')
            ->where('archive', 0)
            ->where('status', 0)
            ->select('id', 'service_name', 'service_price')
            ->get();
        $marketing_users = DB::table('marketing_users')->get();
        return view('frontend.client-details', compact('marketing_users'));
    }
    public function Add_client(Request $request)
    {
        $request->validate([
            'client_name' => 'required',
            'company_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'meating_time' => 'required',
            'meating_date' => 'required',
            'assign_meating' => 'required'
        ]);

        $insertGetId = DB::table('clients')->insertGetId([
            'user_id' => Auth::guard('employee')->user()->id,
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
    // if ($insertGetId) {
    //     $services_add = $request->service;
    //     if (is_array($services_add) && !empty($services_add)) {
    //         foreach ($services_add as $row) {
    //             $cliend_services = DB::table('clients_services')->insert([
    //                 'user_id' => Session::get('user_id'),
    //                 'client_name' => $request->client_name,
    //                 'client_tbl_id' => $insertGetId,
    //                 'client_services' => $row,
    //                 'created_date' => date('d-m-Y'),
    //                 'created_time' => time(),
    //                 'ip_address' => $_SERVER['REMOTE_ADDR']
    //             ]);
    //         }
    //         if ($cliend_services) {
    //             return back()->with('success', 'Client save successfully!');
    //         }
    //     }
    // }


    public function ViewClientList()
    {

        return view('frontend.view-client');
    }

    public function View_archive_client(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('clients')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 1)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm" href="' . url('active-archive-client', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-arrow-clockwise"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('frontend.view-archive-client');
    }

    public function Edit_TeleClient($id)
    {
        $ceid = Crypt::decrypt($id);
        $edit_client = Client::find($ceid);

        $service = DB::table('services')
            ->where('archive', 0)
            ->where('status', 0)
            ->select('id', 'service_name', 'service_price')
            ->get();

        $client_service = DB::table('clients_services')->where('client_tbl_id', $ceid)->get('client_services');

        $marketing_users = DB::table('marketing_users')->get();

        return view('frontend.edit-teleclient', compact('edit_client', 'client_service', 'service', 'marketing_users'));
    }

    public function Update_TeleClient(Request $request)
    {
        $ceid = Crypt::decrypt($request->ceid);
        $get_client = Client::find($ceid);
        if (isset($request->email) && $request->email != $get_client->email) {
            $request->validate([
                'client_name' => 'required',
                'company_name' => 'required',
                'email' => 'email|unique:clients,email',
                'phone' => 'required',
                'address' => 'required',
                'meating_time' => 'required',
                'meating_date' => 'required',
                'assign_meating' => 'required',
                'client_potential' => 'required'
            ]);
        }

        $get_client->user_id = Session::get('user_id');
        $get_client->client_name = $request->client_name;
        $get_client->company_name = $request->company_name;
        $get_client->email = $request->email;
        $get_client->phone = $request->phone;
        $get_client->address = $request->address;
        $get_client->meating_time = $request->meating_time;
        $get_client->meating_date = $request->meating_date;
        $get_client->assign_meating = $request->assign_meating;
        $get_client->client_potential = $request->client_potential;
        $get_client->typeofuser = $request->typeofuser;
        $get_client->remark = $request->remark;
        $update_client = $get_client->save();

        if ($update_client) {
            return redirect('/view-clients-list')->with('success', 'Lead update successfully!');
            // $services_add = $request->service;
            // DB::table('clients_services')->where('client_tbl_id', $ceid)->delete();
            // if (isset($services_add) && !empty($services_add)) {
            //     foreach ($services_add as $service_id) {
            //         $client_service = new Client_services();
            //         $client_service->client_tbl_id = $ceid;
            //         $client_service->user_id = Session::get('user_id');
            //         $client_service->client_services = $service_id;
            //         $client_service->client_name = $request->client_name;
            //         $client_service->created_date = date('d/m/Y');
            //         $client_service->created_time = time();
            //         $client_service->ip_address = $_SERVER['REMOTE_ADDR'];
            //         $client_service->save();
            //     }

            //     return redirect('/view-clients-list')->with('success', 'Lead update successfully!');
            // }

        }
    }

    public function client_delete_data($id)
    {
        // dd($request->all())
        $clientId = Crypt::decrypt($id);
        $delete_client = Client::find($clientId);
        $delete_client->archive = 1;
        $delete = $delete_client->save();
        if ($delete) {
            return back()->with('success', 'Lead delete successfully!');
        }
    }


    public function View_client(Request $request)
    {

        // dd($request->all());
        if ($request->ajax()) {
            $data = DB::table('clients')
                ->where('user_id', Auth::guard('employee')->user()->id)
                ->where('archive', 0)
                ->orderBy('id' , 'desc')
                // ->where('user_type', 0)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1 lead_id" data-id="' . Crypt::encrypt($row->id) . '"> <i class="bi bi-eye"></i></a>';
                    $btn .= '<a class="btn btn-primary btn-sm m-1" href="' . url('edit-teleclient', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                    $btn .= '<a class="btn btn-danger btn-sm m-1" href="' . url('clients-delete', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function View_clients(Request $request)
    {

        // dd($request->all());

        // dd(Auth::guard('manager')->user()->id);

        if ($request->ajax()) {
            $data = DB::table('clients');
                // ->where('user_id', Auth::guard('employee')->user()->id)

                if(Auth::guard('manager')->check()){

                    $empid = employee::where('user_id' , Auth::guard('manager')->user()->id)->pluck('id');
                   $data->whereIn('user_id' , $empid)->orwhere('user_id' , Auth::guard('manager')->user()->id);
                }

                // $data->where('archive', 0)
                $data->orderBy('id' , 'desc')
                // ->where('user_type', 0)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                // ->addColumn('action', function ($row) {
                //     $btn = '<a class="btn btn-info btn-sm m-1 lead_id" data-id="' . Crypt::encrypt($row->id) . '"> <i class="bi bi-eye"></i></a>';
                //     $btn .= '<a class="btn btn-primary btn-sm m-1" href="' . url('edit-teleclient', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                //     $btn .= '<a class="btn btn-danger btn-sm m-1" href="' . url('clients-delete', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                //     return $btn;
                // })
                // ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function AddClientService(Request $request)
    {

        $client = DB::table('clients')
            ->where('user_id', Session::get('user_id'))
            ->where('archive', 0)
            ->where('id', Crypt::decrypt($request->clientid))
            ->first();

        $temp_service = DB::table('service_temp')->where('user_id', Session::get('user_id'))->where('clientid', Crypt::decrypt($request->clientid))->get();

        return view('frontend.add-client-service', compact('client', 'temp_service'));
    }

    public function AddClientserviceData(Request $request)
    {
        if ($request->serviceid != "" && $request->price != "" && $request->clientid != "") {

            $temp_service = DB::table('service_temp')->insert([
                'user_id' => Session::get('user_id'),
                'clientid' => Crypt::decrypt($request->clientid),
                'serviceid' => $request->serviceid,
                'price' => $request->price,
                'tenure' => $request->tenure,
                'created_date' => date('d-m-Y H:i:s'),
                'created_time' => time(),
                'ip' => $_SERVER['REMOTE_ADDR']
            ]);

            if ($temp_service) {
                $total_price = DB::table('service_temp')->where('user_id', Session::get('user_id'))->where('clientid', Crypt::decrypt($request->clientid))->sum('price');
                DB::table('clients')
                    ->where('user_id', Session::get('user_id'))
                    ->where('archive', 0)
                    ->where('id', Crypt::decrypt($request->meetingid))
                    ->update([
                        'temp_value' => $total_price,
                        'blance' => $total_price
                    ]);
            }
        }
        return response()->json(['status' => 200]);
    }

    public function ClientServiceDiscount(Request $request)
    {
        if (isset($request->clientid) && $request->clientid != "") {
            $total = $request->total;
            $dis = $request->discount;

            $dis_price  = ($total / 100) * $dis;
            $total_amt =  $total - $dis_price;

            DB::table('clients')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 0)
                ->where('id', Crypt::decrypt($request->clientid))
                ->update([
                    'blance' => $total_amt,
                    'discount' => $dis
                ]);
            return back();
        }
    }

    public function ClientServiceDelete(Request $request)
    {

        if (isset($request->serviceid) && isset($request->clientid)) {

            $service_delete = DB::table('service_temp')->where('id', Crypt::decrypt($request->serviceid))->where('clientid', Crypt::decrypt($request->clientid))->delete();

            if ($service_delete) {
                $total_amt = DB::table('service_temp')->where('clientid', Crypt::decrypt($request->clientid))->sum('price');
                $meeting_data = DB::table('clients')->where('id', Crypt::decrypt($request->clientid))->where('archive', 0)->where('user_id', Session::get('user_id'))->first();

                $dis_price  = ($total_amt / 100) * $meeting_data->discount;
                $total =  $total_amt - $dis_price;

                DB::table('clients')
                    ->where('id', Crypt::decrypt($request->clientid))
                    ->where('archive', 0)
                    ->where('user_id', Session::get('user_id'))
                    ->update([
                        'blance' => $total
                    ]);

                if ($total_amt == 0) {
                    DB::table('clients')
                        ->where('id', Crypt::decrypt($request->clientid))
                        ->where('archive', 0)
                        ->where('user_id', Session::get('user_id'))
                        ->update([
                            'temp_value' => 0,
                            'blance' => 0,
                            'discount' => 0
                        ]);
                }
                return response()->json(['status' => 200]);
            }
        }
    }




    public function view_telemarketing_details(Request $request)
    {
        if (isset($request->id)) {
            $client = Client::where('id', Crypt::decrypt($request->id))->first();
            if ($client->typeofuser == 1) {
                $managers = DB::table('managers')->where('id', $client->assign_meating)->where('archive', 0)->where('status', 0)->first();
                $name = $managers->name;
            } elseif ($client->typeofuser == 2) {
                $market = DB::table('marketing_users')->where('id', $client->assign_meating)->where('archived', 0)->where('status', 0)->first();
                $name = $market->firstname;
            } elseif ($client->typeofuser == 3) {
                $bdes = DB::table('bdes')->where('id', $client->assign_meating)->where('archive', 0)->where('status', 0)->first();
                $name = $bdes->bde_name;
            }
            return response()->json(array('data' => $client, 'user' => $name));
        }
    }


    public function Active_archiveClient($id)
    {
        $active_id = Crypt::decrypt($id);
        $active_client = Client::find($active_id);
        $active_client->archive = 0;
        $active = $active_client->save();
        if ($active) {
            return back()->with('success', 'Active Lead Successfully!');
        }
    }

    public function select_service_getprice(Request $request)
    {
        $service_price_id = $request->id;
        if (is_array($service_price_id) && !empty($service_price_id)) {
            $amt = 0;
            foreach ($service_price_id as $id) {

                $price = DB::table('services')->where("id", $id)->value('service_price');
                $amt = $amt + floatval($price);
            }

            return response()->json(array('status' => 200, 'data' => $amt));
        } else {
            return response()->json(array('status' => 400, 'msg' => 'Please select company service'));
        }
    }

    public function TYPEOFUSER(Request $request)
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
