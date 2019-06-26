<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\User;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
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
    public function index(){

      $user_id = Auth::id();

      if(isset($user_id) && !empty($user_id) && $user_id > 0){
        $user_details = User::where("user_id", $user_id)->first();
        $tags = Tag::orderBy('tag_id', "desc")->get();

        if($user_details->user_level <= "3"){
          $data = array(
            "page_title" => "All Tags",
            "user_details" => $user_details,
            "tags" => $tags
          );

          return view("backend.tags.allTags")->with($data);
        }else{
          return redirect("/admin")->with("error", "You are not authorised to view this page");
        }
      }else{
        return redirect("/login")->with("error", "You are not logged in to view this page");
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

        $user_id = Auth::id();

        if(isset($user_id) && !empty($user_id) && $user_id > 0){
          $user_details = User::where("user_id", $user_id)->first();

          if($user_details->user_level <= "3"){

            for($i=0; $i<count($request->tags_name);$i++){
              $tagFind = Tag::where("tag_name", "=", $request->tags_name[$i]);
              if($tagFind->count()<=1){
                Tag::create(array('tag_name' => ucwords($request->tags_name[$i])));
              }
            }

            return redirect("/admin/tags")->with("success", "Tags added successfully");
          }else{
            return redirect("/admin")->with("error", "You are not authorised to view this page");
          }
        }else{
          return redirect("/login")->with("error", "You are not authorised to view this page");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = 0)
    {

        $user_id = Auth::id();

        if(isset($user_id) && !empty($user_id) && $user_id > 0){
          $user_details = User::where("user_id", $user_id)->first();

          if($user_details->user_level <= 3){

            for($i=0;$i<count($request->tags); $i++){
              foreach($request->tags[$i] as $id => $value)
              $tag = Tag::where("tag_id", $id)->first();
              $tag->tag_name = ucwords($value);
              $tag->save();
            }

            return redirect("/admin/tags")->with("success", "Tags updated successfully");
          }else{
            return redirect("admin")->with("error", "You are not authorised to view this page");
          }
        }else{
          return redirect("login")->with("error", "You are not authorised to view this page");
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = Auth::id();

        if(isset($user_id) && !empty($user_id) && $user_id > 0){
          $user_details = User::where("user_id", $user_id)->first();
          if($user_details->user_level <= 3){
            if(isset($id) && !empty($id) && $id > 0){
              Tag::destroy($id);
              return redirect("/admin/tags/")->with("success", "Tag deleted successfully");
            }else{
              return redirect("/admin")->with("error", "A valid ID is not set");
            }

          }else{
            return redirect("/admin")->with("error", "You are not authorised to view this page");
          }
        }else{
          return redirect("/login")->with("error", "You are not authorised to view this page");
        }


    }

    public function addTagLiveSearch($string){

      if(isset($string) && !empty($string)){
        $string = ucwords($string);

        $tags = Tag::where('tag_name', "LIKE", "%{$string}%")->get();

        if(isset($tags) && !empty($tags) && $tags->count() > 0){
          echo json_encode($tags->all());
        }else{
          echo "No Results Found";
        }
      }else{
        return false;
      }

    }
}
