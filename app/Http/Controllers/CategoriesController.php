<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\User;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
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
    public function index()
    {
        $user_id = Auth::id();

        if(isset($user_id) && !empty($user_id) && $user_id > 0){
          $user_details = User::where("user_id", $user_id)->first();

          if($user_details->user_level <= 3){

            $categories = Categories::orderBy("category_id", "desc")->get();

            $data = array(
              "page_title" => "All Categories",
              "user_details" => $user_details,
              "categories" => $categories
            );

            return view("backend.categories.allCategories")->with($data);
          }else{
            return redirect("/admin")->with("error", "You are not authorised to view this page");
          }
        }else{
          return redirect("/login")->with("error", "You are not authorised to view this page");
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

        if($user_details->user_level <= 3){

          for($i=0;$i<count($request->category_name);$i++){
            $category = Categories::where("category", "=", $request->category_name[$i]);

            if(!isset($category) || empty($category) || $category->count() <= 0){
              Categories::create(array("category" => ucwords($request->category_name[$i])));
            }
          }


          return redirect("/admin/categories")->with("success", "Categories added successfully");
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
    public function update(Request $request, $id = "0")
    {

      $user_id = Auth::id();

      if(isset($user_id) && !empty($user_id) && $user_id > 0){
        $user_details = User::where("user_id", $user_id)->first();

        if($user_details->user_level <= 3){

          for($i=0;$i<count($request->category);$i++){
            foreach($request->category[$i] as $id => $value){
              $category = Categories::where("category_id", $id)->first();

              $category->category = ucwords($value);
              $category->save();
            }
          }

          return redirect("/admin/categories")->with("success", "Categories updated successfully");

        }else{
          return redirect("/admin")->with("error", "You are not authorised to view this page");
        }

      }else{
        return redirect("/login")->with("error", "You are not authorised to view this page");
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
          Categories::destroy($id);

          return redirect("/admin/categories")->with("success", "Category deleted successfully");
        }else{
          return redirect("/admin")->with("error", "You are not authorised to view this page");
        }

      }else{
        return redirect("/login")->with("error", "You are not authorised to view this page");
      }

    }
}
