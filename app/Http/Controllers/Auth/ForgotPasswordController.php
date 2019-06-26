<?php

namespace App\Http\Controllers\Auth;

use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        // call the parents constructor method
        parent::__construct();
        //Confirm that the user is a guest
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        //show the form
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {

      //override the default messages
      $messages = [
        'user_email.required' => "Please fill in your email address"
      ];

      //set the validation rules - pass the messages to the method
      $validation =  $request->validate(
        [
          'user_email' => ['required', 'string', 'email', 'max:255']
        ],
        $messages
        );

        /*
        * If validation fails we do not go any further, else we proceed
        */

        //get that the user details
        $user = User::where("user_email", $request->user_email)->first();

        //check that the user exists
        if($user != null && $user->count() > 0){

          //reset the tokens and save the changes
          $user->password_reset_token = sha1(uniqid($request->user_email, true) . strtotime("now"));
          $user->password_reset_token_last_sent = date("Y-m-d H:i:s");
          $user->user_last_updated = date("Y-m-d H:i:s");
          $user->save();

          //log the user out
          Auth::logout();

          //send the email to the user
          \Mail::to($user->user_email)->send(new \App\Mail\sendEmails($user, "backend.emails.resetPassword", "OSC Blog: Password Reset Requested"));

          //return success message
          return redirect("/password/reset")->with("success", "An email has been sent to you to reset your password, please click on the link in this email");
        }else{
          //return the error
          return redirect("/password/reset")->with("error", "This email address does not exist");
        }
    }
}
