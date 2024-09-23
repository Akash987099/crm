<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\frontend\TeleMarket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class TeleProfileController extends Controller
{
    public function Myprofile()
    {
        $profile = DB::table('tele_person')->where('id', Session::get('user_id'))->first();
        return view('frontend.my-profile', compact('profile'));
    }

    public function Myprofile_Update(Request $request)
    {

        $request->validate([
            'firstname' => 'required',
            'phone' => 'required|numeric|digits:10'

        ]);
        $tele_id = Crypt::decrypt($request->teleuser_id);
        $update = TeleMarket::find($tele_id);

        if (isset($request->document_file) && $request->document_file != "") {
            $path = "assets/uploads/telemarketing/" . $update->document_file;
            if (File::exists($path)) {
                File::delete($path);
            }

            $file = $request->file('document_file');
            $extension = $file->getClientOriginalExtension();
            $rename = time() . "." . $extension;
            $file->move('assets/uploads/telemarketing/', $rename);

            $update->firstname = $request->firstname;
            $update->lastname = $request->lastname;
            $update->phone = $request->phone;
            $update->city = $request->city;
            $update->state = $request->state;
            $update->pincode = $request->pincode;
            $update->address = $request->address;
            $update->document_file = $rename;
            $profile_save = $update->save();
        } else {
            $update->firstname = $request->firstname;
            $update->lastname = $request->lastname;
            $update->phone = $request->phone;
            $update->city = $request->city;
            $update->state = $request->state;
            $update->pincode = $request->pincode;
            $update->address = $request->address;
            $profile_save = $update->save();
        }
        if ($profile_save) {
            return back()->with('success', 'User Profile Update Successfully!');
        }
    }

    public function telePass_change(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $tele_id = Crypt::decrypt($request->pass_id);
        $pass = TeleMarket::find($tele_id);

        $pass->password = Hash::make($request->password);
        $change_pass = $pass->save();
        if ($change_pass) {
            return back()->with('password', 'User Profile Update Successfully!');
        }
    }
}
