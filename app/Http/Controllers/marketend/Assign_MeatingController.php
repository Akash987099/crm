<?php

namespace App\Http\Controllers\marketend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use App\Models\frontend\Client;
use App\Models\marketend\Marketing;
use App\Models\backend\Services;

class Assign_MeatingController extends Controller
{
    public function View_assign_meating(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('clients')
                ->where('assign_meating', Session::get('user_id'))
                ->where('typeofuser', 2)
                ->where('archive', 0)->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if ($row->meeting_status != 1) {
                        $btn = '<a class="btn btn-warning text-white blink-soft" title="Meeting Attend" href="' . url('marketing/edit-assign-meating', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-person"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('marketend.view-assign-meating');
    }


    public function Edit_Assign_meating($id)
    {
        $ashign_meating = Client::find(Crypt::decrypt($id));
        if (isset($ashign_meating->user_id)) {
            $user = DB::table('tele_person')->where('id', $ashign_meating->user_id)->where('archive', 0)->where('status', 0)->first();
            $post = '(Telecalling)';
        } else {
            $post = '(Admin)';
        }
        return view('marketend.edit-assign-meating', compact('ashign_meating', 'user', 'post'));
    }

    public function Update_Assign_meating(Request $request)
    {
        $ashin_id = Crypt::decrypt($request->ashin_id);
        $update_ashign = Client::find($ashin_id);
        if (isset($request->email) && $request->email != $update_ashign->email) {
            $request->validate([
                'client_name' => 'required',
                'company_name' => 'required',
                'email' => 'email|unique:clients,email',
                'phone' => 'required',
                'service' => 'required',
                'tenure' => 'required',
                'meating_time' => 'required',
                'meating_date' => 'required'
            ]);
        }

        $update_ashign->user_id = Session::get('user_id');
        $update_ashign->company_id = Session::get('company_id');
        $update_ashign->client_name = $request->client_name;
        $update_ashign->company_name = $request->company_name;
        $update_ashign->email = $request->email;
        $update_ashign->phone = $request->phone;
        $update_ashign->service = json_encode($request->service);
        $update_ashign->service_price = $request->service_price;
        $update_ashign->tenure = $request->tenure;
        $update_ashign->address = $request->address;
        $update_ashign->meating_time = $request->meating_time;
        $update_ashign->meating_date = $request->meating_date;
        $update_ashign->client_potential = $request->client_potential;
        $update_ashign->remark = $request->remark;
        $update = $update_ashign->save();
        if ($update) {
            return redirect('marketing/view-assign-meating')->with('success', 'Assign meating update successfully!');
        }
    }



    public function Select_servicePrice(Request $request)
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
}
