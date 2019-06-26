<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Categories;
use App\Media;
use App\MediaType;
use App\Post;
use App\PostStatus;
use App\PostTags;
use App\Tag;
use App\User;
use App\UserLevel;
use App\UserStatus;
use App\IPAddressPost;

class PagesController extends Controller
{

    public function __construct()
    {
        // call the parents constructor method
        parent::__construct();
    }

    public function index(){

      $post_categories = Categories::all();
      $active_posts = Post::where('post_status', "=", "2")->where('featured',null)->orwhere('featured',0)->orderBy("post_category", "asc")->orderBy("post_created", "desc")->paginate(10);
      $featured_posts = Post::where('post_status', "=", "2")->where('featured', 1)->orderBy("post_category", "asc")->orderBy("post_created", "desc")->limit(5)->get();

      $data = array(
        "page_title" => "",
        "post_categories" => $post_categories,
        "active_posts" => $active_posts,
          "featured_posts" => $featured_posts
      );

      return view("frontend/pages/index")->with($data);
    }


    public function showSingle($slug = ""){
      if(isset($slug) && !empty($slug)){
        $post = Post::where("post_slug", $slug)->first();
        $post_categories = Categories::all();
        if(isset($post) && !empty($post) && $post->count() > 0){

          $views = $post->views;
          $post->views = $views+1;
          $post->save();

          $m = 0;

          if(!empty($_SERVER['HTTP_CLIENT_IP'])){
           //ip from share internet
           $ip = $_SERVER['HTTP_CLIENT_IP'];
         }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
           //ip pass from proxy
           $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
         }else{
           $ip = $_SERVER['REMOTE_ADDR'];
         }

          IPAddressPost::create([
            "ip_address" => $ip,
            'post' => $post->post_id
          ]);

          $nextArticle = Post::where('post_id', '>', $post->post_id)->where("post_status", "=", "2")->take(1)->get();

          if($nextArticle->count() <= 0){
            $nextArticle = Post::where("post_status", "=", "2")->take(1)->get();
          }

          $nextArticle = $nextArticle->all();

          $seo_tags = array();
          $keywords = array();

          //Meta tag 1 - keywords
          if(isset($post->post_category) && !empty($post->post_category) && $post->post_category > 0){
            array_push($keywords, $post->category->category);
          }

          $postTagsResult = PostTags::where("post", "=", $post->post_id)->get();
          if(isset($postTagsResult) && !empty($postTagsResult) && $postTagsResult->count() > 0){
            foreach ($postTagsResult as $postTag) {
              array_push($keywords, $postTag->postTag->tag_name);
            }
          }

          if(isset($keywords) && !empty($keywords) && count($keywords) > 0){
            $seo_tags[$m]['name'] = "keywords";
            for ($i=0; $i < count($keywords); $i++) {
              if($i>0){
                $seo_tags[$m]['content'] = $seo_tags[$m]['content'] . "," . $keywords[$i];
              }else{
                $seo_tags[$m]['content'] = $keywords[$i];
              }
            }
            $m++;
          }

          //meta tag 2 - robots
          if(isset($post->index_on_search_engines) && !empty($post->index_on_search_engines) && $post->index_on_search_engines = "1"){
            $seo_tags[$m]['name'] = "robots";
            $seo_tags[$m]['content'] = "index,";
          }else{
            $seo_tags[$m]['content'] = "no-index,";
          }
          if(isset($post->follow_links) && !empty($post->follow_links) && $post->follow_links = "1"){
            $seo_tags[$m]['content'] = $seo_tags[$m]['content'] . "follow";
          }else{
            $seo_tags[$m]['content'] = $seo_tags[$m]['content'] . "no-follow";
          }

          if(isset($seo_tags[$m]['content']) && !empty($seo_tags[$m]['content']) && count($seo_tags[$m]['content']) > 0){
            $m++;
          }

          //meta tag 3 - description
          if(isset($post->post_meta_description) && !empty($post->post_meta_description)){
            $seo_tags[$m]['name'] = "description";
            $seo_tags[$m]['content'] = $post->post_meta_description;
          }

          $data = array(
            "page_title" => $post->post_title,
            "post" => $post,
            "nextArticle" => $nextArticle,
            "post_categories" => $post_categories,
            "seo_tags" => $seo_tags
          );

          return view("frontend.pages.postSingle")->with($data);
        }else{
          return redirect("/");
        }

      }else{
        return redirect("/");
      }
    }

    public function searchPosts($string = "", $ajax = "false", $search = "all"){

      if(isset($string) && !empty($string)){

        $fullSearchResults = array();

        if($search == "all"){
          $searchItems[0] = $search;
        }else{
          $searchItems = explode(',', $search);
          for($i=0;$i<count($searchItems);$i++){
            $searchItems[$i] = trim($searchItems[$i]);
          }
        }

        $query = Post::select("posts.*")->distinct();

        if(in_array("posts", $searchItems) || in_array("all", $searchItems)){

          $query->orWhere(DB::raw("lower(posts.post_title)"), "LIKE", "%" . strtolower($string) . "%")
                ->orWhere(DB::raw("lower(posts.post_slug)"), "LIKE", "%" . strtolower($string) . "%")
                ->orWhere(DB::raw("lower(posts.post_meta_description)"), "LIKE", "%" . strtolower($string) . "%")
                ->orWhere(DB::raw("lower(posts.post_content)"), "LIKE", "%" . strtolower($string) . "%")
                ->orWhere(DB::raw("lower(posts.post_focus_keyword)"), "LIKE", "%" . strtolower($string) . "%");
        }

        if(in_array("tags", $searchItems) || in_array("all", $searchItems)){

          if($string != "Uncategorised"){
            $stringArray = explode(" ", $string);

            $query->leftJoin("post_tags", "posts.post_id", "=", "post_tags.post")
                  ->leftJoin('tags', 'post_tags.tag', "=", 'tags.tag_id');
            for($i=0; $i<count($stringArray); $i++){
              $query->orWhere(DB::raw("LOWER(tags.tag_name)"), "LIKE", "%" . trim(strtolower($stringArray[$i])) . "%");
            }

          }else{

            $allResult = DB::select(DB::raw("SELECT DISTINCT(post) FROM post_tags"));

            $id_array = array();

            foreach($allResult as $postID){
              array_push($id_array, $postID->post);
            }

            $query->leftJoin("post_tags", "posts.post_id", "=", "post_tags.post")
                  ->leftJoin('tags', 'post_tags.tag', "=", 'tags.tag_id')
                  ->whereNotIn("posts.post_id", $id_array);
          }
        }

        if(in_array("categories", $searchItems) || in_array("all", $searchItems)){

          if($string != "Uncategorised"){
            $query->leftJoin("categories", "post_category", "=", "category_id")
                  ->orWhere(DB::raw("LOWER(categories.category)"), "LIKE", "%" . strtolower($string) . "%");
          }else{
            $query->leftJoin("categories", "post_category", "=", "category_id")
                  ->orWhereNotIn("category_id", DB::raw("SELECT post_id FROM posts"));
          }

        }

        $query->where("post_status", "=", "2");
        $allResults = $query->get();

        if(isset($ajax) && !empty($ajax) && $ajax == "true"){
          return json_encode($allResults->all());
        }else{

          $post_categories = Categories::all();

          $data = array(
            "page_title" => "Search Results",
            "searchResults" => $allResults->all(),
            "post_categories" => $post_categories,
          );

          return view("frontend.pages.searchResults")->with($data);
        }
      }else{
        return false;
      }
    }

    public function getPostsByCategory($category = 0){
      if(isset($category) && !empty($category) && $category > 0){

        $category = Categories::where("category_id", "=", $category)->first();

        if(isset($category) && !empty($category) && $category->count() > 0){

          DB::enableQueryLog();

          $posts = Post::select("posts.*")
                  ->where("post_category", "=", $category->category_id)
                  ->where("post_status", "=", "2")
                  ->orderBy("post_created", "desc")
                  ->paginate(10);

        $post_categories = Categories::all();
        $title = $category->category;

          $data = array(
            "page_title" => $title,
            "category_title" => $title,
            "active_posts" => $posts,
            "post_categories" => $post_categories,
          );

          return view("frontend.pages.category")->with($data);
        }else{
          return redirect("/")->with("error", "That category is not found");
        }



      }else{
        return redirect("/")->with("error", "That category is not found");
      }
    }
}
