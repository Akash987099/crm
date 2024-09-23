<?php

namespace App\Http\Controllers\marketend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\marketend\Marketing;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\backend\StaffRole;

class MrProfileController extends Controller
{
    public function Marketing_profile()
    {
        $profile = Marketing::find(Session::get('user_id'));
        $permision = StaffRole::all();
        if (isset($permision) && !empty($permision)) {
            $arr = "";
            foreach ($permision as $role) {
                $arr = json_decode($role->marketing);
            }
        }
        return view('marketend.marketing-user-profile', compact('profile', 'arr'));
    }
    public function Marketing_profile_update(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'phone' => 'required'
        ]);

        $marketid = Crypt::decrypt($request->marketid);
        $update = Marketing::find($marketid);

        if (isset($request->document_file) && $request->document_file != "") {
            $path = "assets/uploads/marketing/" . $update->document_file;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('document_file');
            $extension = $file->getClientOriginalExtension();
            $rename = time() . "." . $extension;
            $file->move("assets/uploads/marketing/", $rename);

            $update->firstname = $request->firstname;
            $update->lastname = $request->lastname;
            $update->phone = $request->phone;
            $update->city = $request->city;
            $update->state = $request->state;
            $update->pincode = $request->pincode;
            $update->address = $request->address;
            $update->document_file = $rename;
            $profile_update = $update->save();
        } else {
            $update->firstname = $request->firstname;
            $update->lastname = $request->lastname;
            $update->phone = $request->phone;
            $update->city = $request->city;
            $update->state = $request->state;
            $update->pincode = $request->pincode;
            $update->address = $request->address;
            $profile_update = $update->save();
        }
        if ($profile_update) {
            return back()->with('success', 'User profile update successfully!');
        }
    }

    public function Marketing_pass_change(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $pass_id = Crypt::decrypt($request->pass_id);
        $pass_update = Marketing::find($pass_id);
        $pass_update->password = Hash::make($request->password);
        $save = $pass_update->save();
        if ($save) {
            return back()->with('password', 'Password update successfully!');
        }
    }
}
