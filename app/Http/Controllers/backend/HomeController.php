<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use App\Models\frontend\Client;
use App\Models\Designation;
use App\Models\employee;
use App\Models\leave;
use Carbon\Carbon;
use App\Models\agent;
use App\Models\frontend\Client_services;
use App\Models\backend\Services;

class HomeController extends Controller
{
    public function Admin_Home()
    {

        $customers = DB::table('meetings')
            // ->where('status', 1)
            // ->where('archive', 0)
            ->count();
        $followup_meeting = DB::table('meetings')
            // ->where('status', 3)
            // ->where('archive', 0)
            ->count();
        $reject_meeting = DB::table('meetings')
            // ->where('status', 3)
            // ->where('archive', 0)
            ->count();
        $lead_generate = DB::table('clients')
            // ->where('archive', 0)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

            $totalagent = agent::count();
            $totalagentsum = agent::sum('payment_re');
            $totalagentdue = agent::sum('payment_due');
            $totalemployee = employee::count();
            $totalClient = Client::count();

            $currentDate = Carbon::now('Asia/Kolkata')->toDateString();

            $todayleave = DB::table('leave_master')
            ->whereDate('created_at', $currentDate)->count();
            $totalleave = DB::table('leave_master')->count();
    

        return view('backend.home', compact('customers', 'totalleave', 'todayleave', 'followup_meeting', 'totalagentdue' , 'totalagentsum', 'reject_meeting', 'totalemployee', 'lead_generate' , 'totalagent', 'totalClient', 'totalClient'));
    }

    public function Recent_Leatd(Request $request)
    {
        if (isset($request->id)) {
            $data = Client::where('id', Crypt::decrypt($request->id))->where('archive', 0)->first();

            /*********************meeting assign user****************************************** */
            if (isset($data->typeofuser) && $data->typeofuser == 1) {
                $manager = DB::table('managers')->where('archive', 0)->where('id', $data->assign_meating)->first();
            } elseif (isset($data->typeofuser) && $data->typeofuser == 2) {
                $manager = DB::table('marketing_users')->where('archived', 0)->where('id', $data->assign_meating)->first();
            } elseif (isset($data->typeofuser) && $data->typeofuser == 3) {
                $manager = DB::table('bdes')->where('archive', 0)->where('id', $data->assign_meating)->where('status', 0)->first();
            }
            /*********************end meeting assign user************************************** */
            /*********************team person*********************************** */

            $team_person = DB::table('tele_person')
                ->where('id', $data->user_id)
                ->where('archive', 0)
                ->first();


            /*********************end team person*********************************** */
            return response()->json(array('data' => $data, 'team_person' => $team_person, 'manager' => $manager));
        }
    }
}
