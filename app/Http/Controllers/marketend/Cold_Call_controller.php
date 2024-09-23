<?php

namespace App\Http\Controllers\marketend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use App\Models\backend\Services;
use App\Models\marketend\Meeting;
use App\Models\backend\StaffRole;
use Illuminate\Validation\Rules\Exists;
use Yajra\DataTables\DataTables;

class Cold_Call_controller extends Controller
{

    public function View_cold_Call()
    {
        return view('marketend.view-cold-call');
    }

    public function View_cold_list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('meetings')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 0)
                ->where('user_type', 2)
                ->where('type', 0)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1 text-white coldcall_id" title="View Data" href="' . route('market.coldcall-view-details', ['meetingid' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-eye"></i></a>';
                    if ($row->status == 1) {
                        $btn .= '<a class="btn btn-warning btn-sm m-1 text-white" title="Bill Pay" href="' . route('market.will-pay', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-cash"></i></a>';
                    }
                    if (!DB::table('payment_details')->where('meeting_id', $row->id)->exists()) {
                        $btn .= '<a class="btn btn-primary btn-sm m-1" title="Update" href="' . url('marketing/edit-cold-call', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                        $btn .= '<a class="btn btn-info btn-sm m-1" title="Add Services" href="' . route('market.add-service', ['meetingid' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-plus-circle-fill"></i></a>';
                    }

                    $btn .= '<a class="btn btn-danger btn-sm m-1" title="Delete" href="' . url('marketing/delete-cold-col', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function Cold_Call()
    {
        $permision = StaffRole::all();
        if (isset($permision) && !empty($permision)) {
            $arr = "";
            foreach ($permision as $role) {
                $arr = json_decode($role->marketing);
            }
        }
        return view('marketend.cold-call', compact('arr'));
    }

    public function Add_Cold_Call(Request $request)
    {
        $add_coldcall = new Meeting();

        $request->validate([
            'client_name' => 'required',
            'phone' => 'required|numeric|digits:10',
            'keywords' => 'required',
            'status' => 'required|not_in:0'
        ]);

        if (isset($request->status) && $request->status == 1) {

            $request->validate([
                'visiting_card' => 'required|mimes:jpeg,png,jpg',
                'shop_img' => 'required|mimes:jpeg,png,jpg',
                'amount_pic' => 'required|mimes:jpeg,png,jpg'
            ]);

            if ($request->visiting_card != "" && $request->shop_img != "" && $request->amount_pic != "") {
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

                $add_coldcall->user_id = Session::get('user_id');
                $add_coldcall->user_type = 2;
                $add_coldcall->client_name = $request->client_name;
                $add_coldcall->company_name = $request->company_name;
                $add_coldcall->phone = $request->phone;
                $add_coldcall->email = $request->email;
                $add_coldcall->keywords = $request->keywords;
                $add_coldcall->visiting_card = $visiting_rename;
                $add_coldcall->shop_img = $shopimg;
                $add_coldcall->status = $request->status;
                $add_coldcall->payment_mode = $request->payment_mode;
                $add_coldcall->amount_pic = $amount_rename;
                $add_coldcall->address = $request->address;
                $add_coldcall->remark = $request->remark;
                $add_coldcall->created_date = date('d-m-Y');
                $add_coldcall->created_time = time();
                $add_coldcall->ip_address = $_SERVER['REMOTE_ADDR'];
                $saveCall = $add_coldcall->save();
            }
        } elseif (isset($request->status) && $request->status == 2) {
            if ($request->followup_date == '') {
                return back()->with('faild', 'Please select follow up date!');
            } else {
                $add_coldcall->user_id = Session::get('user_id');
                $add_coldcall->user_type = 2;
                $add_coldcall->client_name = $request->client_name;
                $add_coldcall->company_name = $request->company_name;
                $add_coldcall->phone = $request->phone;
                $add_coldcall->email = $request->email;
                $add_coldcall->keywords = $request->keywords;
                $add_coldcall->status = $request->status;
                $add_coldcall->payment_mode = $request->payment_mode;
                $add_coldcall->followup_date = $request->followup_date;
                $add_coldcall->residual = '';
                $add_coldcall->address = $request->address;
                $add_coldcall->remark = $request->remark;
                $add_coldcall->created_date = date('d-m-Y');
                $add_coldcall->created_time = time();
                $add_coldcall->ip_address = $_SERVER['REMOTE_ADDR'];
                $saveCall = $add_coldcall->save();
            }
        } elseif (isset($request->status) && $request->status == 3) {
            if ($request->residual == '') {
                return back()->with('faild', 'Please select residual date!');
            } else {
                $add_coldcall->user_id = Session::get('user_id');
                $add_coldcall->user_type = 2;
                $add_coldcall->client_name = $request->client_name;
                $add_coldcall->company_name = $request->company_name;
                $add_coldcall->phone = $request->phone;
                $add_coldcall->email = $request->email;
                $add_coldcall->keywords = $request->keywords;
                $add_coldcall->status = $request->status;
                $add_coldcall->payment_mode = $request->payment_mode;
                $add_coldcall->followup_date = '';
                $add_coldcall->residual = $request->residual;
                $add_coldcall->address = $request->address;
                $add_coldcall->remark = $request->remark;
                $add_coldcall->created_date = date('d-m-Y');
                $add_coldcall->created_time = time();
                $add_coldcall->ip_address = $_SERVER['REMOTE_ADDR'];
                $saveCall = $add_coldcall->save();
            }
        }
        if ($saveCall) {
            return back()->with('success', 'Cold call save successfully!');
        }
    }

    public function Edit_cold_call($id)
    {
        $edit_meeting = Meeting::find(Crypt::decrypt($id));
        return view('marketend.edit-cold-call', compact('edit_meeting'));
    }

    public function Cold_col_update(Request $request)
    {
        $update_coldcall = Meeting::find(Crypt::decrypt($request->coldId));

        $request->validate([
            'client_name' => 'required',
            'phone' => 'required|numeric|digits:10',
            'keywords' => 'required',
            'payment_mode' => 'required|not_in:0'
        ]);
        if ($request->email != $update_coldcall->email) {
            $request->validate([
                'email' => 'unique:meetings,email'
            ]);
        }

        if (isset($request->status) && $request->status == 1) {
            $request->validate([
                'visiting_card' => 'image|mimes:jpeg,png,jpg|max:1000',
                'shop_img' => 'image|mimes:jpeg,png,jpg|max:1000',
                'amount_pic' => 'image|mimes:jpeg,png,jpg|max:1000'
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

                $update_coldcall->user_id = Session::get('user_id');
                $update_coldcall->user_type = 2;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->visiting_card = $visiting_rename;
                $update_coldcall->shop_img = $shopimg;
                $update_coldcall->status = $request->status;
                $update_coldcall->payment_mode = $request->payment_mode;
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

                $update_coldcall->user_id = Session::get('user_id');
                $update_coldcall->user_type = 2;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->visiting_card = $visiting_rename;
                $update_coldcall->status = $request->status;
                $update_coldcall->payment_mode = $request->payment_mode;
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

                $update_coldcall->user_id = Session::get('user_id');
                $update_coldcall->user_type = 2;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->shop_img = $shopimg;
                $update_coldcall->status = $request->status;
                $update_coldcall->payment_mode = $request->payment_mode;
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

                $update_coldcall->user_id = Session::get('user_id');
                $update_coldcall->user_type = 2;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->service_price = $request->service_price;
                $update_coldcall->status = $request->status;
                $update_coldcall->payment_mode = $request->payment_mode;
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

                $update_coldcall->user_id = Session::get('user_id');
                $update_coldcall->user_type = 2;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->visiting_card = $visiting_rename;
                $update_coldcall->shop_img = $shopimg;
                $update_coldcall->status = $request->status;
                $update_coldcall->payment_mode = $request->payment_mode;
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

                $update_coldcall->user_id = Session::get('user_id');
                $update_coldcall->user_type = 2;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->visiting_card = $visiting_rename;
                $update_coldcall->status = $request->status;
                $update_coldcall->payment_mode = $request->payment_mode;
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

                $update_coldcall->user_id = Session::get('user_id');
                $update_coldcall->user_type = 2;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->shop_img = $shopimg;
                $update_coldcall->status = $request->status;
                $update_coldcall->payment_mode = $request->payment_mode;
                $update_coldcall->amount_pic = $amount_rename;
                $update_coldcall->address = $request->address;
                $update_coldcall->remark = $request->remark;
                $saveCall = $update_coldcall->save();
            } else {
                $update_coldcall->user_id = Session::get('user_id');
                $update_coldcall->user_type = 2;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->status = $request->status;
                $update_coldcall->payment_mode = $request->payment_mode;
                $update_coldcall->address = $request->address;
                $update_coldcall->remark = $request->remark;
                $saveCall = $update_coldcall->save();
            }
        } elseif (isset($request->status) && $request->status == 2) {
            if ($request->followup_date == '') {
                return back()->with('faild', 'Please select follow up date!');
            } else {
                $update_coldcall->user_id = Session::get('user_id');
                $update_coldcall->user_type = 2;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->payment_mode = $request->payment_mode;
                $update_coldcall->followup_date = $request->followup_date;
                $update_coldcall->residual = '';
                $update_coldcall->address = $request->address;
                $update_coldcall->remark = $request->remark;
                $update_coldcall->created_date = date('d-m-Y');
                $update_coldcall->created_time = time();
                $update_coldcall->ip_address = $_SERVER['REMOTE_ADDR'];
                $saveCall = $update_coldcall->save();
            }
        } elseif (isset($request->status) && $request->status == 3) {
            if ($request->residual == '') {
                return back()->with('faild', 'Please select residual date!');
            } else {
                $update_coldcall->user_id = Session::get('user_id');
                $update_coldcall->user_type = 2;
                $update_coldcall->client_name = $request->client_name;
                $update_coldcall->company_name = $request->company_name;
                $update_coldcall->phone = $request->phone;
                $update_coldcall->email = $request->email;
                $update_coldcall->keywords = $request->keywords;
                $update_coldcall->payment_mode = $request->payment_mode;
                $update_coldcall->followup_date = '';
                $update_coldcall->residual = $request->residual;
                $update_coldcall->status = $request->status;
                $update_coldcall->address = $request->address;
                $update_coldcall->remark = $request->remark;
                $saveCall = $update_coldcall->save();
            }
        }
        if ($saveCall) {
            return redirect(route('market.view-cold-call'))->with('success', 'Cold call update successfully!');
        }
    }

    public function Delete_cold_call($id)
    {
        $deleteId = Crypt::decrypt($id);
        $delete = Meeting::find($deleteId);
        $delete->archive = 1;
        $save_delete = $delete->save();
        if ($save_delete) {
            return back()->with('success', 'Cold call delete successfully!');
        }
    }


    public function View_coldcall_details(Request $request)
    {
        if (isset($request->meetingid) && $request->meetingid != "") {
            $meeting_data = Meeting::where('id', Crypt::decrypt($request->meetingid))->first();
            $temp_service = DB::table('service_temp')->where('meetingid', Crypt::decrypt($request->meetingid))->where('user_id', Session::get('user_id'))->get();
            $payment = DB::table('payment_details')->where('meeting_id', Crypt::decrypt($request->meetingid))->get();
        }
        return view('marketend.coldcall-details', compact('meeting_data', 'temp_service', 'payment'));
    }

    public function Archive_ColdCall(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('meetings')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 1)
                ->where('user_type', 2)
                ->where('type', 0)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a data-toggle="tooltip" data-placement="top" title="Active Cold Call" class="btn btn-info" href="' . url('marketing/activate-cold-call', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-arrow-clockwise"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('marketend.archive-cold-call');
    }

    public function ActiveColdCall($id)
    {
        $active_id = Crypt::decrypt($id);
        $active_coldCall = Meeting::find($active_id);
        $active_coldCall->archive = 0;
        $active = $active_coldCall->save();
        if ($active) {
            return redirect('marketing/view-cold-call')->with('success', ' Active Cold call successfully!');
        }
    }



    public function COLDCALL_SERVICE_ADD(Request $request)
    {
        if (isset($request->meetingid)) {
            $meeting = DB::table('meetings')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 0)
                ->where('user_type', 2)
                ->where('type', 0)
                ->where('id', Crypt::decrypt($request->meetingid))
                ->first();

            $temp_service = DB::table('service_temp')->where('user_id', Session::get('user_id'))->where('meetingid', Crypt::decrypt($request->meetingid))->get();
        }


        return view('marketend.add-services', compact('meeting', 'temp_service'));
    }

    public function MEETING_SERVICE_SUBMIT(Request $request)
    {
        if ($request->serviceid != "" && $request->price != "" && $request->meetingid != "") {

            $temp_service = DB::table('service_temp')->insert([
                'user_id' => Session::get('user_id'),
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
                    $price = DB::table('service_temp')->where('user_id', Session::get('user_id'))->where('meetingid', Crypt::decrypt($request->meetingid))->sum('price');
                    $total  = ($price / 100) * $request->discount;
                    DB::table('meetings')
                        ->where('user_id', Session::get('user_id'))
                        ->where('archive', 0)
                        ->where('user_type', 2)
                        ->where('type', 1)
                        ->where('id', Crypt::decrypt($request->meetingid))
                        ->update([
                            'temp_value' => $total,
                            'blance' => $total
                        ]);
                } else {
                    $total = DB::table('service_temp')->where('user_id', Session::get('user_id'))->where('meetingid', Crypt::decrypt($request->meetingid))->sum('price');
                    DB::table('meetings')
                        ->where('user_id', Session::get('user_id'))
                        ->where('archive', 0)
                        ->where('user_type', 2)
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

    public function DELETE_SERVICE_DATA(Request $request)
    {
        if (isset($request->serviceid) && isset($request->meetingid)) {

            $service_delete = DB::table('service_temp')->where('id', Crypt::decrypt($request->serviceid))->delete();

            if ($service_delete) {
                $total_amt = DB::table('service_temp')->where('meetingid', Crypt::decrypt($request->meetingid))->sum('price');

                $meeting_data = DB::table('meetings')
                    ->where('id', Crypt::decrypt($request->meetingid))
                    ->where('archive', 0)
                    ->where('user_type', 2)
                    ->where('type', 0)
                    ->where('user_id', Session::get('user_id'))
                    ->first();

                $dis_price  = ($total_amt / 100) * $meeting_data->discount;
                $total =  $total_amt - $dis_price;
                if ($total_amt == 0) {
                    DB::table('meetings')
                        ->where('id', Crypt::decrypt($request->meetingid))
                        ->where('archive', 0)
                        ->where('user_type', 2)
                        ->where('type', 0)
                        ->where('user_id', Session::get('user_id'))
                        ->update([
                            'temp_value' => 0,
                            'blance' => 0,
                            'discount' => 0
                        ]);
                } else {
                    DB::table('meetings')
                        ->where('id', Crypt::decrypt($request->meetingid))
                        ->where('archive', 0)
                        ->where('user_type', 2)
                        ->where('type', 0)
                        ->where('user_id', Session::get('user_id'))
                        ->update([
                            'blance' => $total
                        ]);
                }
            }
        }
        return response()->json(['status' => 200]);
    }

    public function SERVICE_PRICE_DISCOUNT(Request $request)
    {
        if (isset($request->meetingid) && $request->meetingid != "") {
            $total = $request->total;
            $dis = $request->discount;

            $dis_price  = ($total / 100) * $dis;
            $total_amt =  $total - $dis_price;

            DB::table('meetings')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 0)
                ->where('user_type', 2)
                ->where('type', 0)
                ->where('id', Crypt::decrypt($request->meetingid))
                ->update([
                    'blance' => $total_amt,
                    'discount' => $dis
                ]);
            return back();
        }
    }
}
