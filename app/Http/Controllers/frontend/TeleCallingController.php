<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\frontend\TeleCalling;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;

class TeleCallingController extends Controller
{
    public function Client_calling()
    {
        return view('frontend.add-calling');
    }
    public function Add_calling(Request $request)
    {
        $tele_user = DB::table('tele_person')->where('id', Session::get('user_id'))->first();

        $request->validate([
            'mobile' => 'required|unique:calling,mobile|numeric|digits:10',
            'status' => 'required',
            'remark' => 'required'
        ]);

        $add_col = new TeleCalling();
        $add_col->user_id = Session::get('user_id');
        $add_col->company_id = Session::get('company_id');
        $add_col->team_person_name = $tele_user->id;
        $add_col->mobile = $request->mobile;
        $add_col->client_name = $request->client_name;
        $add_col->status = $request->status;
        $add_col->remark = $request->remark;
        $add_col->created_date = date('d-m-Y');
        $add_col->created_time = time();
        $add_col->ip_address = $_SERVER['REMOTE_ADDR'];
        $insert = $add_col->save();
        if ($insert) {
            return back()->with('success', 'Mobile save successfully!');
        }
    }

    public function Call_list()
    {
        return view('frontend.call-list');
    }

    public function view_call_list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('calling')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 0)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-primary m-1 btn-sm" href="' . url('/edit-call', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                    $btn .= '<a href="' . url('/delete-client', ['id' => Crypt::encrypt($row->id)]) . '" class="edit btn btn-danger btn-sm m-1"> <i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }



    public function Edit_call($id)
    {
        $edit_id = Crypt::decrypt($id);
        $edit_call = TeleCalling::find($edit_id);
        return view('frontend.edit-calling', compact('edit_call'));
    }



    public function Update_call(Request $request)
    {
        $edit_id = Crypt::decrypt($request->calid);
        $update = TeleCalling::find($edit_id);

        if (isset($request->mobile) && $request->mobile != $update->mobile) {
            $request->validate([
                'mobile' => 'required|numeric|digits:10|unique:calling,mobile',
                'status' => 'required'
            ]);
        }

        $update->mobile = $request->mobile;
        $update->client_name = $request->client_name;
        $update->status = $request->status;
        $update->remark = $request->remark;
        $cal_update = $update->save();
        if ($cal_update) {
            return redirect('call-list')->with('success', 'Mobile update successfully!');
        }
    }



    public function Client_delete($id)
    {
        $delete_id = Crypt::decrypt($id);
        $delete = TeleCalling::find($delete_id);
        $delete->archive = 1;
        $delete->save();
        return back()->with('success', 'Client delete successfully!');
    }
}
