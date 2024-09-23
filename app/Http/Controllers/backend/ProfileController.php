<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Users;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\hash;

class ProfileController extends Controller
{

    public function Profile()
    {

        $profile = Users::find(Session::get('company_id'));
        $serialize_data =  unserialize($profile->social_link);
        return view('backend.profile.profile', compact('profile', 'serialize_data'));
    }

    public function ProfileUpdate(Request $request)
    {
        if ($request->name == "") {
            return response()->json(array('error' => false, 'message' => 'Please enter name'));
        } elseif ($request->desiganation == "") {
            return response()->json(array('error' => false, 'message' => 'Please enter desiganation'));
        } elseif ($request->country == "") {
            return response()->json(array('error' => false, 'message' => 'Please enter country'));
        } elseif ($request->address == "") {
            return response()->json(array('error' => false, 'message' => 'Please enter address'));
        } elseif ($request->phone == "") {
            return response()->json(array('error' => false, 'message' => 'Please enter phone'));
        } else {

            // print_r($request->all());
            // exit;
            $profile = Users::find(Session::get('company_id'));

            $twitter =  $request->twitter;
            $facebook = $request->facebook;
            $instgram = $request->instagram;
            $linkedin = $request->linkedin;

            $social_link = array("twitter" => $twitter, 'facebook' => $facebook, "instagram" => $instgram, "linkedin" => $linkedin);
            $social_serialize = serialize($social_link);

            if (isset($request->profile_pic) && $request->profile_pic != "") {
                $path = "assets/uploads/users/" . $request->profile_pic;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('profile_pic');
                $exten = $file->getClientOriginalExtension();
                $rename = time() . "." . $exten;
                $file->move('assets/uploads/users/', $rename);

                $profile->name = $request->name;
                $profile->desiganation = $request->desiganation;
                $profile->country = $request->country;
                $profile->address = $request->address;
                $profile->phone = $request->phone;
                $profile->social_link = $social_serialize;
                $profile->profile_pic = $rename;
                $profile->created_date = date('d-m-Y');
                $profile->created_time = time();
                $profile->ip_address = $_SERVER['REMOTE_ADDR'];
                $update = $profile->save();
            } else {
                $profile->name = $request->name;
                $profile->desiganation = $request->desiganation;
                $profile->country = $request->country;
                $profile->address = $request->address;
                $profile->phone = $request->phone;
                $profile->social_link = $social_serialize;

                $profile->created_date = date('d-m-Y');
                $profile->created_time = time();
                $profile->ip_address = $_SERVER['REMOTE_ADDR'];
                $update = $profile->save();
            }
            if ($update) {
                return response()->json(array('success' => true, 'success' => 'User profile update successfully!'));
            }
        }
    }




    public function change_password(Request $request)
    {
        $password = Users::find(Session::get('company_id'));

        if ($request->old_password == "") {
            return response()->json(array('error' => false, 'message' => 'Please enter old password'));
        } elseif (!hash::check($request->old_password, $password->password)) {
            return response()->json(array('error' => false, 'message' => 'The specified old password does not match the database password'));
        } elseif ($request->password == "") {
            return response()->json(array('error' => false, 'message' => 'Please enter new password'));
        } elseif ($request->password_confirmation == "") {
            return response()->json(array('error' => false, 'message' => 'Please enter confirm password'));
        } elseif ($request->password != $request->password_confirmation) {
            return response()->json(array('error' => false, 'message' => 'New and Confirm password do not match'));
        } else {
            $pass_update = Users::where('id', Session::get('company_id'))->first();
            $pass_update->password = hash::make($request->password);
            $update = $pass_update->save();
            if ($update) {
                return response()->json(array('success' => true, 'success' => 'Password update successfully!'));
            }
        }
    }
}
