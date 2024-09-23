<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\letter;
use App\Models\employee;
use Illuminate\Support\Facades\Mail;

class lettercontroller extends Controller
{
    public function letter(){
        $letter = letter::all();
        return view('backend.admin.letter' , compact('letter'));
    }

    public function lettersave(Request $request){
        // dd($request->all());

        $welcome = $request->welcome;
        $terminate = $request->terminate;

        if($welcome != NULL){
            $insert = Letter::updateOrCreate(
                ['type' => 1], 
                ['description' => $welcome] 
            );
            
        }elseif($terminate != NULL){
            $insert = Letter::updateOrCreate(
                ['type' => 2], 
                ['description' => $terminate] 
            );
        }

        if($insert)
    {
        return response()->json(array('status'=>'success'));
    }
    return response()->json(array('status'=>'error'));
    }

    public function sendletter(Request $request){
        // dd($request->all());

        $senduerid = $request->senduerid;
        $template = $request->template;

        $data = employee::where('id' , $senduerid)->first();
        $letter = letter::where('type' , $senduerid)->first();

        $email = $data->email;
        

        // Construct the message and subject for the recipient

        $messageRecipient = "Dear $data->firstname $data->lastname\n\n";

        $subjectRecipient = 'Welcome Letter';

        $description = $letter->description ?? '-';
        $messageRecipient .= strip_tags($description);


        $mail = Mail::raw($messageRecipient, function ($mail) use ($email, $subjectRecipient) {

            $mail->to($email)->subject($subjectRecipient);

        });

        if($mail){
            return response()->json(array('status'=>'success'));
        }
        return response()->json(array('error'=>'failed!'));


    }

}
