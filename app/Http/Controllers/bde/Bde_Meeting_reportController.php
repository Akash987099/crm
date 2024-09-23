<?php

namespace App\Http\Controllers\bde;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Bde_Meeting_reportController extends Controller
{
    public function MEETING_BDE_REPORT()
    {
        return view('bdend.report-meeting-bde');
    }

    public function MEETING_BDE_REPORT_GENERATE(Request $request)
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
                ->where('type', 1)
                ->where('user_type', 4)
                ->get();

            return view('bdend.report-meeting-bde', compact('filter_meeting'));
        }
    }
    public function COLDCALL_BDE_REPORT()
    {
        return view('bdend.report-coldcall-bde');
    }
    public function COLDCALL_BDE_REPORT_GENERATE(Request $request)
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
                ->where('user_type', 4)
                ->get();

            return view('bdend.report-coldcall-bde', compact('filter_meeting'));
        }
    }

    public function TOTAL_BDE_REPORT()
    {
        return view('bdend.total-meeting-bde-report');
    }

    public function TOTAL_BDE_REPORT_GENERATE(Request $request)
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
                ->where('user_type', 4)
                ->get();

            return view('bdend.total-meeting-bde-report', compact('filter_meeting'));
        }
    }
}
