<?php

namespace App\Http\Controllers\marketend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Marketing_user;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use DateTime;

class MrLogin_controller extends Controller
{
    public function marketing_login()
    {
        return view('marketend.login');
    }

    public function Login_marketing(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $datetime = new DateTime();
        $am_pm = $datetime->format('A');
        $startime = '10:00 ' . $am_pm;
        $end = '21:00:00';
        $endtime = date('h:i A', strtotime($end));
        if (Session::get('time') <= strtotime($startime) && Session::get('time') <= strtotime($endtime)) {
            /****************login************************************* */
            $marketing_user = Marketing_user::where('email', '=', $request->email)->first();
            if ($marketing_user) {
                if (Hash::check($request->password, $marketing_user->password)) {
                    $request->session()->put('user_id', $marketing_user->id, 'time', time());
                    return redirect('marketing/home');
                } else {
                    return back()->with('faild', 'Password not match');
                }
            } else {
                return back()->with('faild', 'This email is not registred.');
            }
            /****************end login******************************** */
        } else {
            return back()->with('faild', 'You can login from 10 am to 9 pm.');
        }
    }



    public function Marketing_user_logout()
    {
        if (Session::has('user_id')) {
            Session::pull('user_id');
            return redirect('marketing/login');
        }
    }
}
