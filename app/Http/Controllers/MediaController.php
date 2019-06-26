<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Media;
use App\MediaType;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
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
        $media = Media::orderBy("created_at", "desc")->get();

        $data = array(
          "page_title" => "Media",
          "user_details" => $user_details,
          "media" => $media,
          "addMediaButton" => "false",
          "createPostButton" => "true"
        );

        return view("backend.media.allMedia")->with($data);
      }else{
        return redirect("/login")->with("error", "You do not have sufficient privileges to view this page");
      }
    }

    public function edit($id, $ajax = false){

      if(gettype($ajax) == "string" && $ajax == "1"){
        $user_id = Auth::id();

        if(isset($user_id) && !empty($user_id) && $user_id > 0){
          $user_details = User::where("user_id", $user_id)->first();
          if(isset($id) && !empty($id) && $id > 0){
            $media = Media::where("media_id", $id)->first();

            if(isset($media) && !empty($media) && $media->count() > 0){
              return json_encode($media);
            }else{
              exit;
            }

          }else{
            exit;
          }
        }else{
          exit;
        }
      }else{
        exit;
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
        if($request->hasFile('file') && $request->file('file')->getClientOriginalName() != USER_PROFILE_IMAGES_NO_IMAGE_FILE){

          //Get the file name with extension
          $fileNameWithExt = $request->file('file')->getClientOriginalName();

          //Get just file name
          $filename = urlencode(pathinfo($fileNameWithExt, PATHINFO_FILENAME));

          //Get just ext
          $extension = $request->file('file')->getClientOriginalExtension();

          $media_type = "1";

          $mime_type = $request->file('file')->getMimeType();

          //filename to store
          $fileNameToStore = $filename . "_" . date("Y") . "_" . date("m") . "_" . date("d") . "_" . date("H") . "_" . date("i") . "_" . date("s") . "." . $extension;

          $mediaExists = Media::where("media_file_name", "=", $fileNameToStore)->first();

          $media = new Media;
          $media->media_title = $filename;
          $media->media_file_name = $fileNameToStore;
          $media->media_file_type = $mime_type;
          $media->media_file_extension = $extension;
          $media->media_type = $media_type;
          $media->media_alt_text = $filename;
          $media->media_uploaded_by = $user_id;

          if(!isset($mediaExists) || empty($mediaExists) || $mediaExists->count() <= 0){
            //Upload Image
            $path = $request->file('file')->storeAs('public/images/media_items', $fileNameToStore);

            $media->save();
            $media->index = $request->index;
            $media->media_description = "";
            $media->user_first_name = $user_details->user_first_name;
            $media->user_surname = $user_details->user_surname;

            $output = json_encode($media);

            return $output;
          }else{

            $media->index = $request->index;
            $media->media_description = "";
            $media->user_first_name = $user_details->user_first_name;
            $media->user_surname = $user_details->user_surname;

            $output = json_encode($media);
            return $output;
          }
        }
      }else{
        return false;
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
      $user_id = Auth::id();

      if(isset($user_id) && !empty($user_id) && $user_id > 0){

        $media = Media::where("media_id", $id)->first();
        $media->media_alt_text = $request->alt_text;
        $media->media_description = $request->meta_description;
        $media->save();

        return redirect("/admin/media")->with("success", "Media item updated successfully");
      }else{
        return redirect("/admin/media")->with("error", "You are not authorised to access this page");
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
          $media = Media::where("media_id", $id)->first();

          if(isset($media) && !empty($media) && $media->count() > 0){
            Storage::delete(PUBLIC_FOLDER . IMAGES_FOLDER . MEDIA_ITEMS_FOLDER . "/" . $media->media_file_name);
            Media::destroy($id);
            return redirect("/admin/media");
          }else{
            return redirect("/admin/media")->with("error", "No media item found by that id");
          }
        }else {
          return redirect("/login")->with("error", "You do not have sufficient privileges to view this page");
        }

    }
}
