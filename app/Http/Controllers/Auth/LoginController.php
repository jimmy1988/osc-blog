<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function __construct()
    {
        // call the parents constructor method
        // die("ok");
        parent::__construct();
        //Confirm that the user is a guest - except on the logout method
        $this->middleware('guest')->except('logout');
    }

    //set the username field
    public function username()
    {
        return 'user_email';
    }

    public function login(Request $request){

      //check whether we need to remember the user or not
      if(isset($request->remember) && !empty($request->remember) && $request->remember == "on"){
        $remember = true;
      }else{
        $remember = false;
      }

      //attempt to og the user in
      if (Auth::attempt(['user_email' => $request->user_email, 'password' => $request->user_password], $remember)) {

        //get the users details
        $current_user = User::where('user_id', Auth::id())->first();

        //so far we have no errors
        $error = false;

        //cast the user status to a string so we can evaluate it
        switch((string) $current_user->user_status){
          //active status
          case("1"):
            //ok to log in
            $error = false;
            break;
          //locked status
          case("2"):
            //error generated
            $error = true;
            $message = 'This user account has been locked';
            break;
          //Banned status
          case("3"):
            //error generated
            $error = true;
            $message = 'This user has been banned';
            break;
          //Deleted status
          case("4"):
            //error generated
            $error = true;
            $message = 'This user has been deleted';
            break;
          //no status found
          default:
            //error generated
            $error = true;
            $message = 'No user level found';
            break;
        }

        if($error){
          //log the user
          Auth::logout();
          //go back to the login page with the error message
          return redirect('/login')->with('error', $message);
        }else{

          if(isset($current_user->email_verified_at) && !empty($current_user->email_verified_at) && $current_user->email_verified_at != "0000-00-00 00:00:00"){
            $today = strtotime(date("Y-m-d H:i:s"));
            $email_verified_at = strtotime($current_user->email_verified_at);
            if($email_verified_at <= $today){
              //check that the containing
              if(is_dir($this->userContainingTempDir)){
                $this->userTempDir = $this->userContainingTempDir . "/" . Auth::id();

                //check that the user directory exists
                if(!is_dir($this->userTempDir)){
                  //if the user directory does not exist then create it
                  if(!mkdir($this->userTempDir, 0777, true)){
                    //if the directory could not be created, log the user out of the application and redirect to log in page
                    Auth::logout();
                    return redirect('/login')->with('error', "Cannot create temp user directory");
                  }else{
                    //if all is successful then take the user to the dashboard
                    return redirect("/admin");
                  }
                }else{
                  //empty the directory and delete it
                  if (is_dir($this->userTempDir)) {
                   $objects = scandir($this->userTempDir);
                   foreach ($objects as $object) {
                     if ($object != "." && $object != "..") {
                       if (filetype($this->userTempDir."/".$object) == "dir") rrmdir($this->userTempDir."/".$object); else unlink($this->userTempDir."/".$object);
                     }
                   }
                   reset($objects);
                   rmdir($this->userTempDir);
                  }
                  //try making the directory
                  if(!mkdir($this->userTempDir, 0777, true)){
                    //if unsuccessful then log the user and redirect
                    Auth::logout();
                    return redirect('/login')->with('error', "Cannot create temp user directory");
                  }else{
                    return redirect("/admin");
                  }
                }
              }else{
                //log the user out, redirect them and return an error message
                Auth::logout();
                return redirect('/login')->with('error', "Cannot find the main directory for temp files");
              }
            }else{
              //log the user out, redirect them and return an error message
              Auth::logout();
              return redirect('/login')->with('error', "We have sent you an email to verify your email address, please click on the link in the email to verify your email address");
            }
          }else{
            //log the user out, redirect them and return an error message
            Auth::logout();
            return redirect('/login')->with('error', "We have sent you an email to verify your email address, please click on the link in the email to verify your email address");
          }
        }
      }else{
        //return an error
        return redirect('/login')->with('error', 'No user found');
      }
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function logout(Request $request) {

      //gets the temp directory
      $this->userTempDir = $this->userContainingTempDir . "/" . Auth::id();

      //checks that the directory exists
      if(is_dir($this->userTempDir)) {
        //scan the directory and start to empty it
       $objects = scandir($this->userTempDir);
       foreach ($objects as $object) {
         if ($object != "." && $object != "..") {
           if (filetype($this->userTempDir."/".$object) == "dir") rrmdir($this->userTempDir."/".$object); else unlink($this->userTempDir."/".$object);
         }
       }
       //reset the objects and remove the directory
       reset($objects);
       rmdir($this->userTempDir);
      }

      //reset the remember token
      $user = User::where("user_id", Auth::id())->first();
      $user->remember_token = NULL;
      $user->save();

      //log the user out
      Auth::logout();
      return redirect('/login');
    }
}
