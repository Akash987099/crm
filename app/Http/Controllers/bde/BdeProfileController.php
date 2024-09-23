<?php

namespace App\Http\Controllers\bde;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use App\Models\backend\Bde;

class BdeProfileController extends Controller
{
    public function Bde_Profile()
    {
        $profile = Bde::find(Session::get('user_id'));
        return view('bdend.profile', compact('profile'));
    }
    public function Bde_Profile_Submit(Request $request)
    {
        $profile_update = Bde::find(Session::get('user_id'));

        $request->validate([
            'bde_name' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|digits:10'
        ]);

        if (isset($request->document_file) && $request->document_file != '') {
            $path = "assets/uploads/bde/" . $request->document_file;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('document_file');
            $exten = $file->getClientOriginalExtension();
            $rename = time() . "." . $exten;
            $file->move('assets/uploads/bde/', $rename);

            $profile_update->bde_name = $request->bde_name;
            $profile_update->phone = $request->phone;
            $profile_update->city = $request->city;
            $profile_update->state = $request->state;
            $profile_update->country = $request->country;
            $profile_update->pincode = $request->pincode;
            $profile_update->address = $request->address;
            $profile_update->document_file = $rename;
            $update = $profile_update->save();
        } else {
            $profile_update->bde_name = $request->bde_name;
            $profile_update->phone = $request->phone;
            $profile_update->city = $request->city;
            $profile_update->state = $request->state;
            $profile_update->country = $request->country;
            $profile_update->pincode = $request->pincode;
            $profile_update->address = $request->address;
            $update = $profile_update->save();
        }
        if ($update) {
            return back()->with('success', 'Profile Update Successfully');
        }
    }
}
