<?php

namespace App\Http\Controllers\managerend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\marketend\Meeting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use App\Models\marketend\Account;

class ManagerBillPayController extends Controller
{
    public function Bill_payment_Manager($id)
    {
        $meeting_data = Meeting::find(Crypt::decrypt($id));

        $payment_details = Account::where('user_id', Session::get('user_id'))->where('meeting_id', Crypt::decrypt($id))->get();

        return view('managerend.bill-pay-manager', compact('meeting_data', 'payment_details'));
    }

    public function Add_payment_manager(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'payment_date' => 'required',
            'payment_mode' => 'required|not_in:0'
        ]);

        $addPayment = new Account();

        $meetingId = Crypt::decrypt($request->meeting_id);
        $meet_data = Meeting::find($meetingId);
        $tatal_amount = $meet_data['temp_value'];

        if ($tatal_amount >= $request->amount) {
            $total = $tatal_amount - $request->amount;
            $addPayment->meeting_id = $meet_data['id'];
            $addPayment->user_id = Session::get('user_id');
            $addPayment->user_type = $meet_data['user_type'];
            $addPayment->type = $meet_data['type'];
            $addPayment->client_name = $meet_data['name'];
            $addPayment->amount = $request->amount;
            $addPayment->due_amount = $total;
            $addPayment->payment_date = $request->payment_date;
            $addPayment->payment_mode = $request->payment_mode;
            $addPayment->created_date = date('d-m-Y');
            $addPayment->created_time = time();
            $addPayment->ip_address = $_SERVER['REMOTE_ADDR'];
            $save_payment = $addPayment->save();
            if ($save_payment) {
                $meet_data->temp_value = $total;
                $save = $meet_data->save();
                if ($save) {
                    return back()->with('success', 'Add payment successfully!');
                }
            }
            ////////////////////////////////////////////////////////////////////
        } else {
            return back()->with('faild', 'Your Amount is not sufficient.');
        }
    }
}
