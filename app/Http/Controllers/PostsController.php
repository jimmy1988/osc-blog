<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;
use App\PostStatus;
use App\Tag;
use App\PostTags;
use App\Categories;

class PostsController extends Controller
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
      if(Auth::id() > 0){
        $user_id = Auth::id();
        $user_details = User::where('user_id', $user_id)->first();

        $all_posts = Post::all();

        $data = array(
          "page_title" => "View All Posts",
          "user_details" => $user_details,
          "all_posts" => $all_posts
        );

        return view("backend.posts.viewAll")->with($data);
      }else{
        return redirect("/login");
      }
    }

    public function status($status){
      if(Auth::id() > 0){
        $user_id = Auth::id();
        $user_details = User::where('user_id', $user_id)->first();

        $post_status_result = PostStatus::where('post_status_id', $status)->get();

        foreach ($post_status_result as $statusArray) {
          $post_status = $statusArray->post_status;
        }

        $my_posts = Post::where('post_status', $status)->where('post_author', $user_id)->get();

        $data = array(
          "page_title" => "View " . ucwords($post_status) . " Posts",
          "user_details" => $user_details,
          "my_posts" => $my_posts
        );

        return view("backend.posts.viewUser")->with($data);
      }else{
        return redirect("/login");
      }
    }

    public function user(){
      if(Auth::id() > 0){
        $user_id = Auth::id();
        $user_details = User::where('user_id', $user_id)->first();

        $my_posts = Post::where('post_author', $user_id)->get();

        $data = array(
          "page_title" => "View My Posts",
          "user_details" => $user_details,
          "my_posts" => $my_posts
        );

        return view("backend.posts.viewUser")->with($data);
      }else{
        return redirect("/login");
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if(Auth::id() > 0){
        $user_id = Auth::id();

        $user_details = User::where('user_id', $user_id)->first();

        $post_statuses = PostStatus::all();

        $post_categories = Categories::all();

        $data = array(
          "page_title" => "Create Post",
          "user_details" => $user_details,
          "post_statuses" => $post_statuses,
          "post_categories" => $post_categories,
          "addMediaButton" => "true",
          "createPostButton" => "false"
        );

        return view("backend.posts.create")->with($data);
      }else{
        return redirect("/login");
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

      if($request->post_status == 2){
        $messages = array(
          'post_title.required' => "Post Title is required",
          'post_slug.required' => "Post Slug is required",
          'post_content.required' => "Post Body is required",
          //'post_banner_image.image' => "The file you have uploaded is not an banner image",
          //'post_featured_image.image' => "The file you have uploaded is not an feature image",
          'meta_description.required' => "The meta description is required",
          'post_description.required' => "The post description is required",
          'focus_keyword.required' => "The focus keywork is required",
          'post_status.required' => "The post status us required",
          'post_category.required' => "Please select a category",
          'limitfeatures' => "Number of featured posts(5) exceeded"
        );

          $this->validate($request,[
            'post_title' => 'required',
            'post_slug' => 'required',
            'post_content' => 'required',
            'post_banner_image'=> 'required|max:1999',
            'post_featured_image' => 'required|max:1999',
            'meta_description' => 'required|max:150',
            'post_description' => 'required|max:500',
            'focus_keyword' => 'required',
            'post_status' => 'required',
            'post_category' => 'required',
            'featured'=> 'limitfeatures'
          ], $messages);
        }

        if($request->input("indexOnSearchEngines") == "on"){
          $index_on_search_engines = "1";
        }else{
          $index_on_search_engines = "0";
        }

        if($request->input("followLinks") == "on"){
          $follow_links = "1";
        }else{
          $follow_links = "0";
        }

        $postExists = Post::where('post_slug', $request->input("post_slug"))->where('post_status', "=", "2")->first();

        if(!isset($postExists) || empty($postExists) || $postExists->count() <= 0){
          //create post
          $post = new Post;
          $post->post_title = $request->input("post_title");
          $post->post_slug = $request->input("post_slug");
          $post->post_description = $request->input("post_description");
          $post->post_meta_description = $request->input("meta_description");
          $post->post_content = $request->input("post_content");
          $post->post_focus_keyword = $request->input("focus_keyword");
          $post->post_featured_image = $request->input("post_featured_image");
          $post->post_banner_image = $request->input("post_banner_image");
          $post->post_author = Auth::id();
          $post->post_created = date("Y-m-d H:i:s");
          $post->post_last_updated = date("Y-m-d H:i:s");
          $post->post_status = $request->input("post_status");
          $post->post_category = $request->input("post_category");
          $post->index_on_search_engines = $index_on_search_engines;
          $post->follow_links = $follow_links;
          $post->featured = $request->input('featured');
          $post->save();

          $post_id = $post->post_id;

          if($request->input("tags_name") != null && !empty($request->input("tags_name")) && is_array($request->input("tags_name"))){
            $tags = $request->input("tags_name");
            for($i=0;$i<count($tags);$i++){
              $tagResult = Tag::where('tag_name', $tags[$i])->take(1);

              if($tagResult != null && !empty($tagResult) && $tagResult->count() <= 0){
                $tag = new Tag;
                $tag->tag_name = ucwords($tags[$i]);
                $tag->save();

                $tagid = $tag->tag_id;
              }else{
                $tagid = $tagResult->first()->tag_id;
              }

              $postTag = new PostTags;
              $postTag->tag = $tagid;
              $postTag->post = $post_id;
              $postTag->save();
            }
          }

          if($request->post_status == 2){
            return redirect('/admin')->with('success', 'Post & Tags Created and Saved');
          }else{
            return redirect('/admin/post/' . $post_id . '/edit')->with('success', 'Post Saved as Draft');
          }
      }else{
        return redirect('/admin')->with('error', 'Post already exists');
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug = "")
    {

      if(Auth::id() > 0){
        $user_id = Auth::id();

        $user_details = User::where("user_id", $user_id)->first();
        $postArray = Post::where("post_slug", $slug)->first();

        if(isset($postArray) && !empty($postArray) && $postArray->count() > 0){

          $allTags = PostTags::where('post', $postArray->post_id)->get();

          $data = array(
            "page_title" => "View Post",
            "user_details" => $user_details,
            "postArray" => $postArray,
            "allTags" => $allTags
          );

          return view("backend.posts.viewOne")->with($data);
        }else{
          return redirect("/admin/posts")->with("error", "That post was not found");
        }
      }else{
        return redirect("/login");
      }
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
        $user_details = User::where('user_id',$user_id)->first();

        if(isset($id) && !empty($id) && $id > 0){

          $currentPost = Post::where("post_id", $id)->first();
          $post_statuses = PostStatus::all();
          $post_categories = Categories::all();

          if(isset($currentPost) && !empty($currentPost) && $currentPost->count() > 0){

            $postTags = PostTags::where("post", $id)->get();

            $data = array(
              "page_title" => "Edit Post",
              "user_details" => $user_details,
              "currentPost" => $currentPost,
              "post_statuses" => $post_statuses,
              "post_categories" => $post_categories,
              "postTags" => $postTags
            );

            return view("backend.posts.edit")->with($data);
          }else{
            return redirect("/admin/posts")->with("error", "No post found");
          }

        }else{
          return redirect("/admin/posts")->with("error", "No post found");
        }

      }else{
        return redirect("/login");
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
      if($request->post_status == 2){
        $messages = array(
          'post_title.required' => "Post Title is required",
          'post_old_featured_image.required' => 'The Old Featured Image Must Not Be Missing',
          'post_slug.required' => "Post Slug is required",
          'post_content.required' => "Post Body is required",
//          'post_featured_image.image' => "The file you have uploaded is not an image",
          'meta_description.required' => "The meta description is required",
          'post_description.required' => "The post description is required",
          'focus_keyword.required' => "The focus keywork is required",
          'post_status.required' => "The post status us required",
          'post_category.required' => "Please select a category",
            'limitfeatures' => "Number of featured posts(5) exceeded"
        );

          $this->validate($request,[
            'post_title' => 'required',
            'post_slug' => 'required',
            'post_content' => 'required',
              'post_banner_image'=> 'required|max:1999',
              'post_featured_image' => 'required|max:1999',
            'meta_description' => 'required|max:150',
            'post_description' => 'required|max:500',
            'focus_keyword' => 'required',
            'post_status' => 'required',
            'post_category' => 'required',
            'featured'=> 'limitfeatures'
          ], $messages);
      }

          if($request->input("indexOnSearchEngines") == "on"){
            $index_on_search_engines = "1";
          }else{
            $index_on_search_engines = "0";
          }

          if($request->input("followLinks") == "on"){
            $follow_links = "1";
          }else{
            $follow_links = "0";
          }

          $post = Post::where('post_id', $id)->first();

          if(isset($post) && !empty($post) && $post->count() >0){
              $post->post_featured_image = $request->input("post_featured_image");
              $post->post_banner_image = $request->input("post_banner_image");

            $post->post_title = $request->post_title;
            $post->post_slug = $request->post_slug;
            $post->post_description = $request->post_description;
            $post->post_meta_description = $request->meta_description;
            $post->post_content = $request->post_content;
            $post->post_focus_keyword = $request->focus_keyword;
            $post->post_last_updated = date("Y-m-d H:i:s");
            $post->post_status = $request->post_status;
            $post->post_category = $request->post_category;
            $post->index_on_search_engines = $index_on_search_engines;
            $post->follow_links = $follow_links;
            $post->featured = $request->featured;
            $post->save();

            if($request->input("tags_name") != null && !empty($request->input("tags_name")) && is_array($request->input("tags_name"))){
              $tags = $request->input("tags_name");
              for($i=0;$i<count($tags);$i++){
                $tagResult = Tag::where('tag_name', $tags[$i])->take(1);

                if($tagResult != null && !empty($tagResult) && $tagResult->count() <= 0){
                  $tag = new Tag;
                  $tag->tag_name = $tags[$i];
                  $tag->save();

                  $tagid = $tag->tag_id;
                }else{
                  $tagid = $tagResult->first()->tag_id;
                }

                $postTag = new PostTags;
                $postTag->tag = $tagid;
                $postTag->post = $id;
                $postTag->save();
              }
            }

            if($request->post_status == 2){
              return redirect('/admin/post/' . $id . "/edit")->with('success', 'Post & Tags Updated, Created and Saved Successfully');
            }else{
              return redirect('/admin/post/' . $id . "/edit")->with('success', 'Post & Tags Updated, Created and Saved as a Draft');
            }

        }else{
          return redirect('/admin')->with('error', 'Post does not exist');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
      if(Auth::id() > 0){
        $user_id = Auth::id();
        $user_details = User::where('user_id', $user_id)->first();

        if(isset($user_details) && !empty($user_details) && $user_details->count() > 0){

          if(isset($request->redirect) && !empty($request->redirect)){
            $redirect = $request->redirect;
          }else{
            $redirect = "/admin";
          }

          if(isset($id) && !empty($id) && $id > 0){

            $post = Post::where("post_id", $id)->first();

            if(isset($post) && !empty($post) && $post->count() > 0){
              if(isset($post->post_featured_image) && !empty($post->post_featured_image) && file_exists( $user_details->post_featured_image)){
                unlink( $post->post_featured_image);
              }

              Post::destroy($id);
              return redirect($redirect)->with("success", "Post deleted successfully");
            }else{
              return redirect($redirect)->with("error", "Post record not found");
            }
          }else{
            return redirect($redirect)->with("error", "Post id not set");
          }


        }else{
          return redirect("/admin")->with("error", "No user detected");
        }

      }else{
        return redirect("/admin")->with("error", "No user detected");
      }

    }

    public function preview(Request $request){

        if(Auth::id() > 0){
          $user_id = Auth::id();

          $user_details = User::where('user_id', $user_id)->first();

          $post_statuses = PostStatus::all();

          $post_categories = Categories::all();

          if($request->hasFile('post_featured_image')){

            //Get the file name with extension
            $fileNameWithExt = $request->file('post_featured_image')->getClientOriginalName();

            //Get just file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //Get just ext
            $extension = $request->file('post_featured_image')->getClientOriginalExtension();

            //filename to store
            $fileNameToStore = $filename . "." .$extension;

            $pathToStore = str_replace("storage", "public", $this->userContainingTempDir . "/" . Auth::id());

            if(!file_exists($pathToStore . $fileNameToStore)){
              $request->file('post_featured_image')->storeAs($pathToStore, $fileNameToStore);
              $imageTempPath = "/" . $pathToStore . "/" . $fileNameToStore;
            }

            $imageTempPath = STORAGE_FOLDER . TEMP_FOLDER . USERS_TEMP_FOLDER . "/" . Auth::id() . "/" . $fileNameToStore;

          }elseif(isset($request->post_old_featured_image) && !empty($request->post_old_featured_image)){
            $imageTempPath = $request->post_old_featured_image;
          }else{
            $imageTempPath = STORAGE_FOLDER . IMAGES_FOLDER . POST_IMAGES_FOLDER . "/" . POST_IMAGES_NO_IMAGE_FILE;
          }

          $data = array(
            "page_title" => "Preview Post",
            "user_details" => $user_details,
            "addMediaButton" => "false",
            "createPostButton" => "false",
            "post_statuses" => $post_statuses->all(),
            "post_categories" => $post_categories->all(),
            "postPreview" => array_merge($request->all(), $user_details->toArray()),
            "imageTempPath" => $imageTempPath,
            "postView" => "true",
            "adminPanel" => "true"
          );

          return view("frontend.pages.postSingle")->with($data);
        }else{
          return redirect("/admin/post/create")->with("error", "No post to preview");
        }
    }
}
