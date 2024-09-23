<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\frontend\TeleMarket;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function login()
    {
        return view('frontend.login');
    }

    public function TeleUserLogin(Request $request)
    {
        // dd($request->all());

        $credentials = $request->only('email', 'password');
// dd($credentials);

if (Auth::guard('telecaller')->attempt($credentials)) {
    // return "1111";
    return redirect()->route('telecaller.index');
} else {
    // Check if the user exists
    $user = \App\Models\Tele::where('email', $credentials['email'])->first();
    if (!$user) {
        return back()->withErrors(['message' => 'User not found']);
        dd('User not found');
    } else {
        return back()->withErrors(['message' => 'Invalid password']);
        dd('Invalid password');
    }
}

// If the code reaches here, it means the authentication attempt failed
return back()->withErrors(['message' => 'Invalid credentials']);

        $userlogin = TeleMarket::where('email', '=', $request->email)->first();

        if ($userlogin) {
            if (Hash::check($request->password, $userlogin->password)) {
                $request->session()->put('user_id', $userlogin->id);
                $request->session()->put('company_id', $userlogin->company_id);
                // return redirect('home');
                return redirect()->route('user.home');
            } else {
                return back()->with('faild', 'Password not match.');
            }
        } else {
            return back()->with('faild', 'This email is not registred.');
        }
    }


    public function telemarketlogout()
    {
        if (Session::has('user_id')) {
            Session::pull('user_id');
            return redirect('/login');
        }
    }
}
