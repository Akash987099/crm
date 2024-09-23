<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\backend\Users;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function login()
    {
        return view('backend.login');
    }


    public function signup()
    {
        return view('backend.register');
    }

    public function userlogin(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $userlogin = Users::where('email', '=', $request->email)->first();
        if ($userlogin) {
            if (Hash::check($request->password, $userlogin->password)) {
                $request->session()->put('company_id', $userlogin->id, 'username', $userlogin->name);
                return redirect('admin/home');
            } else {
                return back()->with('faild', 'Password not match.');
            }
        } else {
            return back()->with('faild', 'This email is not registered.');
        }
    }


    public function create_account(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        $user = new Users;
        $user->name = trim($request['name']);
        $user->email = trim($request['email']);
        $user->password = Hash::make($request['password']);
        $user->created_date = date('d-m-Y');
        $user->created_time = time();
        $insert = $user->save();

        if ($insert) {
            $userlogin = Users::where('email', '=', $request->email)->first();
            $request->session()->put('company_id', $userlogin->id, 'username', $userlogin->name);
            return redirect('admin/home');
        } else {
            return back()->with('faild', 'Something went wrong.');
        }
    }

    public function logout()
    {
        if (Session::has('company_id')) {
            Session::pull('company_id');
            return redirect('admin/login');
        }
    }
}
