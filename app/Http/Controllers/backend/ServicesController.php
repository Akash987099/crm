<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\backend\Services;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ServicesController extends Controller
{
    public function Service(Request $request)
    {

        if ($request->ajax()) {
            $data = DB::table('services')
                ->where('company_id', Session::get('company_id'))
                ->where('archive', 0)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1 service_id" data-id=' . Crypt::encrypt($row->id) . '><i class="bi bi-eye"></i></a>';
                    $btn .= '<a class="btn btn-primary btn-sm m-1" href="' . url('admin/edit-service', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                    $btn .= '<a class="btn btn-danger btn-sm m-1" href="' . url('admin/service-delete', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.services.service');
    }
    public function Add_service()
    {
        return view('backend.services.add-service');
    }
    public function Create_service(Request $request)
    {
        $request->validate([
            'service_name' => 'required|unique:services,service_name',
            'service_price' => 'required',
            'company' => 'required',
            'status' => 'required'
        ]);

        $service = new Services();
        $service->company_id = Session::get('company_id');
        $service->service_name = $request->service_name;
        $service->service_price = $request->service_price;
        $service->company = $request->company;
        $service->status = $request->status;
        $service->description = $request->description;
        $service->created_date = date('d-m-Y');
        $service->created_time = time();
        $service->ip_address = $_SERVER['REMOTE_ADDR'];
        $save = $service->save();
        if ($save) {
            return back()->with('success', 'Service create successfully!');
        }
    }

    public function edit_service($id)
    {
        $service_id = Crypt::decrypt($id);
        $editservics = Services::find($service_id);
        return view('backend.services.edit-service', compact('editservics'));
    }
    public function update_service(Request $request)
    {

        $servicess = Services::where('id', '=', $request->id)->first();
        if ($request->service_name != $servicess['service_name']) {
            $request->validate([
                'service_name' => 'required|unique:services,service_name',
                'service_price' => 'required',
                'company' => 'required',
                'status' => 'required'
            ]);
        }

        $update = Services::where('id', $request->id)
            ->update([
                'company_id' => Session::get('company_id'),
                'service_name' => $request->service_name,
                'service_price' => $request->service_price,
                'company' => $request->company,
                'status' => $request->status,
                'description' => $request->description
            ]);

        if ($update) {
            return redirect('admin/services')->with('success', 'Service update successfully!');
        }
    }

    public function service_delete($id)
    {

        $sid = Crypt::decrypt($id);
        $delete = Services::find($sid);
        $delete->archive = 1;
        $delete->save();
        return redirect('admin/services')->with('success', 'Service delete successfully!');
    }

    public function archive_serviceList(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('services')
                ->where('company_id', Session::get('company_id'))
                ->where('archive', 1)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a data-toggle="tooltip" data-placement="top" title="Active Service" class="btn btn-info" href="' . url('admin/active-archive-services', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-arrow-clockwise"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.services.archive-service');
    }

    public function ServiceActive($id)
    {
        $aid = Crypt::decrypt($id);
        $active_service = Services::find($aid);
        $active_service->archive = 0;
        $active_service->save();
        return redirect('admin/services')->with('success', 'Service Activated successfully!');
    }

    public function Service_modal_details(Request $request)
    {
        $service_id = Crypt::decrypt($request->id);
        $data = Services::find($service_id);
        return response()->json(array('data' => $data));
    }
}
