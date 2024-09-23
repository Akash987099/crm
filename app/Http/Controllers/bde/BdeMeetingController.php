<?php

namespace App\Http\Controllers\bde;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\marketend\Meeting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\backend\Services;
use Yajra\DataTables\DataTables;

class BdeMeetingController extends Controller
{
    public function View_Bde_Meeting(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('meetings')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 0)
                ->where('type', 1)
                ->where('user_type', 4)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-sm m-1 text-white" href="' . route('bde.meeting-details', ['meetingid' => Crypt::encrypt($row->id)]) . '" title="View Details"> <i class="bi bi-eye"></i></a>';
                    if ($row->status == 1) {
                        $btn .= '<a class="btn btn-warning btn-sm m-1 text-white" title="Payment Details" href="' . route('bde.bill-pay', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-cash"></i></a>';
                    }
                    if ($row->status == 1) {
                        if (!DB::table('payment_details')->where('meeting_id', $row->id)->exists()) {
                            $btn .= '<a class="btn btn-primary btn-sm m-1" title="Edit" href="' . route('bde.edit-bde-meeting', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-pencil-square"></i></a>';
                            $btn .= '<a class="btn btn-info btn-sm m-1" title="Add Services" href="' . route('bde.add-meeting-service', ['meetingid' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-plus-circle-fill"></i></a>';
                        }
                    }
                    $btn .= '<a class="btn btn-danger btn-sm m-1" title="Delete" href="' . url('bde/delete-bde-meeting', ['id' => Crypt::encrypt($row->id)]) . '"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('bdend.view-bde-meeting');
    }


    public function Add_Bde_Meeting()
    {
        $ashign_client = DB::table('clients')
            ->where('assign_meating', Session::get('user_id'))
            ->select('id', 'client_name', 'company_name')
            ->where('typeofuser', 3)
            ->where('archive', 0)
            ->get();
        return view('bdend.add-bde-meeting', compact('ashign_client'));
    }
    // public function Submit_Bde_Meeting(Request $request)
    // {
    //     // $request->validate([
    //     //     'client_id' => 'required|unique:meetings,client_id',
    //     //     'company_name' => 'required',
    //     //     'phone' => 'required|numeric|digits:10',
    //     //     'email' => 'unique:meetings,email',
    //     //     'keywords' => 'required',
    //     //     'company_service' => 'required',
    //     //     'visiting_card' => 'required',
    //     //     'shop_img' => 'required'
    //     // ]);

    //     // $add_meeting = new Meeting();

    //     // if ($request->visiting_card != "" && $request->shop_img != "") {
    //     //     $path = "assets/uploads/meeting/visitingCard/" . $request->visiting_card;
    //     //     $path2 = "assets/uploads/meeting/shopImage/" . $request->shop_img;
    //     //     if (File::exists($path) && File::exists($path2)) {
    //     //         File::delete($path);
    //     //         File::delete($path2);
    //     //     }
    //     //     $file = $request->file('visiting_card');
    //     //     $exten = $file->getClientOriginalExtension();
    //     //     $visiting_rename = time() . "." . $exten;
    //     //     $file->move("assets/uploads/meeting/visitingCard/", $visiting_rename);

    //     //     $file2 = $request->file('shop_img');
    //     //     $exten2 = $file2->getClientOriginalExtension();
    //     //     $shop_img_rename = time() . "." . $exten2;
    //     //     $file2->move("assets/uploads/meeting/shopImage/", $shop_img_rename);


    //     //     $add_meeting->company_id = Session::get('company_id');
    //     //     $add_meeting->user_id = Session::get('user_id');
    //     //     $add_meeting->user_type = 4;
    //     //     $add_meeting->type = 1;
    //     //     $add_meeting->client_id = $request->client_id;
    //     //     $add_meeting->company_name = $request->company_name;
    //     //     $add_meeting->phone = $request->phone;
    //     //     $add_meeting->email = $request->email;
    //     //     $add_meeting->keywords = $request->keywords;
    //     //     $add_meeting->company_service = json_encode($request->company_service);
    //     //     $add_meeting->address = $request->address;
    //     //     $add_meeting->visiting_card = $visiting_rename;
    //     //     $add_meeting->shop_img = $shop_img_rename;
    //     //     $add_meeting->tenure = $request->tenure;
    //     //     $add_meeting->service_price = $request->service_price;

    //     //     $add_meeting->status = $request->status;
    //     //     if (isset($request->status) && $request->status == 1) {
    //     //         if ($request->amount_pic == "") {
    //     //             return back()->with('faild', 'Please select payment image!');
    //     //         } else {
    //     //             $path3 = "assets/uploads/meeting/amount_pic/" . $request->amount_pic;
    //     //             if (File::exists($path3)) {
    //     //                 File::delete($path3);
    //     //             }
    //     //             $file3 = $request->file('amount_pic');
    //     //             $exten3 = $file3->getClientOriginalExtension();
    //     //             $amount_rename = time() . "." . $exten3;
    //     //             $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

    //     //             $add_meeting->payment_mode = $request->payment_mode;
    //     //             $add_meeting->discount = $request->discount;
    //     //             $add_meeting->advance_amount = $request->advance_amount;
    //     //             $add_meeting->blance = $request->blance;
    //     //             $add_meeting->temp_value = $request->blance;
    //     //             $add_meeting->amount_pic = $amount_rename;
    //     //         }
    //     //     } elseif (isset($request->status) && $request->status == 3) {
    //     //         $add_meeting->followup_date = $request->followup_date;
    //     //     }
    //     //     $add_meeting->remark = $request->remark;
    //     //     $add_meeting->created_date = date("d-m-Y");
    //     //     $add_meeting->created_time = time();
    //     //     $add_meeting->ip_address = $_SERVER['REMOTE_ADDR'];
    //     //     $save_meeting = $add_meeting->save();
    //     // } elseif ($request->visiting_card != "" && $request->shop_img == "") {
    //     //     $path = "assets/uploads/meeting/visitingCard/" . $request->visiting_card;
    //     //     if (File::exists($path)) {
    //     //         File::delete($path);
    //     //     }
    //     //     $file = $request->file('visiting_card');
    //     //     $exten = $file->getClientOriginalExtension();
    //     //     $visiting_rename = time() . "." . $exten;
    //     //     $file->move("assets/uploads/meeting/visitingCard/", $visiting_rename);

    //     //     $add_meeting->company_id = Session::get('company_id');
    //     //     $add_meeting->user_id = Session::get('user_id');
    //     //     $add_meeting->user_type = 4;
    //     //     $add_meeting->type = 1;
    //     //     $add_meeting->client_id = $request->client_id;
    //     //     $add_meeting->company_name = $request->company_name;
    //     //     $add_meeting->phone = $request->phone;
    //     //     $add_meeting->email = $request->email;
    //     //     $add_meeting->keywords = $request->keywords;
    //     //     $add_meeting->company_service = json_encode($request->company_service);
    //     //     $add_meeting->address = $request->address;
    //     //     $add_meeting->visiting_card = $visiting_rename;
    //     //     $add_meeting->tenure = $request->tenure;
    //     //     $add_meeting->service_price = $request->service_price;
    //     //     $add_meeting->status = $request->status;

    //     //     if (isset($request->status) && $request->status == 1) {
    //     //         if ($request->amount_pic == "") {
    //     //             return back()->with('faild', 'Please select payment image!');
    //     //         } else {
    //     //             $path3 = "assets/uploads/meeting/amount_pic/" . $request->amount_pic;
    //     //             if (File::exists($path3)) {
    //     //                 File::delete($path3);
    //     //             }
    //     //             $file3 = $request->file('amount_pic');
    //     //             $exten3 = $file3->getClientOriginalExtension();
    //     //             $amount_rename = time() . "." . $exten3;
    //     //             $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

    //     //             $add_meeting->payment_mode = $request->payment_mode;
    //     //             $add_meeting->discount = $request->discount;
    //     //             $add_meeting->advance_amount = $request->advance_amount;
    //     //             $add_meeting->blance = $request->blance;
    //     //             $add_meeting->temp_value = $request->blance;
    //     //             $add_meeting->amount_pic = $amount_rename;
    //     //         }
    //     //     } elseif (isset($request->status) && $request->status == 3) {
    //     //         $add_meeting->followup_date = $request->followup_date;
    //     //     }

    //     //     $add_meeting->remark = $request->remark;
    //     //     $add_meeting->created_date = date("d-m-Y");
    //     //     $add_meeting->created_time = time();
    //     //     $add_meeting->ip_address = $_SERVER['REMOTE_ADDR'];
    //     //     $save_meeting = $add_meeting->save();
    //     // } elseif ($request->visiting_card == "" && $request->shop_img != "") {
    //     //     $path2 = "assets/uploads/meeting/shopImage/" . $request->shop_img;
    //     //     if (File::exists($path2)) {
    //     //         File::delete($path2);
    //     //     }
    //     //     $file2 = $request->file('shop_img');
    //     //     $exten2 = $file2->getClientOriginalExtension();
    //     //     $shop_img_rename = time() . "." . $exten2;
    //     //     $file2->move("assets/uploads/meeting/shopImage/", $shop_img_rename);

    //     //     $add_meeting->company_id = Session::get('company_id');
    //     //     $add_meeting->user_id = Session::get('user_id');
    //     //     $add_meeting->user_type = 4;
    //     //     $add_meeting->type = 1;
    //     //     $add_meeting->client_id = $request->client_id;
    //     //     $add_meeting->company_name = $request->company_name;
    //     //     $add_meeting->phone = $request->phone;
    //     //     $add_meeting->email = $request->email;
    //     //     $add_meeting->keywords = $request->keywords;
    //     //     $add_meeting->company_service = json_encode($request->company_service);
    //     //     $add_meeting->address = $request->address;
    //     //     $add_meeting->shop_img = $shop_img_rename;
    //     //     $add_meeting->tenure = $request->tenure;
    //     //     $add_meeting->service_price = $request->service_price;
    //     //     $add_meeting->status = $request->status;

    //     //     if (isset($request->status) && $request->status == 1) {
    //     //         if ($request->amount_pic == "") {
    //     //             return back()->with('faild', 'Please select payment image!');
    //     //         } else {
    //     //             $path3 = "assets/uploads/meeting/amount_pic/" . $request->amount_pic;
    //     //             if (File::exists($path3)) {
    //     //                 File::delete($path3);
    //     //             }
    //     //             $file3 = $request->file('amount_pic');
    //     //             $exten3 = $file3->getClientOriginalExtension();
    //     //             $amount_rename = time() . "." . $exten3;
    //     //             $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

    //     //             $add_meeting->payment_mode = $request->payment_mode;
    //     //             $add_meeting->discount = $request->discount;
    //     //             $add_meeting->advance_amount = $request->advance_amount;
    //     //             $add_meeting->blance = $request->blance;
    //     //             $add_meeting->temp_value = $request->blance;
    //     //             $add_meeting->amount_pic = $amount_rename;
    //     //         }
    //     //     } elseif (isset($request->status) && $request->status == 3) {
    //     //         $add_meeting->followup_date = $request->followup_date;
    //     //     }

    //     //     $add_meeting->remark = $request->remark;
    //     //     $add_meeting->created_date = date("d-m-Y");
    //     //     $add_meeting->created_time = time();
    //     //     $add_meeting->ip_address = $_SERVER['REMOTE_ADDR'];
    //     //     $save_meeting = $add_meeting->save();
    //     // } else {
    //     //     $add_meeting->company_id = Session::get('company_id');
    //     //     $add_meeting->user_id = Session::get('user_id');
    //     //     $add_meeting->user_type = 4;
    //     //     $add_meeting->type = 1;
    //     //     $add_meeting->client_id = $request->client_id;
    //     //     $add_meeting->company_name = $request->company_name;
    //     //     $add_meeting->phone = $request->phone;
    //     //     $add_meeting->email = $request->email;
    //     //     $add_meeting->keywords = $request->keywords;
    //     //     $add_meeting->company_service = json_encode($request->company_service);
    //     //     $add_meeting->address = $request->address;
    //     //     $add_meeting->tenure = $request->tenure;
    //     //     $add_meeting->service_price = $request->service_price;
    //     //     $add_meeting->status = $request->status;

    //     //     if (isset($request->status) && $request->status == 1) {
    //     //         if ($request->amount_pic == "") {
    //     //             return back()->with('faild', 'Please select payment image!');
    //     //         } else {
    //     //             $path3 = "assets/uploads/meeting/amount_pic/" . $request->amount_pic;
    //     //             if (File::exists($path3)) {
    //     //                 File::delete($path3);
    //     //             }
    //     //             $file3 = $request->file('amount_pic');
    //     //             $exten3 = $file3->getClientOriginalExtension();
    //     //             $amount_rename = time() . "." . $exten3;
    //     //             $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

    //     //             $add_meeting->payment_mode = $request->payment_mode;
    //     //             $add_meeting->discount = $request->discount;
    //     //             $add_meeting->advance_amount = $request->advance_amount;
    //     //             $add_meeting->blance = $request->blance;
    //     //             $add_meeting->temp_value = $request->blance;
    //     //             $add_meeting->amount_pic = $amount_rename;
    //     //         }
    //     //     } elseif (isset($request->status) && $request->status == 3) {
    //     //         $add_meeting->followup_date = $request->followup_date;
    //     //     }

    //     //     $add_meeting->remark = $request->remark;
    //     //     $add_meeting->created_date = date("d-m-Y");
    //     //     $add_meeting->created_time = time();
    //     //     $add_meeting->ip_address = $_SERVER['REMOTE_ADDR'];
    //     //     $save_meeting = $add_meeting->save();
    //     // }

    //     // if ($save_meeting) {
    //     //     DB::table('clients')->where('id', $request->client_id)
    //     //         ->where('archive', 0)
    //     //         ->update(array('status' => $request->status));
    //     //     return back()->with('success', 'Meeting Add successfully!');
    //     // }
    // }
    public function Edit_Bde_Meeting($id)
    {
        $edit_meeting = Meeting::find(Crypt::decrypt($id));
        return view('bdend.edit-bde-meeting', compact('edit_meeting'));
    }

    public function Update_Bde_Meeting(Request $request)
    {
        $update_meeting = Meeting::find(Crypt::decrypt($request->meditld));

        if (isset($request->status) && $request->status == 1) {
            if ($request->visiting_card != '' && $request->shop_img != '' && $request->amount_pic != '') {
                $path = "assets/uploads/meeting/visitingCard/" . $request->visiting_card;
                $path2 = "assets/uploads/meeting/shopImage/" . $request->shop_img;
                $path3 = "assets/uploads/meeting/amount_pic/" . $request->amount_pic;
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
                $rename_shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $rename_shopimg);

                $file3 = $request->file('amount_pic');
                $exten3 = $file3->getClientOriginalExtension();
                $amount_rename = time() . rand() . "." . $exten3;
                $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

                $update_meeting->user_id = Session::get('user_id');
                $update_meeting->clientid = Crypt::decrypt($request->cltid);
                $update_meeting->user_type = 4;
                $update_meeting->type = 1;
                $update_meeting->client_name = $request->client_name;
                $update_meeting->company_name = $request->company_name;
                $update_meeting->phone = $request->phone;
                $update_meeting->email = $request->email;
                $update_meeting->keywords = $request->keywords;
                $update_meeting->address = $request->address;
                $update_meeting->visiting_card = $visiting_rename;
                $update_meeting->shop_img = $rename_shopimg;
                $update_meeting->amount_pic = $amount_rename;
                $update_meeting->status = $request->status;
                $update_meeting->residual = '';
                $update_meeting->followup_date = '';
                $update_meeting->remark = $request->remark;
                $save_meeting = $update_meeting->save();
            } elseif ($request->visiting_card != '' && $request->shop_img == '' && $request->amount_pic == '') {
                $path = "assets/uploads/meeting/visitingCard/" . $request->visiting_card;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('visiting_card');
                $exten = $file->getClientOriginalExtension();
                $visiting_rename = time() . rand() . "." . $exten;
                $file->move("assets/uploads/meeting/visitingCard/", $visiting_rename);

                $update_meeting->user_id = Session::get('user_id');
                $update_meeting->clientid = Crypt::decrypt($request->cltid);
                $update_meeting->user_type = 4;
                $update_meeting->type = 1;
                $update_meeting->client_name = $request->client_name;
                $update_meeting->company_name = $request->company_name;
                $update_meeting->phone = $request->phone;
                $update_meeting->email = $request->email;
                $update_meeting->keywords = $request->keywords;
                $update_meeting->address = $request->address;
                $update_meeting->visiting_card = $visiting_rename;
                $update_meeting->status = $request->status;
                $update_meeting->residual = '';
                $update_meeting->followup_date = '';
                $update_meeting->remark = $request->remark;
                $save_meeting = $update_meeting->save();
            } elseif ($request->shop_img != '' && $request->visiting_card == '' && $request->amount_pic == '') {
                $path2 = "assets/uploads/meeting/shopImage/" . $request->shop_img;
                if (File::exists($path2)) {
                    File::delete($path2);
                }
                $file2 = $request->file('shop_img');
                $exten2 = $file2->getClientOriginalExtension();
                $rename_shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $rename_shopimg);

                $update_meeting->user_id = Session::get('user_id');
                $update_meeting->clientid = Crypt::decrypt($request->cltid);
                $update_meeting->user_type = 4;
                $update_meeting->type = 1;
                $update_meeting->client_name = $request->client_name;
                $update_meeting->company_name = $request->company_name;
                $update_meeting->phone = $request->phone;
                $update_meeting->email = $request->email;
                $update_meeting->keywords = $request->keywords;
                $update_meeting->address = $request->address;
                $update_meeting->shop_img = $rename_shopimg;
                $update_meeting->status = $request->status;
                $update_meeting->residual = '';
                $update_meeting->followup_date = '';
                $update_meeting->remark = $request->remark;
                $save_meeting = $update_meeting->save();
            } elseif ($request->amount_pic != '' && $request->shop_img == '' && $request->visiting_card == '') {
                $path3 = "assets/uploads/meeting/amount_pic/" . $request->amount_pic;
                if (File::exists($path3)) {
                    File::delete($path3);
                }
                $file3 = $request->file('amount_pic');
                $exten3 = $file3->getClientOriginalExtension();
                $amount_rename = time() . rand() . "." . $exten3;
                $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

                $update_meeting->user_id = Session::get('user_id');
                $update_meeting->clientid = Crypt::decrypt($request->cltid);
                $update_meeting->user_type = 4;
                $update_meeting->type = 1;
                $update_meeting->client_name = $request->client_name;
                $update_meeting->company_name = $request->company_name;
                $update_meeting->phone = $request->phone;
                $update_meeting->email = $request->email;
                $update_meeting->keywords = $request->keywords;
                $update_meeting->address = $request->address;
                $update_meeting->amount_pic = $amount_rename;
                $update_meeting->status = $request->status;
                $update_meeting->residual = '';
                $update_meeting->followup_date = '';
                $update_meeting->remark = $request->remark;
                $save_meeting = $update_meeting->save();
            } elseif ($request->shop_img != '' && $request->visiting_card != '' && $request->amount_pic == '') {
                $path = "assets/uploads/meeting/visitingCard/" . $request->visiting_card;
                $path2 = "assets/uploads/meeting/shopImage/" . $request->shop_img;
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
                $rename_shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $rename_shopimg);

                $update_meeting->user_id = Session::get('user_id');
                $update_meeting->clientid = Crypt::decrypt($request->cltid);
                $update_meeting->user_type = 4;
                $update_meeting->type = 1;
                $update_meeting->client_name = $request->client_name;
                $update_meeting->company_name = $request->company_name;
                $update_meeting->phone = $request->phone;
                $update_meeting->email = $request->email;
                $update_meeting->keywords = $request->keywords;
                $update_meeting->address = $request->address;
                $update_meeting->visiting_card = $visiting_rename;
                $update_meeting->shop_img = $rename_shopimg;
                $update_meeting->status = $request->status;
                $update_meeting->residual = '';
                $update_meeting->followup_date = '';
                $update_meeting->remark = $request->remark;
                $save_meeting = $update_meeting->save();
            } elseif ($request->visiting_card != '' && $request->amount_pic != '' && $request->shop_img == '') {
                $path = "assets/uploads/meeting/visitingCard/" . $request->visiting_card;
                $path3 = "assets/uploads/meeting/amount_pic/" . $request->amount_pic;
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

                $update_meeting->user_id = Session::get('user_id');
                $update_meeting->clientid = Crypt::decrypt($request->cltid);
                $update_meeting->user_type = 4;
                $update_meeting->type = 1;
                $update_meeting->client_name = $request->client_name;
                $update_meeting->company_name = $request->company_name;
                $update_meeting->phone = $request->phone;
                $update_meeting->email = $request->email;
                $update_meeting->keywords = $request->keywords;
                $update_meeting->address = $request->address;
                $update_meeting->visiting_card = $visiting_rename;
                $update_meeting->amount_pic = $amount_rename;
                $update_meeting->status = $request->status;
                $update_meeting->residual = '';
                $update_meeting->followup_date = '';
                $update_meeting->remark = $request->remark;
                $save_meeting = $update_meeting->save();
            } elseif ($request->amount_pic != '' && $request->shop_img != '' && $request->visiting_card == '') {

                $path2 = "assets/uploads/meeting/shopImage/" . $request->shop_img;
                $path3 = "assets/uploads/meeting/amount_pic/" . $request->amount_pic;
                if (File::exists($path2) && File::exists($path3)) {
                    File::delete($path2);
                    File::delete($path3);
                }

                $file2 = $request->file('shop_img');
                $exten2 = $file2->getClientOriginalExtension();
                $rename_shopimg = time() . rand() . "." . $exten2;
                $file2->move("assets/uploads/meeting/shopImage/", $rename_shopimg);

                $file3 = $request->file('amount_pic');
                $exten3 = $file3->getClientOriginalExtension();
                $amount_rename = time() . rand() . "." . $exten3;
                $file3->move("assets/uploads/meeting/amount_pic/", $amount_rename);

                $update_meeting->user_id = Session::get('user_id');
                $update_meeting->clientid = Crypt::decrypt($request->cltid);
                $update_meeting->user_type = 4;
                $update_meeting->type = 1;
                $update_meeting->client_name = $request->client_name;
                $update_meeting->company_name = $request->company_name;
                $update_meeting->phone = $request->phone;
                $update_meeting->email = $request->email;
                $update_meeting->keywords = $request->keywords;
                $update_meeting->address = $request->address;
                $update_meeting->shop_img = $rename_shopimg;
                $update_meeting->amount_pic = $amount_rename;
                $update_meeting->status = $request->status;
                $update_meeting->residual = '';
                $update_meeting->followup_date = '';
                $update_meeting->remark = $request->remark;
                $save_meeting = $update_meeting->save();
            } else {
                $update_meeting->user_id = Session::get('user_id');
                $update_meeting->clientid = Crypt::decrypt($request->cltid);
                $update_meeting->user_type = 4;
                $update_meeting->type = 1;
                $update_meeting->client_name = $request->client_name;
                $update_meeting->company_name = $request->company_name;
                $update_meeting->phone = $request->phone;
                $update_meeting->email = $request->email;
                $update_meeting->keywords = $request->keywords;
                $update_meeting->address = $request->address;
                $update_meeting->status = $request->status;
                $update_meeting->residual = '';
                $update_meeting->followup_date = '';
                $update_meeting->remark = $request->remark;
                $save_meeting = $update_meeting->save();
            }
        } elseif (isset($request->status) && $request->status == 2) {
            if ($request->followup_date == '') {
                return back()->with('faild', 'Please select follow up date!');
            } else {
                $update_meeting->user_id = Session::get('user_id');
                $update_meeting->clientid = Crypt::decrypt($request->cltid);
                $update_meeting->user_type = 4;
                $update_meeting->type = 1;
                $update_meeting->client_name = $request->client_name;
                $update_meeting->company_name = $request->company_name;
                $update_meeting->phone = $request->phone;
                $update_meeting->email = $request->email;
                $update_meeting->followup_date = $request->followup_date;
                $update_meeting->residual = '';
                $update_meeting->status = $request->status;
                $save_meeting = $update_meeting->save();
            }
        } elseif (isset($request->status) && $request->status == 3) {
            if ($request->residual == '') {
                return back()->with('faild', 'Please select residual date!');
            }
            $update_meeting->user_id = Session::get('user_id');
            $update_meeting->clientid = Crypt::decrypt($request->cltid);
            $update_meeting->user_type = 4;
            $update_meeting->type = 1;
            $update_meeting->client_name = $request->client_name;
            $update_meeting->company_name = $request->company_name;
            $update_meeting->phone = $request->phone;
            $update_meeting->email = $request->email;
            $update_meeting->residual = $request->residual;
            $update_meeting->followup_date = '';
            $update_meeting->status = $request->status;
            $save_meeting = $update_meeting->save();
        }
        if ($save_meeting) {
            DB::table('clients')->where('id', Crypt::decrypt($request->cltid))
                ->where('archive', 0)
                ->update(array('meeting_status' => $request->status, 'followup_date' => $request->followup_date, 'reschedule' => $request->residual));
            return redirect(route('bde.view-bde-meeting'))->with('success', 'Meeting Update Successfully!');
        }
    }
    public function Archive_Bde_Meeting(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('meetings')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 1)
                ->where('type', 1)
                ->where('user_type', 4)
                ->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-primary btn-sm m-1" href="' . url('bde/active-bde-meeting', ['id' => Crypt::encrypt($row->id)]) . '"> <i class="bi bi-arrow-clockwise"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('bdend.archive-bde-meeting');
    }


    public function Delete_Bde_Meeting($id)
    {
        $delete_id = Crypt::decrypt($id);
        $meeting_delete = Meeting::find($delete_id);
        $meeting_delete->archive = 1;
        $meeting_delete->save();
        return back()->with('success', 'Meeting Delete Successfully!');
    }

    public function Active_Bde_Meeting($id)
    {
        $active_id = Crypt::decrypt($id);
        $active_meeting = Meeting::find($active_id);
        $active_meeting->archive = 0;
        $active_meeting->save();
        return redirect(route('bde.view-bde-meeting'))->with('success', 'Meeting Active Successfully!');
    }


    public function AddBdeMeetingService(Request $request)
    {
        $meeting = DB::table('meetings')
            ->where('user_id', Session::get('user_id'))
            ->where('archive', 0)
            ->where('type', 1)
            ->where('user_type', 4)
            ->where('id', Crypt::decrypt($request->meetingid))
            ->first();

        $temp_service = DB::table('service_temp')->where('user_id', Session::get('user_id'))->where('meetingid', Crypt::decrypt($request->meetingid))->get();

        return view('bdend.add-meeting-service', compact('meeting', 'temp_service'));
    }

    public function BdeMeetingServiceSubmit(Request $request)
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
                        ->where('user_type', 4)
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
                        ->where('user_type', 4)
                        ->where('type', 1)
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

    public function BdeMeetingServiceDiscount(Request $request)
    {
        if (isset($request->meetingid) && $request->meetingid != "") {
            $total = $request->total;
            $dis = $request->discount;

            $dis_price  = ($total / 100) * $dis;
            $total_amt =  $total - $dis_price;

            DB::table('meetings')
                ->where('user_id', Session::get('user_id'))
                ->where('archive', 0)
                ->where('user_type', 4)
                ->where('type', 1)
                ->where('id', Crypt::decrypt($request->meetingid))
                ->update([
                    'blance' => $total_amt,
                    'temp_value' => $total_amt,
                    'discount' => $dis
                ]);
            return back();
        }
    }

    public function BdeMeetingServiceDelete(Request $request)
    {
        if (isset($request->serviceid) && isset($request->meetingid)) {

            $service_delete = DB::table('service_temp')->where('id', Crypt::decrypt($request->serviceid))->where('meetingid', Crypt::decrypt($request->meetingid))->delete();

            if ($service_delete) {
                $total_amt = DB::table('service_temp')->where('meetingid', Crypt::decrypt($request->meetingid))->sum('price');
                $meeting_data = DB::table('meetings')->where('id', Crypt::decrypt($request->meetingid))->where('archive', 0)->where('user_type', 4)->where('type', 1)->where('user_id', Session::get('user_id'))->first();

                $dis_price  = ($total_amt / 100) * $meeting_data->discount;
                $total =  $total_amt - $dis_price;

                DB::table('meetings')
                    ->where('id', Crypt::decrypt($request->meetingid))
                    ->where('archive', 0)
                    ->where('user_type', 4)
                    ->where('type', 1)
                    ->where('user_id', Session::get('user_id'))
                    ->update([
                        'blance' => $total,
                        'temp_value' => $total,
                    ]);

                if ($total_amt == 0) {
                    DB::table('meetings')
                        ->where('id', Crypt::decrypt($request->meetingid))
                        ->where('archive', 0)
                        ->where('user_type', 4)
                        ->where('type', 1)
                        ->where('user_id', Session::get('user_id'))
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


    public function BdeMeetingDetails(Request $request)
    {

        if (isset($request->meetingid) && $request->meetingid != "") {
            $meeting_data = Meeting::where('id', Crypt::decrypt($request->meetingid))->where('user_type', 4)->where('type', 1)->first();
            $temp_service = DB::table('service_temp')->where('meetingid', Crypt::decrypt($request->meetingid))->where('user_id', Session::get('user_id'))->get();
            $payment = DB::table('payment_details')->where('meeting_id', Crypt::decrypt($request->meetingid))->get();
        }
        return view('bdend.meeting-details', compact('meeting_data', 'temp_service', 'payment'));
    }
}
