<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Meetings_ReportController extends Controller
{
    public function Show_meetingPage(Request $request)
    {
        return view('backend.meeting.report-meeting');
    }

    public function Check_Meeting_Data(Request $request)
    {
        $usertype = $request->id;
        if ($usertype == 2) {
            $team_person = DB::table('marketing_users')
                ->select('id', 'firstname')
                ->where('archived', 0)
                ->get();
            return response()->json(array('status' => 100, 'team_person' => $team_person));
        } elseif ($usertype == 3) {
            $team_person = DB::table('managers')
                ->select('id', 'name')
                ->where('archive', 0)
                ->get();
            return response()->json(array('status' => 200, 'team_person' => $team_person));
        } elseif ($usertype == 4) {
            $team_person = DB::table('bdes')
                ->select('id', 'bde_name')
                ->where('archive', 0)
                ->get();
            return response()->json(array('status' => 300, 'team_person' => $team_person));
        }
    }


    public function Filter_Meeting_Data(Request $request)
    {
        $userType = $request->user_type;

        $startDate = strtotime($request->start_date);
        $endDate = strtotime($request->end_date . ' +1 day');
        $today = date('d-m-Y');

        if ($startDate > $endDate) {
            return redirect('admin/check-meeting')->with('faild', 'Start date should be less than end date');
        } elseif ($endDate > strtotime(' +1 day', strtotime($today))) {
            return redirect('admin/check-meeting')->with('faild', 'End date must be less than or equal to today date');
        } elseif ($startDate > strtotime(' +1 day', strtotime($today))) {
            return redirect('admin/check-meeting')->with('faild', 'Start date must be less than or equal to today date');
        } else {
            if (isset($request->name) && $userType == 2) {
                $all_meeting = DB::table('marketing_users')
                    ->leftJoin('meetings', 'marketing_users.id', '=', 'meetings.user_id')
                    ->where('marketing_users.id', $request->name)
                    ->where('meetings.user_type', 2)
                    ->where('meetings.type', 1)
                    ->select('marketing_users.firstname', 'meetings.*')
                    ->whereBetween('marketing_users.created_time', [$startDate, $endDate])
                    ->get();
            } elseif (isset($request->name) && $userType == 3) {
                $all_meeting = DB::table('managers')
                    ->where('managers.company_id', Session::get('company_id'))
                    ->where('managers.id', $request->name)
                    ->where('meetings.user_type', 3)
                    ->where('meetings.type', 1)
                    ->leftJoin('meetings', 'managers.id', '=', 'meetings.user_id')
                    ->select('managers.staff_id', 'meetings.*')
                    ->whereBetween('managers.created_time', [$startDate, $endDate])
                    ->get();
            } elseif (isset($request->name) && $userType == 4) {
                $all_meeting = DB::table('bdes')
                    ->where('bdes.company_id', Session::get('company_id'))
                    ->where('bdes.id', $request->name)
                    ->where('meetings.user_type', 4)
                    ->where('meetings.type', 1)
                    ->leftJoin('meetings', 'bdes.id', '=', 'meetings.user_id')
                    ->select('bdes.bde_name', 'meetings.*')
                    ->whereBetween('bdes.created_time', [$startDate, $endDate])
                    ->get();
            } elseif ($userType == 0) {
                $all_meeting = DB::table('meetings')
                    ->where('company_id', Session::get('company_id'))
                    ->where('type', 1)
                    ->whereBetween('created_time', [$startDate, $endDate])
                    ->get();
            }
            return view('backend.meeting.report-meeting', compact('all_meeting'));
        }
    }


    public function REPORT_COLDCALL()
    {
        return view('backend.meeting.report-coldcall');
    }

    public function Filter_Coldcall_Data(Request $request)
    {
        $usertype = $request->id;
        if ($usertype != "" && $usertype == 2) {
            $team_person = DB::table('marketing_users')
                ->where('company_id', Session::get('company_id'))
                ->select('id', 'firstname')
                ->where('archived', 0)
                ->get();
            return response()->json(array('status' => 100, 'team_person' => $team_person));
        } elseif ($usertype != "" && $usertype == 3) {
            $team_person = DB::table('managers')
                ->where('company_id', Session::get('company_id'))
                ->select('id', 'name')
                ->where('archive', 0)
                ->get();
            return response()->json(array('status' => 200, 'team_person' => $team_person));
        } elseif ($usertype != "" && $usertype == 4) {
            $team_person = DB::table('bdes')
                ->where('company_id', Session::get('company_id'))
                ->select('id', 'bde_name')
                ->where('archive', 0)
                ->get();
            return response()->json(array('status' => 300, 'team_person' => $team_person));
        }
    }

    public function REPORT_COLDCALL_GENERATE(Request $request)
    {

        $userType = $request->user_type;

        $name = $request->name;
        $startDate = strtotime($request->start_date);
        $endDate = strtotime($request->end_date . ' +1 day');
        $today = date('d-m-Y');

        if ($startDate > $endDate) {
            return redirect('admin/check-meeting')->with('faild', 'Start date should be less than end date');
        } elseif ($endDate > strtotime(' +1 day', strtotime($today))) {
            return redirect('admin/check-meeting')->with('faild', 'End date must be less than or equal to today date');
        } elseif ($startDate > strtotime(' +1 day', strtotime($today))) {
            return redirect('admin/check-meeting')->with('faild', 'Start date must be less than or equal to today date');
        } else {
            if ($userType == 2) {
                $all_meeting = DB::table('marketing_users')
                    ->where('marketing_users.company_id', Session::get('company_id'))
                    ->where('marketing_users.id', $name)
                    ->leftJoin('meetings', 'marketing_users.id', '=', 'meetings.user_id')
                    ->where('meetings.user_type', 2)
                    ->where('meetings.type', 0)
                    ->select('marketing_users.firstname', 'meetings.*')
                    ->whereBetween('marketing_users.created_time', [$startDate, $endDate])
                    ->get();
                return view('backend.meeting.report-coldcall', compact('all_meeting'));
            } elseif ($userType == 3) {
                $all_meeting = DB::table('managers')
                    ->where('managers.company_id', Session::get('company_id'))
                    ->where('managers.id', $name)
                    ->leftJoin('meetings', 'managers.id', '=', 'meetings.user_id')
                    ->where('meetings.user_type', 3)
                    ->where('meetings.type', 0)
                    ->select('managers.staff_id', 'meetings.*')
                    ->whereBetween('managers.created_time', [$startDate, $endDate])
                    ->get();
                return view('backend.meeting.report-coldcall', compact('all_meeting'));
            } elseif ($userType == 4) {
                $all_meeting = DB::table('bdes')
                    ->where('bdes.company_id', Session::get('company_id'))
                    ->where('bdes.id', $name)
                    ->leftJoin('meetings', 'bdes.id', '=', 'meetings.user_id')
                    ->where('meetings.user_type', 4)
                    ->where('meetings.type', 0)
                    ->select('bdes.bde_name', 'meetings.*')
                    ->whereBetween('bdes.created_time', [$startDate, $endDate])
                    ->get();

                return view('backend.meeting.report-coldcall', compact('all_meeting'));
            } elseif ($userType == 0) {
                $all_meeting = DB::table('meetings')
                    ->where('company_id', Session::get('company_id'))
                    ->where('type', 0)
                    ->whereBetween('created_time', [$startDate, $endDate])
                    ->get();

                return view('backend.meeting.report-coldcall', compact('all_meeting'));
            }
        }
    }
}
