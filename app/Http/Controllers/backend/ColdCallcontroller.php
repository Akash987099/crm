<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\backend\Services;
use Yajra\DataTables\DataTables;
use App\Models\marketend\Meeting;

class ColdCallcontroller extends Controller
{
    public function ColdCalls(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('meetings')
                ->where('company_id', Session::get('company_id'))
                ->where('user_type', 1)
                ->where('archive', 0)
                ->where('type', 0)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1 text-white coldcall_id" title="View Data" href="' . route('backend.service-coldcall-details', ['meetingid' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-eye"></i></a>';
                    if ($row->status == 1) {
                        $btn .= '<a class="btn btn-warning btn-sm m-1 text-white" title="Payment Details" href="' . route('backend.bill-pay', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-cash"></i></a>';
                    }
                    if (!DB::table('payment_details')->where('meeting_id', $row->id)->exists()) {
                        $btn .= '<a class="btn btn-primary btn-sm m-1" title="Update" href="' . route('backend.edit-coldcall', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                        $btn .= '<a class="btn btn-info btn-sm m-1" title="Add Service" href="' . route('backend.add-service-coldcall', ['meetingid' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-plus-circle-fill"></i></a>';
                    }
                    $btn .= '<a class="btn btn-danger btn-sm m-1" title="Delete" href="' . route('backend.delete-cold-call', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.coldcall.view-cold-call');
    }



    public function Add_ColdCalls(Request $request)
    {
        return view('backend.coldcall.add-cold-calls');
    }
    public function Create_ColdCalls(Request $request)
    {
        $request->validate([
            'client_name' => 'required',
            'phone' => 'required|numeric|digits:10',
        ]);

        $cold_call = new Meeting();

        if (isset($request->status) && $request->status == 1) {

            $request->validate([
                'visiting_card' => 'required|mimes:jpeg,jpg,png',
                'shop_img' => 'required|mimes:jpeg,jpg,png',
                'amount_pic' => 'required|mimes:jpeg,jpg,png'
            ]);

            $path = "assets/uploads/meeting/visitingCard/" . $request->visiting_card;
            $path2 = "assets/uploads/meeting/shopImage/" . $request->shop_img;
            $path3 = "assets/uploads/meeting/shopImage/" . $request->amount_pic;

            if (File::exists($path) && File::exists($path2) && File::exists($path3)) {
                File::delete($path);
                File::delete($path2);
                File::delete($path3);
            }
            $file = $request->file('visiting_card');
            $exten = $file->getClientOriginalExtension();
            $visiting_rename = time() . rand() . "." . $exten;
            $file->move("assets/uploads/meeting/visitingCard/", $visiting_rename);

            $file2 = $request->file('shop_img');
            $exten2 = $file2->getClientOriginalExtension();
            $shopimg = time() . rand() . "." . $exten2;
            $file2->move("assets/uploads/meeting/shopImage/", $shopimg);

            $file3 = $request->file('amount_pic');
            $exten3 = $file3->getClientOriginalExtension();
            $amount_rename = time() . rand() . "." . $exten3;
            $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

            $cold_call->company_id = Session::get('company_id');
            $cold_call->user_type = 1;
            $cold_call->client_name = $request->client_name;
            $cold_call->company_name = $request->company_name;
            $cold_call->phone = $request->phone;
            $cold_call->email = $request->email;
            $cold_call->keywords = $request->keywords;
            $cold_call->visiting_card = $visiting_rename;
            $cold_call->shop_img = $shopimg;
            $cold_call->status = $request->status;
            $cold_call->amount_pic = $amount_rename;
            $cold_call->address = $request->address;
            $cold_call->remark = $request->remark;
            $cold_call->created_date = date('d-m-Y');
            $cold_call->created_time = time();
            $cold_call->ip_address = $_SERVER['REMOTE_ADDR'];
            $saveCall = $cold_call->save();
        } elseif (isset($request->status) && $request->status == 2) {
            if ($request->followup_date == '') {
                return back()->with('faild', 'Please select follow up date!');
            } else {
                $cold_call->company_id = Session::get('company_id');
                $cold_call->user_type = 1;
                $cold_call->client_name = $request->client_name;
                $cold_call->company_name = $request->company_name;
                $cold_call->phone = $request->phone;
                $cold_call->email = $request->email;
                $cold_call->keywords = $request->keywords;
                $cold_call->status = $request->status;
                $cold_call->followup_date = $request->followup_date;
                $cold_call->residual = '';
                $cold_call->status = $request->status;
                $cold_call->address = $request->address;
                $cold_call->remark = $request->remark;
                $cold_call->created_date = date('d-m-Y');
                $cold_call->created_time = time();
                $cold_call->ip_address = $_SERVER['REMOTE_ADDR'];
                $saveCall = $cold_call->save();
            }
        } elseif (isset($request->status) && $request->status == 3) {
            if ($request->residual == '') {
                return back()->with('faild', 'Please select residual date!');
            } else {
                $cold_call->company_id = Session::get('company_id');
                $cold_call->user_type = 1;
                $cold_call->client_name = $request->client_name;
                $cold_call->company_name = $request->company_name;
                $cold_call->phone = $request->phone;
                $cold_call->email = $request->email;
                $cold_call->keywords = $request->keywords;
                $cold_call->followup_date = '';
                $cold_call->residual = $request->residual;
                $cold_call->status = $request->status;
                $cold_call->address = $request->address;
                $cold_call->remark = $request->remark;
                $cold_call->created_date = date('d-m-Y');
                $cold_call->created_time = time();
                $cold_call->ip_address = $_SERVER['REMOTE_ADDR'];
                $saveCall = $cold_call->save();
            }
        }
        if ($saveCall) {
            return back()->with('success', 'Cold call save successfully!');
        }
    }

    public function Edit_coldcall($id)
    {
        $edit_coldId = Crypt::decrypt($id);
        $edit_data = Meeting::find($edit_coldId);
        return view('backend.coldcall.edit-coldcall', compact('edit_data'));
    }

    public function update_coldcall(Request $request)
    {

        $update_coldcall = Meeting::find(Crypt::decrypt($request->meetingid));

        if ($request->email != $update_coldcall->email) {
            $request->validate([
                'email' => 'email|unique:meetings,email',
            ]);
        }
        $request->validate([
            'client_name' => 'required',
            'phone' => 'required|numeric|min:10',
            'status' => 'required|not_in:0',
        ]);
        if (isset($request->status) && $request->status == 1) {

            $request->validate([
                'visiting_card' => 'mimes:jpeg,jpg,png',
                'shop_img' => 'mimes:jpeg,jpg,png',
                'amount_pic' => 'mimes:jpeg,jpg,png'
            ]);

            if ($request->visiting_card != "" && $request->shop_img != "" && $request->amount_pic != "") {
                $path = "assets/uploads/meeting/visitingCard/" . $update_coldcall->visiting_card;
                $path2 = "assets/uploads/meeting/shopImage/" . $update_coldcall->shop_img;
                $path3 = "assets/uploads/meeting/amount_pic/" . $update_coldcall->amount_pic;

                if (File::exists($path) && File::exists($path2) && File::exists($path3)) {
                    File::delete($path);
                    File::delete($path2);
                    File::delete($path3);
                }
                $file = $request->file('visiting_card');
                $exten = $file->getClientOriginalExtension();
                $visiting_rename = time() . rand() . "." . $exten;
                $file->move("assets/uploads/meeting/visitingCard/", $visiting_rename);

                $file2 = $request->file('shop_img');
                $exten2 = $file2->getClientOriginalExtension();
                $shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $shopimg);

                $file3 = $request->file('amount_pic');
                $exten3 = $file3->getClientOriginalExtension();
                $amount_rename = time() . rand() . "." . $exten3;
                $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

                $update_coldcall->company_id = Session::get('company_id');
                $update_coldcall->user_type = 1;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->visiting_card = $visiting_rename;
                $update_coldcall->shop_img = $shopimg;
                $update_coldcall->status = $request->status;
                $update_coldcall->amount_pic = $amount_rename;
                $update_coldcall->address = $request->address;
                $update_coldcall->remark = $request->remark;
                $saveCall = $update_coldcall->save();
            } elseif ($request->visiting_card != "" && $request->shop_img == "" && $request->amount_pic == "") {
                $path = "assets/uploads/meeting/visitingCard/" . $update_coldcall->visiting_card;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('visiting_card');
                $exten = $file->getClientOriginalExtension();
                $visiting_rename = time() . rand() . "." . $exten;
                $file->move("assets/uploads/meeting/visitingCard/", $visiting_rename);

                $update_coldcall->company_id = Session::get('company_id');
                $update_coldcall->user_type = 1;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->visiting_card = $visiting_rename;
                $update_coldcall->status = $request->status;
                $update_coldcall->address = $request->address;
                $update_coldcall->remark = $request->remark;
                $saveCall = $update_coldcall->save();
            } elseif ($request->shop_img != "" && $request->visiting_card == "" && $request->amount_pic == "") {
                $path2 = "assets/uploads/meeting/shopImage/" . $update_coldcall->shop_img;

                if (File::exists($path2)) {
                    File::delete($path2);
                }
                $file2 = $request->file('shop_img');
                $exten2 = $file2->getClientOriginalExtension();
                $shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $shopimg);

                $update_coldcall->company_id = Session::get('company_id');
                $update_coldcall->user_type = 1;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->shop_img = $shopimg;
                $update_coldcall->status = $request->status;
                $update_coldcall->address = $request->address;
                $update_coldcall->remark = $request->remark;
                $saveCall = $update_coldcall->save();
            } elseif ($request->amount_pic != "" && $request->shop_img == "" && $request->visiting_card == "") {
                $path3 = "assets/uploads/meeting/amount_pic/" . $update_coldcall->amount_pic;
                if (File::exists($path3)) {
                    File::delete($path3);
                }

                $file3 = $request->file('amount_pic');
                $exten3 = $file3->getClientOriginalExtension();
                $amount_rename = time() . rand() . "." . $exten3;
                $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

                $update_coldcall->company_id = Session::get('company_id');
                $update_coldcall->user_type = 1;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->status = $request->status;
                $update_coldcall->amount_pic = $amount_rename;
                $update_coldcall->address = $request->address;
                $update_coldcall->remark = $request->remark;
                $saveCall = $update_coldcall->save();
            } elseif ($request->visiting_card != "" && $request->shop_img != "" && $request->amount_pic == "") {
                $path = "assets/uploads/meeting/visitingCard/" . $update_coldcall->visiting_card;
                $path2 = "assets/uploads/meeting/shopImage/" . $update_coldcall->shop_img;

                if (File::exists($path) && File::exists($path2)) {
                    File::delete($path);
                    File::delete($path2);
                }
                $file = $request->file('visiting_card');
                $exten = $file->getClientOriginalExtension();
                $visiting_rename = time() . rand() . "." . $exten;
                $file->move("assets/uploads/meeting/visitingCard/", $visiting_rename);

                $file2 = $request->file('shop_img');
                $exten2 = $file2->getClientOriginalExtension();
                $shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $shopimg);

                $update_coldcall->company_id = Session::get('company_id');
                $update_coldcall->user_type = 1;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->visiting_card = $visiting_rename;
                $update_coldcall->shop_img = $shopimg;
                $update_coldcall->status = $request->status;
                $update_coldcall->address = $request->address;
                $update_coldcall->remark = $request->remark;
                $saveCall = $update_coldcall->save();
            } elseif ($request->visiting_card != "" && $request->amount_pic != "" && $request->shop_img == "") {
                $path = "assets/uploads/meeting/visitingCard/" . $update_coldcall->visiting_card;
                $path3 = "assets/uploads/meeting/amount_pic/" . $update_coldcall->amount_pic;

                if (File::exists($path) && File::exists($path3)) {
                    File::delete($path);
                    File::delete($path3);
                }
                $file = $request->file('visiting_card');
                $exten = $file->getClientOriginalExtension();
                $visiting_rename = time() . rand() . "." . $exten;
                $file->move("assets/uploads/meeting/visitingCard/", $visiting_rename);

                $file3 = $request->file('amount_pic');
                $exten3 = $file3->getClientOriginalExtension();
                $amount_rename = time() . rand() . "." . $exten3;
                $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

                $update_coldcall->company_id = Session::get('company_id');
                $update_coldcall->user_type = 1;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->visiting_card = $visiting_rename;
                $update_coldcall->status = $request->status;
                $update_coldcall->amount_pic = $amount_rename;
                $update_coldcall->address = $request->address;
                $update_coldcall->remark = $request->remark;
                $saveCall = $update_coldcall->save();
            } elseif ($request->amount_pic != "" && $request->shop_img != "" && $request->visiting_card == "") {
                $path2 = "assets/uploads/meeting/shopImage/" . $update_coldcall->shop_img;
                $path3 = "assets/uploads/meeting/amount_pic/" . $update_coldcall->amount_pic;

                if (File::exists($path2) && File::exists($path3)) {
                    File::delete($path2);
                    File::delete($path3);
                }


                $file2 = $request->file('shop_img');
                $exten2 = $file2->getClientOriginalExtension();
                $shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $shopimg);

                $file3 = $request->file('amount_pic');
                $exten3 = $file3->getClientOriginalExtension();
                $amount_rename = time() . rand() . "." . $exten3;
                $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

                $update_coldcall->company_id = Session::get('company_id');
                $update_coldcall->user_type = 1;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->shop_img = $shopimg;
                $update_coldcall->status = $request->status;
                $update_coldcall->amount_pic = $amount_rename;
                $update_coldcall->address = $request->address;
                $update_coldcall->remark = $request->remark;
                $saveCall = $update_coldcall->save();
            } else {
                $update_coldcall->company_id = Session::get('company_id');
                $update_coldcall->user_type = 1;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->status = $request->status;
                $update_coldcall->address = $request->address;
                $update_coldcall->remark = $request->remark;
                $saveCall = $update_coldcall->save();
            }
        } elseif (isset($request->status) && $request->status == 2) {
            if ($request->followup_date == '') {
                return back()->with('faild', 'Please select follow up date!');
            } else {
                $update_coldcall->company_id = Session::get('company_id');
                $update_coldcall->user_type = 1;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->followup_date = $request->followup_date;
                $update_coldcall->residual = '';
                $update_coldcall->status = $request->status;
                $update_coldcall->address = $request->address;
                $update_coldcall->remark = $request->remark;
                $saveCall = $update_coldcall->save();
            }
        } elseif (isset($request->status) && $request->status == 3) {
            if ($request->residual == '') {
                return back()->with('faild', 'Please select residual date!');
            } else {
                $update_coldcall->company_id = Session::get('company_id');
                $update_coldcall->user_type = 1;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->followup_date = '';
                $update_coldcall->residual = $request->residual;
                $update_coldcall->status = $request->status;
                $update_coldcall->address = $request->address;
                $update_coldcall->remark = $request->remark;
                $saveCall = $update_coldcall->save();
            }
        }
        if ($saveCall) {
            return redirect(route('backend.coldcall'))->with('success', 'Cold Call update successfully!');
        }
    }

    public function Archive_cold_cold(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('meetings')
                ->where('company_id', Session::get('company_id'))
                ->where('archive', 1)
                ->where('type', 0)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm text-danger" href="' . url('admin/active-cold-call', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-arrow-clockwise"></i></a>';
                    // $btn .= '<a class="btn btn-danger btn-sm m-1" href="' . url('marketing/delete-cold-col', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.coldcall.archive-cold-call');
    }

    public function Delete_coldcall($id)
    {
        $cold_Id = Crypt::decrypt($id);
        $delete_coldcall = Meeting::find($cold_Id);
        $delete_coldcall->archive = 1;
        $active_cal = $delete_coldcall->save();
        if ($active_cal) {
            return back()->with('success', 'Cold Call Activated');
        }
    }

    public function Active_cold_cold($id)
    {
        $cold_activeId = Crypt::decrypt($id);
        $active_coldcall = Meeting::find($cold_activeId);
        $active_coldcall->archive = 0;
        $active_cal = $active_coldcall->save();
        if ($active_cal) {
            return redirect(route('backend.view-cold-call'))->with('success', 'Cold Call Activated');
        }
    }


    public function AdminColdCall_AddService(Request $request)
    {
        $meeting = DB::table('meetings')
            ->where('company_id', Session::get('company_id'))
            ->where('archive', 0)
            ->where('user_type', 1)
            ->where('type', 0)
            ->where('id', Crypt::decrypt($request->meetingid))
            ->first();

        $temp_service = DB::table('service_temp')->where('company_id', Session::get('company_id'))->where('meetingid', Crypt::decrypt($request->meetingid))->get();

        return view('backend.coldcall.add-service-coldcall', compact('meeting', 'temp_service'));
    }

    public function AdminColdCall_ServiceSubmit(Request $request)
    {

        if ($request->serviceid != "" && $request->price != "" && $request->meetingid != "") {

            $temp_service = DB::table('service_temp')->insert([
                'company_id' => Session::get('company_id'),
                'meetingid' => Crypt::decrypt($request->meetingid),
                'serviceid' => $request->serviceid,
                'price' => $request->price,
                'tenure' => $request->tenure,
                'created_date' => date('d-m-Y H:i:s'),
                'created_time' => time(),
                'ip' => $_SERVER['REMOTE_ADDR']
            ]);

            if ($temp_service) {
                if ($request->discount != 0) {

                    $price = DB::table('service_temp')->where('company_id', Session::get('company_id'))->where('meetingid', Crypt::decrypt($request->meetingid))->sum('price');
                    $total  = ($price / 100) * $request->discount;

                    DB::table('meetings')
                        ->where('company_id', Session::get('company_id'))
                        ->where('archive', 0)
                        ->where('user_type', 1)
                        ->where('type', 0)
                        ->where('id', Crypt::decrypt($request->meetingid))
                        ->update([
                            'temp_value' => $total,
                            'blance' => $total
                        ]);
                } else {
                    $total = DB::table('service_temp')->where('company_id', Session::get('company_id'))->where('meetingid', Crypt::decrypt($request->meetingid))->sum('price');
                    DB::table('meetings')
                        ->where('company_id', Session::get('company_id'))
                        ->where('archive', 0)
                        ->where('user_type', 1)
                        ->where('type', 0)
                        ->where('id', Crypt::decrypt($request->meetingid))
                        ->update([
                            'temp_value' => $total,
                            'blance' => $total
                        ]);
                }
            }
        }
        return response()->json(['status' => 200]);
    }

    public function AdminColdCall_ServiceDiscount(Request $request)
    {
        if (isset($request->meetingid) && $request->meetingid != "") {
            $total = $request->total;
            $dis = $request->discount;

            $dis_price  = ($total / 100) * $dis;
            $total_amt =  $total - $dis_price;

            DB::table('meetings')
                ->where('company_id', Session::get('company_id'))
                ->where('archive', 0)
                ->where('user_type', 1)
                ->where('type', 0)
                ->where('id', Crypt::decrypt($request->meetingid))
                ->update([
                    'blance' => $total_amt,
                    'temp_value' => $total_amt,
                    'discount' => $dis
                ]);
            return back();
        }
    }

    public function AdminColdCall_ServiceDelete(Request $request)
    {
        if (isset($request->serviceid) && isset($request->meetingid)) {

            $service_delete = DB::table('service_temp')->where('id', Crypt::decrypt($request->serviceid))->where('meetingid', Crypt::decrypt($request->meetingid))->delete();

            if ($service_delete) {
                $total_amt = DB::table('service_temp')->where('meetingid', Crypt::decrypt($request->meetingid))->sum('price');
                $meeting_data = DB::table('meetings')->where('id', Crypt::decrypt($request->meetingid))->where('archive', 0)->where('user_type', 1)->where('type', 0)->where('company_id', Session::get('company_id'))->first();

                $dis_price  = ($total_amt / 100) * $meeting_data->discount;
                $total =  $total_amt - $dis_price;

                DB::table('meetings')
                    ->where('id', Crypt::decrypt($request->meetingid))
                    ->where('archive', 0)
                    ->where('user_type', 1)
                    ->where('type', 0)
                    ->where('company_id', Session::get('company_id'))
                    ->update([
                        'blance' => $total,
                        'temp_value' => $total,
                    ]);

                if ($total_amt == 0) {
                    DB::table('meetings')
                        ->where('id', Crypt::decrypt($request->meetingid))
                        ->where('archive', 0)
                        ->where('user_type', 1)
                        ->where('type', 0)
                        ->where('company_id', Session::get('company_id'))
                        ->update([
                            'temp_value' => 0,
                            'blance' => 0,
                            'discount' => 0
                        ]);
                }
            }
        }
        return response()->json(['status' => 200]);
    }

    public function AdminColdCall_ServiceDetails(Request $request)
    {
        if (isset($request->meetingid) && $request->meetingid != "") {
            $meeting_data = Meeting::where('id', Crypt::decrypt($request->meetingid))->first();
            $temp_service = DB::table('service_temp')->where('meetingid', Crypt::decrypt($request->meetingid))->where('company_id', Session::get('company_id'))->get();
            $payment = DB::table('payment_details')->where('meeting_id', Crypt::decrypt($request->meetingid))->get();
        }
        return view('backend.coldcall.coldcall-details', compact('meeting_data', 'temp_service', 'payment'));
    }
}
