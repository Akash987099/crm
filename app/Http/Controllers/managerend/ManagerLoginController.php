<?php

namespace App\Http\Controllers\managerend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\managerend\Manager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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

        // dd($request->all());

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        // dd($credentials);

        if (Auth::guard('manager')->attempt($credentials)) {
            // dd($credentials);
            return redirect('manager/deshboard');
            // return redirect()->route('index');
            // return view('employee.index');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);

        $Manager = Manager::where('email' ,  $request->email)->first();

        // dd($Manager);
        // if ($Manager) {
        //     if (Hash::check($request->password, $Manager->password)) {
        //         $request->session()->put('user_id', $Manager->id);
        //         $request->session()->put('company_id', $Manager->company_id);
        //         return redirect('manager/deshboard');
        //     } else {
        //         return back()->with('faild', 'Password not match');
        //     }
        // } else {
        //     return back()->with('faild', 'This email is not registred.');
        // }
    }

    public function Manager_logout()
    {
        if (Session::has('user_id')) {
            Session::pull('user_id');
            return redirect('manager/login');
        }
    }
}
