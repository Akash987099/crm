<?php

namespace App\Http\Controllers\managerend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\managerend\Manager;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class ManagerProfileController extends Controller
{
    public function Manager_Profile()
    {
        $profile = Manager::find(Session::get('user_id'));
        return view('managerend.mprofile', compact('profile'));
    }

    public function Manager_Profile_Update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|digits:10'
        ]);

        $profile_update = Manager::find(Session::get('user_id'));

        if (isset($request->profile_pic) && $request->profile_pic != '') {
            $path = "assets/uploads/manager/" . $request->profile_pic;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('profile_pic');
            $exten = $file->getClientOriginalExtension();
            $rename = time() . "." . $exten;
            $file->move('assets/uploads/manager/', $rename);

            $profile_update->name = $request->name;
            $profile_update->phone = $request->phone;
            $profile_update->city = $request->city;
            $profile_update->state = $request->state;
            $profile_update->country = $request->country;
            $profile_update->pincode = $request->pincode;
            $profile_update->address = $request->address;
            $profile_update->profile_pic = $rename;
            $update = $profile_update->save();
        } else {
            $profile_update->name = $request->name;
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
