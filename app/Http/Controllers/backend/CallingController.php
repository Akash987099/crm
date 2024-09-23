<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use App\Models\frontend\TeleCalling;
use Illuminate\Support\Facades\Session;

class CallingController extends Controller
{
    public function Calling_list()
    {
        $data = DB::table('calling')->where('archive', 0)->get();

        return view('backend.calling.calling-list', compact('data'));
    }

    public function Archive_callingList(Request $request)
    {
        $data = DB::table('calling')->where('archive', 1)->get();

        return view('backend.calling.archive-colling-list', compact('data'));
    }

    public function Active_callingList(Request $request)
    {
        DB::table('calling')
            ->where('id', Crypt::decrypt($request->callid))
            ->update([
                'archive' => 0
            ]);
        return back()->with('success', 'Call Active Successfully!');
    }


    public function Add_call()
    {
        return view('backend.calling.add-call');
    }

    public function Add_Call_submit(Request $request)
    {
        $request->validate([
            'mobile' => 'required|unique:calling,mobile|numeric|digits:10',
            'remark' => 'required'
        ]);
        $add_call = new TeleCalling();
        $add_call->mobile = $request->mobile;
        $add_call->client_name = $request->client_name;
        $add_call->remark = $request->remark;
        $add_call->company_id = Session::get('company_id');
        $add_call->user_type = 1;
        $add_call->created_date = date('d-m-Y');
        $add_call->created_time = time();
        $add_call->ip_address = $_SERVER['REMOTE_ADDR'];
        $add_call->save();
        return back()->with('success', 'Number Add Successfully!');
    }





    public function Edit_calling($id)
    {
        $edit_call = TeleCalling::find(Crypt::decrypt($id));
        return view('backend.calling.edit-calling', compact('edit_call'));
    }

    public function Update_calling(Request $request)
    {
        $caleid = Crypt::decrypt($request->caleid);
        $update_call = TeleCalling::find($caleid);
        if ($request->mobile != $update_call->mobile) {
            $request->validate([
                'mobile' => 'required|numeric|unique:calling,mobile|digits:10'
            ]);
        }
        $update_call->mobile = $request->mobile;
        $update_call->client_name = $request->client_name;
        $update_call->remark = $request->remark;
        $update = $update_call->save();
        if ($update) {
            return redirect('admin/calling-list')->with('success', 'Call update successfully!');
        }
    }

    public function Delete_calling($id)
    {
        DB::table('calling')
            ->where('id', Crypt::decrypt($id))
            ->update([
                'archive' => 1
            ]);

        return back()->with('success', 'Call delete successfully!');
    }


    public function Check_availability()
    {

        return view('backend.calling.check-call-availablity');
    }


    public function Filter_call_data(Request $request)
    {

        $request->validate([
            'team_person_name' => 'required|not_in:0',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $name = $request->team_person_name;
        $startDate = strtotime($request->start_date);
        $endDate = strtotime($request->end_date . ' +1 day');
        $today = date('d-m-Y');

        $filter_transactions = TeleCalling::where('team_person_name', $name)
            ->whereBetween('created_time', [$startDate, $endDate])
            ->get();

        return view('backend.calling.check-call-availablity', compact('filter_transactions'));
    }
}
