<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
    }

    public function showPasswordResetForm($id, $token){

      if(isset($id) && !empty($id) && isset($token) && !empty($token)){
        $user = User::where("user_id", $id)->where("password_reset_token", $token)->first();

        if($user != null && $user->count() > 0){

          $data = array(
            "page_title" => "Reset Password",
            "user" => $user,
            "token" => $token
          );

          return view("auth.passwords.reset")->with($data);
        }else{
          return redirect("/password/reset")->with("error", "Invalid credentials to reset this account");
        }
      }else{
        return redirect("/login")->with("error", "An invalid request has been detected");
      }
    }

    public function reset(Request $data){

      $messages = [
        'user_password.required' => "Please provide a password",
        'password_confirmation.required' => "Please confirm your password",
        'password_confirmation.same:user_password' => "The passwords does not match",
      ];

      $validation =  $data->validate(
        [
          'user_password' => ['required', 'string', 'min:8'],
          'password_confirmation' => ['required', 'same:user_password', 'string', 'min:8'],
        ],
        $messages
        );


      $user = User::where("user_id", $data->user_id)->where("password_reset_token", $data->reset_token)->first();

      if($user != null && $user->count() > 0){


        $user->user_password = Hash::make($data->user_password);
        $user->password_reset_token = null;
        $user->password_last_reset = date("Y-m-d H:i:s");
        $user->user_last_updated = date("Y-m-d H:i:s");
        $user->save();

        return redirect("/login")->with("success", "Your password has been changed, you may now login with your new password");
      }else{
        return redirect("/password/reset")->with("error", "Invalid credentials to reset this account");
      }
    }
}
