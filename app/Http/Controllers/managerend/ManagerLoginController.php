<?php

namespace App\Http\Controllers\managerend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\managerend\Manager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ManagerLoginController extends Controller
{
    public function Manager_Login()
    {
        return view('managerend.login');
    }

    public function Manager_Login_submit(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // $current_time = Carbon::now()->setTimezone('Asia/Kolkata');
        // $start_time = Carbon::createFromTime(9, 0, 0, 'Asia/Kolkata'); 
        // $end_time = Carbon::createFromTime(18, 0, 0, 'Asia/Kolkata'); 

        // if ($current_time->lt($start_time) || $current_time->gt($end_time)) {
        //     return response()->json(['status' => "timeout", 'message' => 'Login is allowed only between 9 AM and 6 PM IST.']);
        // }

        $credentials = $request->only('email', 'password');

        // dd($credentials);

        if (Auth::guard('manager')->attempt($credentials)) {

            // return "1111";

            return response()->json(['status' => "success"]);
           
        }

        return response()->download(['status' => "error"]);

    }

    public function Manager_logout(Request $request)
    {

        Auth::guard('manager')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('manager/login');

        return redirect()->route('employeeLogin');

        if (Session::has('user_id')) {
            Session::pull('user_id');
            return redirect('manager/login');
        }
    }
}
