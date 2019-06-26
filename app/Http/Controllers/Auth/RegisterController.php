<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //override the default error messages with custom ones
        $messages = [
          'user_first_name.required' => "Fill in your first name",
          'user_surname.required' => "Fill in your surname",
          'user_email.unique:users' => "Email Address already exists",
          'user_email.required' => "Please fill in your email address",
          'user_password.required' => "Please provide a password",
          'password_confirmation.required' => "Please confirm your password",
          'password_confirmation.same:user_password' => "The passwords does not match",
        ];

        //validate the form
        return Validator::make(
          $data,
          [
            'user_first_name' => ['required', 'string', 'max:255'],
            'user_surname' => ['required', 'string', 'max:255'],
            'user_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'user_password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'same:user_password', 'string', 'min:8'],
          ],
          $messages
          );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        if(isset($data['user_profile_image']) && !empty($data['user_profile_image']) && $data['user_profile_image'] != USER_PROFILE_IMAGES_NO_IMAGE_FILE){
          $profile_image = $data['user_profile_image'];
        }else{
          $profile_image = USER_PROFILE_IMAGES_NO_IMAGE_FILE;
        }

        $verificationToken = sha1(uniqid($request->user_email, true) . strtotime("now"));

         $user =  User::create([
            'user_first_name' => $data['user_first_name'],
            'user_surname' => $data['user_surname'],
            'user_email' => $data['user_email'],
            'user_profile_image' => $profile_image,
            'user_password' => Hash::make($data['user_password']),
            'user_email_verify_token' => $verificationToken,
        ]);

        $options = array(
          "subject" => "OSC Blog: Email Verification Required"
        );

        \Mail::to($user->user_email)->send(new \App\Mail\sendEmails($user, "backend.emails.verifyEmail", "OSC Blog: Email Verification Required"));

        return $user;
    }
}
