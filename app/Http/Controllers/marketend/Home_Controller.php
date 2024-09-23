<?php

namespace App\Http\Controllers\marketend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Models\frontend\Client;
use App\Models\backend\Services;

class Home_Controller extends Controller
{
    public function HOME()
    {
        $total_sale = DB::table('meetings')
            ->where('status', '=', 1)
            ->where('user_id', '=', Session::get('user_id'))
            ->sum('blance');

        $devit = DB::table('payment_details')
            ->where('user_id', '=', Session::get('user_id'))
            ->sum('amount');

        $now = date('d-m-Y');
        $amount = DB::table('payment_details')
            ->where('user_id', '=', Session::get('user_id'))
            ->where('created_date', '=', $now)
            ->sum('amount');

        $total_meetings = DB::table('meetings')
            ->where('user_id', '=', Session::get('user_id'))
            ->where('type', 1)
            ->where('user_type', 2)
            ->count();
        $total_coldcall = DB::table('meetings')
            ->where('user_id', '=', Session::get('user_id'))
            ->where('type', 0)
            ->where('user_type', 2)
            ->count();
        $recent_meeting = DB::table('meetings')
            ->where('user_id', Session::get('user_id'))
            ->where('user_type', 2)
            ->where('type', 1)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        return view('marketend.home', compact('amount', 'devit', 'total_sale', 'total_meetings', 'total_coldcall', 'recent_meeting'));
    }



    public function Recent_Meeting_marketing(Request $request)
    {

        $arr = [];
        $service = [];
        if (isset($request->dataId) && $request->dataId != "") {
            $meeting_id = Crypt::decrypt($request->dataId);

            $data = DB::table('meetings')
                ->where('id', $meeting_id)
                ->first();

            $decode = json_decode($data->service);
            array_push($arr, $decode);
            foreach ($arr as $row) {
                $comp_service = Services::find($row);
                foreach ($comp_service as $row2) {
                    array_push($service, $row2->service_name);
                }
            }

            return response()->json(array('data' => $data, 'service' => $service));
        }
    }
}
