<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\marketend\Meeting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\backend\Services;
use Yajra\DataTables\DataTables;

class CustomersController extends Controller
{
    public function Customers(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('meetings')
                ->where('archive', 0)
                ->where('status', 1)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-danger btn-sm m-1" title="Delete" href="' . route('backend.delete-customers', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.customers.view-customers');
    }

    public function Add_Customer()
    {
        return view('backend.customers.add-customer');
    }


    public function delete_customers($id)
    {
        $cid = Crypt::decrypt($id);
        $archive_customer = Meeting::find($cid);
        $archive_customer->archive = 1;
        $archive = $archive_customer->save();
        if ($archive) {
            return back()->with('success', 'Customer Delete Successfully!');
        }
    }

    public function Archive_customers(Request $request)
    {

        if ($request->ajax()) {
            $data = DB::table('meetings')
                ->where('archive', 1)
                ->where('status', 1)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1 text-white" href="' . route('backend.active-customers', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-arrow-clockwise"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.customers.archive-customers');
    }

    public function Active_Customer($id)
    {
        $cid = Crypt::decrypt($id);
        $active_customer = Meeting::find($cid);
        $active_customer->archive = 0;
        $active = $active_customer->save();
        if ($active) {
            return redirect('admin/view-customers')->with('success', 'Active Customer Successfully!');
        }
    }

    public function Customers_details_modal(Request $request)
    {
        $arr = [];
        $service = [];
        $meeting_id = Crypt::decrypt($request->id);
        $data = Meeting::where('id', $meeting_id)->first();
        $decode = json_decode($data->company_service);

        $userType = $data->user_type;
        if ($userType == 2) {
            $team_person = DB::table('marketing_users')
                ->where('id', $data->user_id)
                ->where('archived', 0)
                ->value('firstname');
        } elseif ($userType == 3) {
            $team_person = DB::table('managers')
                ->where('id', $data->user_id)
                ->where('archive', 0)
                ->value('name');
        } elseif ($userType == 4) {
            $team_person = DB::table('bdes')
                ->where('id', $data->user_id)
                ->where('archive', 0)
                ->value('bde_name');
        } else {
            $team_person = 'Admin';
        }

        array_push($arr, $decode);
        foreach ($arr as $row) {
            $comp_service = Services::find($row);
            foreach ($comp_service as $row2) {
                array_push($service, $row2->service_name);
            }
        }

        return response()->json(array('data' => $data, 'service' => $service, 'team_person' => $team_person));
    }
}
