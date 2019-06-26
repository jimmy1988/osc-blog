<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UserLevel;
use App\UserStatus;

class UsersController extends Controller
{

  public function __construct()
  {
      parent::__construct();
      $this->middleware('auth');
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
      if(Auth::id() > 0){
        $user_id = Auth::id();
        $user_details = User::where('user_id', $user_id)->first();
        $user_levels = UserLevel::all();
        $user_status = UserStatus::all();

        if($user_details->user_level <= 3){
          $data = array(
            "page_title" => "Add New User",
            "user_details" => $user_details,
            "user_levels" => $user_levels,
            "user_status" => $user_status
          );

          return view("backend.users.createUser")->with($data);
        }else{
          return redirect("/admin")->with("error", "You do not have sufficient privileges to view this page");
        }
      }else{
        return redirect("/login")->with("error", "You do not have sufficient privileges to view this page");
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $messages = [
        'first_name.required' => "Fill in your first name",
        'surname.required' => "Fill in your surname",
        'user_profile_image.image' => "The file you have uploaded is not an image",
        'user_email.unique:users' => "Email Address already exists",
        'user_email.required' => "Please fill in your email address",
        'user_password.required' => "Please provide a password",
        'password_confirmation.required' => "Please confirm your password",
        'password_confirmation.same:user_password' => "The passwords does not match",
        'user_level.required' => "Please Select a User Level",
      ];

      $validation = $request->validate(
        [
          'first_name' => ['required', 'string', 'max:255'],
          'surname' => ['required', 'string', 'max:255'],
          'user_profile_image' => 'image|nullable|max:1999',
          'user_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'user_password' => ['required', 'string', 'min:8'],
          'password_confirmation' => ['required', 'same:user_password', 'string', 'min:8'],
          'user_level' => ['required', 'string', 'max:8'],
        ],
        $messages
        );



        if($request->hasFile('user_profile_image') && $request->file('user_profile_image')->getClientOriginalName() != USER_PROFILE_IMAGES_NO_IMAGE_FILE){

          //Get the file name with extension
          $fileNameWithExt = $request->file('user_profile_image')->getClientOriginalName();

          //Get just file name
          $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

          //Get just ext
          $extension = $request->file('user_profile_image')->getClientOriginalExtension();

          //filename to store
          $fileNameToStore = $filename . "_" . time() . ".".$extension;

          //Upload Image
          $path = $request->file('user_profile_image')->storeAs('public/images/profile_images', $fileNameToStore);
        }else{
          $fileNameToStore = USER_PROFILE_IMAGES_NO_IMAGE_FILE;
        }

        $verificationToken = sha1(uniqid($request->user_email, true) . strtotime("now"));

        // $user_level = ;

         $user =  User::create([
            'user_first_name' => $request->first_name,
            'user_surname' => $request->surname,
            'user_email' => $request->user_email,
            'user_email_verify_token' => $verificationToken,
            'email_verified_at' => NULL,
            'user_password' => Hash::make($request->user_password),
            'password_reset_token' => NULL,
            'password_reset_token_last_sent' => NULL,
            'password_last_reset' => NULL,
            'remember_token' => NULL,
            'user_profile_image' => $fileNameToStore,
            'user_level' => $request->user_level,
        ]);

        $options = array(
          "subject" => "OSC Blog: Email Verification Required"
        );

        \Mail::to($user->user_email)->send(new \App\Mail\sendEmails($user, "backend.emails.verifyEmail", "OSC Blog: Email Verification Required"));

        return redirect("admin/users/create")->with("success", "User created successfully, please ask them to check their emails for a verficiation email");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect("/admin")->with("error", "Page not found");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if(Auth::id() > 0){
        $user_id = Auth::id();
        $user_details = User::where("user_id", $user_id)->first();
        $user_levels = UserLevel::all();
        $user_status = UserStatus::all();

        if($user_details->user_admin <= 3){
          if(isset($id) && !empty($id) && $id > 0 && $user_id != $id){
            $user = User::where("user_id", $id)->first();

            $data = array(
              "page_title" => "Edit/View User",
              "user_details" => $user_details,
              "user" => $user,
              "user_levels" =>  $user_levels,
              "user_status" => $user_status
            );

            return view("backend.users.editUser")->with($data);
          }else{
            return redirect("/admin/users")->with("error", "Invalid user id submitted");
          }
        }else{
          return redirect("/admin")->with("error", "You do not have suffient priveleges to view this page");
        }
      }else{
        return redirect("/admin")->with("error", "No User Found");
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      if(isset($id) && !empty($id) && $id > 0){
        $messages = array(
          'user_current_email.required' => "Cannot find the field for the current email to switch the email with",
          'user_current_profile_image.required' => "Cannot find the field for the current email to switch the profile image with",
          'first_name.required' => "First Name is required",
          'surname.required' => "Surname is required",
          'user_email.required' => "Email Address is required",
          'user_email.unique' => "Email Address is already taken",
          'user_profile_image.image' => "The file you have uploaded is not an image",
          'user_password.required' => "Please provide a password",
          'password_confirmation.required' => "Please confirm your password",
          'password_confirmation.same:user_password' => "The passwords does not match",
        );

        if($request->user_current_email != $request->user_email){
          $emailRules = ['required', 'string', 'email', 'max:255', 'unique:users'];
        }else{
          $emailRules = ['required', 'string', 'email', 'max:255'];
        }

        $this->validate($request,[
          'user_current_email' => ['required', 'string', 'email', 'max:255'],
          'user_current_profile_image' => ['required', 'string', 'max:255'],
          'first_name' => ['required', 'string', 'max:255'],
          'surname' => ['required', 'string', 'max:255'],
          'user_email' => $emailRules,
          'user_profile_image' => 'image|nullable|max:1999'
        ], $messages);

        $user = User::where("user_id", $id)->first();

        $user->user_first_name = $request->first_name;
        $user->user_surname = $request->surname;
        if(isset($request->user_level) && !empty($request->user_level)){
          $user->user_level = $request->user_level;
        }else{
          $user->user_level = User::where('user_id', Auth::id())->first()->user_level;
        }
        if(isset($request->user_status) && !empty($request->user_status)){
          $user->user_status = $request->user_status;
        }else{
          $user->user_status = User::where('user_id', Auth::id())->first()->user_status;
        }



        if(isset($request->user_password) && !empty($request->user_password)){
          $this->validate($request,[
            'user_password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'same:user_password', 'string', 'min:8']
          ], $messages);
        }



        //Handle File Upload
        if($request->hasFile('user_profile_image')){

          //Get the file name with extension
          $fileNameWithExt = $request->file('user_profile_image')->getClientOriginalName();

          if($fileNameWithExt != USER_PROFILE_IMAGES_NO_IMAGE_FILE && $request->user_current_profile_image != USER_PROFILE_IMAGES_NO_IMAGE_FILE && file_exists('public/images/profile_images/' . $request->user_current_profile_image)){
            unlink(STORAGE_FOLDER . IMAGES_FOLDER . USER_PROFILE_IMAGES_FOLDER . "/" . $request->user_current_profile_image);
          }

          //Get just file name
          $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

          //Get just ext
          $extension = $request->file('user_profile_image')->getClientOriginalExtension();

          //filename to store
          $fileNameToStore = $filename . "_" . time() . ".".$extension;

          //Upload Image
          $path = $request->file('user_profile_image')->storeAs('public/images/profile_images', $fileNameToStore);

          //store in the db
          $user->user_profile_image = $fileNameToStore;
        }

        if($request->user_current_email != $request->user_email){
          $user->user_email = $request->user_email;
          $user->user_email_verify_token = sha1(uniqid($request->user_email, true) . strtotime("now"));;
          $user->email_verified_at = NULL;
          $user->save();
          $options = array(
            "subject" => "OSC Blog: New Email Verification Required"
          );
          \Mail::to($user->user_email)->send(new \App\Mail\sendEmails($user, "backend.emails.verifyEmail", "OSC Blog: Email Verification Required"));
          Auth::logout();
          return redirect("/admin")->with("success", "User details changed successfully, please check your email to verify the new email address");
        }else{
          $user->save();
          return redirect($request->page_redirect)->with("success", "User details changed successfully");
        }

      }else{
        return redirect("/admin")->with("error", "An invalid request was submitted");
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $softDelete = "true")
    {
      if(Auth::id() > 0){
        $current_user_id = Auth::id();
        $current_user_details = User::where('user_id', $current_user_id)->first();

        if($current_user_details->user_level <= 3){

          if(isset($id) && !empty($id)){
            $user_to_delete = User::where("user_id", $id)->first();

            if($softDelete == "true"){
              $user_to_delete->email_verified_at = NULL;
              $user_to_delete->user_deleted = date("Y-m-d H:i:s");
              $user_to_delete->user_status = "4";
              $user_to_delete->save();
            }else{
              User::destroy($id);
            }

            return redirect("/admin/users")->with("success", "User deleted successfully");
          }else{
            return redirect("/admin/users")->with("errors", "User not Found");
          }

        }else{
          return redirect("/admin")->with("error", "You do not have sufficient privileges to view this page");
        }
      }else{
        return redirect("/login");
      }
    }

    public function showAll(){
      if(Auth::id() > 0){
        $user_id = Auth::id();
        $user_details = User::where('user_id', $user_id)->first();

        if($user_details->user_level <= 3){
          $users = User::where("user_deleted", "=", NULL)->where('user_status', "<=", "3")->orderBy('user_id', 'asc')->get();
          $data = array(
            "page_title" => "View All Users",
            "user_details" => $user_details,
            "users" => $users
          );

          return view("backend.users.allUsers")->with($data);
        }else{
          return redirect("/admin")->with("error", "You do not have sufficient privileges to view this page");
        }

      }else{
        return redirect("/login");
      }

    }

    public function profile(){
      $user_id = Auth::id();

      if(isset($user_id) && !empty($user_id) && $user_id > 0){
        $user = User::where("user_id", $user_id)->first();

        if($user != null && $user->count() > 0){
          $data = array(
            "page_title" => "User Profile",
            "user_details" => $user
          );

          return view("backend.users.currentUserProfile")->with($data);
        }else{
          return redirect("/admin")->with("error", "Cannot find valid credentials to load your profile");
        }
      }else{
        return redirect("/admin")->with("error", "Cannot find valid credentials to load your profile");
      }
    }

    public function allDeleted(){
      if(Auth::id() > 0){
        $user_id = Auth::id();
        $user_details = User::where('user_id', $user_id)->first();

        if($user_details->user_level <= 3){
          $users = User::where("user_deleted", "!=", NULL)->where('user_status', "=", "4")->orderBy('user_id', 'asc')->get();
          $data = array(
            "page_title" => "View All Deleted Users",
            "user_details" => $user_details,
            "users" => $users
          );

          return view("backend.users.allDeletedUsers")->with($data);
        }else{
          return redirect("/admin")->with("error", "You do not have sufficient privileges to view this page");
        }

      }else{
        return redirect("/login");
      }
    }
}
