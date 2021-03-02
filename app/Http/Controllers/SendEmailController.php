<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\User;
use App\Models\UserTree;
use App\Models\UserLevel;
use App\Models\UserMailForward;
use Auth;
use DB;

class SendEmailController extends Controller
{
    function index()
    {
        return view('mail.send_email');
    }

    function send(Request $request)
    {
        $this->validate($request, [
            'name'     =>  'required',
            'email'  =>  'required|email',
            'message' =>  'required'
        ]);

        $myid = Auth::user();

        $user_mails = UserMailForward::where('user_id', $myid->id)->get('forward_email');

        $data = array(
            'name'      =>  $request->name,
            'message'   =>   $request->message
        );

        foreach ($user_mails as $user_mail) {
            // return ($user_mail->forward_email);
            Mail::to($user_mail->forward_email)->send(new SendMail($data));
        }
        return back()->with('success', 'Thanks for contacting us!');
    }
}
