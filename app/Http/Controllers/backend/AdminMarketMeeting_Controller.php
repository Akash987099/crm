<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class AdminMarketMeeting_Controller extends Controller
{
    public function MarketPersonMeeting($marketid)
    {
        $meeeting = DB::table('meetings')
            ->where('user_id', Crypt::decrypt($marketid))
            ->where('user_type', 2)
            ->where('type', 1)
            ->where('archive', 0)
            ->get();
        $user = DB::table('marketing_users')
            ->where('id', Crypt::decrypt($marketid))
            ->where('archived', 0)
            ->where('status', 0)
            ->first();
        return view('backend.market-meetings.view-market-meeting', compact('meeeting', 'user'));
    }

    public function MarketMeetingDelete($meetingid)
    {
        $meeeting = DB::table('meetings')
            ->where('id', Crypt::decrypt($meetingid))
            ->where('user_type', 2)
            ->where('type', 1)
            ->where('archive', 0)
            ->update([
                'archive' => 1
            ]);
        if ($meeeting) {
            return back()->with('success', 'Meeting Archive Successfully!');
        }
    }

    public function MarketMeetingArchive(Request $request)
    {
        $meeeting = DB::table('meetings')
            ->where('user_type', 2)
            ->where('type', 1)
            ->where('archive', 1)
            ->where('user_id', Crypt::decrypt($request->marketid))
            ->get();

        $user = DB::table('marketing_users')
            ->where('id', Crypt::decrypt($request->marketid))
            ->where('archived', 0)
            ->where('status', 0)
            ->first();
        return view('backend.market-meetings.archive-market-meeting', compact('meeeting', 'user'));
    }

    public function MarketMeetingActive($meetingid)
    {

        $meeeting = DB::table('meetings')
            ->where('id', Crypt::decrypt($meetingid))
            ->where('user_type', 2)
            ->where('type', 1)
            ->update([
                'archive' => 0
            ]);
        if ($meeeting) {
            return back()->with('success', 'Meeting Activate Successfully!');
        }
    }

    public function MarketMeeting_View_DATA($meetingid)
    {
        $meeetingData = DB::table('meetings')
            ->where('id', Crypt::decrypt($meetingid))
            ->where('user_type', 2)
            ->where('type', 1)
            ->where('archive', 0)
            ->first();

        $temp_service = DB::table('service_temp')->where('meetingid', Crypt::decrypt($meetingid))->get();

        /**************************payment*************************************************/
        if (DB::table('payment_details')->where('meeting_id', $meeetingData->id)->exists()) {
            $payment = DB::table('payment_details')->where('meeting_id', $meeetingData->id)->get();
        } else {
            $payment = '';
        }
        /**************************end payment*********************************************/
        $client = DB::table('clients')->where('id', $meeetingData->clientid)->where('typeofuser', 2)->where('archive', 0)->first();
        if (isset($client->user_type) && $client->user_type == 0) {
            $given_meeting_user = DB::table('tele_person')->where('id', $client->user_id)->where('archive', 0)->first();
        } else {
            $given_meeting_user = 'Admin';
        }
        $user = DB::table('marketing_users')
            ->where('id', $meeetingData->user_id)
            ->where('archived', 0)
            ->where('status', 0)
            ->first();

        return view('backend.market-meetings.view-data-meeting', compact('meeetingData', 'user', 'given_meeting_user', 'payment', 'temp_service'));
    }

    public function MarketMeeting_Coldcall($marketid)
    {
        $meeeting = DB::table('meetings')
            ->where('user_id', Crypt::decrypt($marketid))
            ->where('user_type', 2)
            ->where('type', 0)
            ->where('archive', 0)
            ->get();
        $user = DB::table('marketing_users')
            ->where('id', Crypt::decrypt($marketid))
            ->where('archived', 0)
            ->where('status', 0)
            ->first();
        return view('backend.market-meetings.view-market-coldcall', compact('meeeting', 'user'));
    }

    public function MarketColdcall_Details($coldcalid)
    {
        $meeetingData = DB::table('meetings')
            ->where('id', Crypt::decrypt($coldcalid))
            ->where('user_type', 2)
            ->where('type', 0)
            ->where('archive', 0)
            ->first();

        $temp_service = DB::table('service_temp')
            ->where('meetingid', Crypt::decrypt($coldcalid))
            ->get();
        /**************************payment*************************************************/
        if (DB::table('payment_details')->where('meeting_id', $meeetingData->id)->exists()) {
            $payment = DB::table('payment_details')->where('meeting_id', $meeetingData->id)->get();
        } else {
            $payment = '';
        }
        /**************************end payment*********************************************/
        $user = DB::table('marketing_users')
            ->where('id', $meeetingData->user_id)
            ->where('archived', 0)
            ->where('status', 0)
            ->first();
        return view('backend.market-meetings.view-coldcall-details', compact('meeetingData', 'user', 'payment', 'temp_service'));
    }

    public function MarketColdcall_Delete($coldcalid)
    {
        DB::table('meetings')
            ->where('id', Crypt::decrypt($coldcalid))
            ->where('user_type', 2)
            ->where('type', 0)
            ->update([
                'archive' => 1
            ]);
        return back()->with('success', 'Cold call delete successfully!');
    }

    public function MarketColdcall_Archive(Request $request)
    {

        $meeeting = DB::table('meetings')
            ->where('user_type', 2)
            ->where('type', 0)
            ->where('archive', 1)
            ->where('user_id', Crypt::decrypt($request->marketid))
            ->get();

        $user = DB::table('marketing_users')
            ->where('id', Crypt::decrypt($request->marketid))
            ->where('archived', 0)
            ->where('status', 0)
            ->first();


        return view('backend.market-meetings.archive-market-coldcall', compact('user', 'meeeting'));
    }

    public function MarketColdcall_Active($coldid)
    {
        DB::table('meetings')
            ->where('id', Crypt::decrypt($coldid))
            ->where('user_type', 2)
            ->where('type', 0)
            ->update([
                'archive' => 0
            ]);
        return back()->with('success', 'Cold call Active successfully!');
    }
}
