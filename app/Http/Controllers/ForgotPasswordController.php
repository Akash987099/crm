<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Illuminate\Http\Request;

use DB;

use Carbon\Carbon;

use App\Models\User;

use Mail;

// use Hash;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;



class ForgotPasswordController extends Controller

{

    //use SendsPasswordResetEmails;

    public function comingsoon(){
        return view('coming-soon');
    }



    public function ForgetPassword() {

        return view('employee.forget-password');

    }



    public function ForgetPasswordPost(Request $request) {

        // dd($request->all());

        $request->validate([

            'email' => 'required',

        ]);


        $emaildata = DB::table('employee')->where('email' , $request->email)->first();

        // dd($emaildata);

        if($emaildata){

        $email = $emaildata->email;

        $token = Str::random(64);



        $mail = Mail::send('employee.forget-password-email', ['token' => $token], function($message) use($email){

            $message->to($email);

            // $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

            $message->subject('Reset Password');

        });

        if($mail){
            return back()->with('success', 'Send reset link successfully!');
        }

    }else{
        return back()->with('failed', 'Record Not found!!');
    }



        return back()->with('success', 'We have emailed your password reset link!');

    }



    public function ResetPassword($token) {

        return view('employee.forget-password-link', ['token' => $token]);

    }

    

    public function ResetPasswordStore(Request $request) {

        // dd($request->all());
        $request->validate([

            'email' => 'required',

            'password' => 'required|string|min:8|confirmed',

            'password_confirmation' => 'required'

        ]);

        $data = DB::table('employee')->where('email' , $request->email)->first();

       

        if($data){
            $email = $data->email;
            $id = $data->id;

            // dd($id);
            
          $password = Hash::make($request->password);

        $change = DB::table('employee')->where('id' , $id)->update([
            'password' => $password,
            'show_password' => $request->password,
        ]);

        if($change){
            return redirect('/employee')->with('message', 'Your password has been successfully changed!');
        }else{
            return back()->withInput()->with('error', 'Invalid token!');
        }

        }else{
            return back()->withInput()->with('error', 'Record Not Found!');
        }


    }

}

