<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;
use App\Post;

class DashController extends Controller
{
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $user_id = Auth::id();
      if($user_id > "0"){
        $user_id = Auth::id();
        $user_details = User::where("user_id", $user_id)->first();
        $all_posts = Post::orderBy('featured','desc')->paginate(10);
        $total_views = Post::all()->sum('views');
        $most_viewed = Post::orderBy("views", "desc")->orderBy("post_id", "desc")->first();
        $my_posts = Post::where("post_author", Auth::id())->get();

        $data = array(
          "page_title" => "Dashboard",
          "user_details" => $user_details,
          "all_posts" => $all_posts,
          "total_views" => $total_views,
          "most_viewed" => $most_viewed,
          "my_posts" =>$my_posts
        );

        return view("backend.pages.dash")->with($data);
      }else{
        return redirect("/login");
      }
    }
}
