<?php

namespace App\Http\Controllers\bde;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Bde;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class BdeLoginController extends Controller
{
    public function Bde_Login()
    {
        return view('bdend.login');
    }

    public function Bde_Login_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $bde = Bde::where('email', '=', $request->email)->first();

        if ($bde) {
            if (Hash::check($request->password, $bde->password)) {
                $request->session()->put('user_id', $bde->id);
                $request->session()->put('company_id', $bde->company_id);
                return redirect('bde/deshboard');
            } else {
                return back()->with('faild', 'Password not match');
            }
        } else {
            return back()->with('faild', 'This email is not registred.');
        }
    }

    public function Bde_logout()
    {
        if (Session::has('user_id')) {
            Session::pull('user_id');
            return redirect('bde/login');
        }
    }
}
