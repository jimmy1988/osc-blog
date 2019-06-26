<?php

namespace App\Http\Controllers\Auth;

use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */



    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function verify($id, $token){

      Auth::logout();

      $user = User::where('user_id', $id)->where('user_email_verify_token', $token)->first();

      if($user->count() > 0){

        // $user->update(['email_verified_at', date("Y-m-d H:i:s")]);
        $user->email_verified_at = date("Y-m-d H:i:s");
        $user->save();

        Auth::loginUsingId($id);

        return redirect("/admin")->with("success", "Your email and account has been verfied successfully");
      }else{
        return redirect("/login")->with("error", "The verification credentials are invalid");
      }
    }

    public function resend($id){

      $user = User::where("user_id", $id)->first();



      if($user != null && $user->count() > 0){

        $user->user_email_verify_token = sha1(uniqid($request->user_email, true) . strtotime("now"));
        $user->email_verified_at = null;
        $user->save();

        \Mail::to($user->user_email)->send(new \App\Mail\sendEmails($user, "backend.emails.verifyEmail", "OSC Blog: Email Verification Required"));
        return redirect("/password/reset")->with("success", "An email has been sent to you to reset your password, please click on the link in this email");
      }else{
        return redirect("/password/reset")->with("error", "The email could not be resent at this time, please try again later");
      }
    }
}
