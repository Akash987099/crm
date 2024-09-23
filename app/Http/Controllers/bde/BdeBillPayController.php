<?php

namespace App\Http\Controllers\bde;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\marketend\Meeting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use App\Models\marketend\Account;

class BdeBillPayController extends Controller
{
    public function Bill_payment_Bde($id)
    {
        $meeting_data = Meeting::find(Crypt::decrypt($id));
        $payment_details = Account::where('user_id', Session::get('user_id'))->where('meeting_id', Crypt::decrypt($id))->get();
        return view('bdend.bill-pay-bde', compact('meeting_data', 'payment_details'));
    }

    public function Add_payment_Bde(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'payment_date' => 'required',
            'payment_mode' => 'required|not_in:0'
        ]);

        $meet_data = Meeting::find(Crypt::decrypt($request->meeting_id));
        $tatal_amount = $meet_data['temp_value'];

        $addPayment = new Account();
        if ($tatal_amount >= $request->amount) {
            $total = $tatal_amount - $request->amount;
            $addPayment->meeting_id = $meet_data['id'];
            $addPayment->user_id = Session::get('user_id');
            $addPayment->company_id = Session::get('company_id');
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
