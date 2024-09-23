<?php

namespace App\Http\Controllers\marketend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Market_Meeting_ReportController extends Controller
{
    public function Check_Meeting_availability()
    {
        return view('marketend.check-meeting-details');
    }
    public function Check_Meeting(Request $request)
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
                ->where('user_type', 2)
                ->get();
            return view('marketend.check-meeting-details', compact('filter_meeting'));
        }
    }

    public function MARKETING_COLDCALL_REPORT()
    {
        return view('marketend.coldcall-mreport');
    }
    public function MARKETING_COLDCALL_REPORT_GENERATE(Request $request)
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
                ->where('user_type', 2)
                ->get();
            return view('marketend.coldcall-mreport', compact('filter_meeting'));
        }
    }

    function MARKETING_TOTAL_REPORT()
    {
        return view('marketend.total-mreport');
    }
    function MARKETING_TOTAL_REPORT_GENERATE(Request $request)
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
                ->where('user_type', 2)
                ->get();
            return view('marketend.total-mreport', compact('filter_meeting'));
        }
    }
}
