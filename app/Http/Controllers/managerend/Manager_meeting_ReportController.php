<?php

namespace App\Http\Controllers\managerend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class Manager_meeting_ReportController extends Controller
{
    public function MANAGER_MEETING_REPORT()
    {
        return view('managerend.report-meeting-manager');
    }
    function MANAGER_MEETING_REPORT_GENERATE(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $startDate = strtotime($request->start_date);
        $endDate = strtotime($request->end_date . ' +1 day');
        $today = date('d-m-Y');
        if ($startDate > $endDate) {
            return back()->with('faild', 'Start date should not be greater than end date');
        } elseif ($endDate > strtotime(' +1 day', strtotime($today))) {
            return back()->with('faild', 'End date must be less than or equal to today date');
        } else {

            $filter_meeting = DB::table('meetings')->whereBetween('created_time', [$startDate, $endDate])
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 0)
                ->where('type', 1)
                ->where('user_type', 3)
                ->get();

            return view('managerend.report-meeting-manager', compact('filter_meeting'));
        }
    }

    function MANAGER_COLDCALL_REPORT()
    {
        return view('managerend.report-coldcal-manager');
    }

    function MANAGER_COLDCALL_REPORT_GENERATE(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $startDate = strtotime($request->start_date);
        $endDate = strtotime($request->end_date . ' +1 day');
        $today = date('d-m-Y');
        if ($startDate > $endDate) {
            return back()->with('faild', 'Start date should not be greater than end date');
        } elseif ($endDate > strtotime(' +1 day', strtotime($today))) {
            return back()->with('faild', 'End date must be less than or equal to today date');
        } else {

            $filter_meeting = DB::table('meetings')->whereBetween('created_time', [$startDate, $endDate])
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 0)
                ->where('type', 0)
                ->where('user_type', 3)
                ->get();

            return view('managerend.report-coldcal-manager', compact('filter_meeting'));
        }
    }

    function MANAGER_TOTAL_REPORT_MEETINGS()
    {
        return view('managerend.report-total-meetings-manager');
    }

    public function MANAGER_TOTAL_REPORT_GENERATE(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $startDate = strtotime($request->start_date);
        $endDate = strtotime($request->end_date . ' +1 day');
        $today = date('d-m-Y');
        if ($startDate > $endDate) {
            return back()->with('faild', 'Start date should not be greater than end date');
        } elseif ($endDate > strtotime(' +1 day', strtotime($today))) {
            return back()->with('faild', 'End date must be less than or equal to today date');
        } else {

            $filter_meeting = DB::table('meetings')->whereBetween('meetings.created_time', [$startDate, $endDate])
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 0)
                ->where('user_type', 3)
                ->get();

            return view('managerend.report-total-meetings-manager', compact('filter_meeting'));
        }
    }
}
