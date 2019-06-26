<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $arr_ip;
    protected $jsonIPArray;
    protected $userContainingTempDir;
    protected $userTempDir;
    protected $currentUser;

    public function __construct(){

      $this->userContainingTempDir = substr(STORAGE_FOLDER, 1) . TEMP_FOLDER . USERS_TEMP_FOLDER;
      if(!is_dir($this->userContainingTempDir)){
        $this->userContainingTempDir = STORAGE_FOLDER . TEMP_FOLDER . USERS_TEMP_FOLDER;

        if(!is_dir($this->userContainingTempDir)){
          $this->userContainingTempDir = false;
        }
      }

      $user_id = Auth::id();

      if(isset($user_id) && !empty($user_id) && $user_id > 0){

        $this->userTempDir = $this->userContainingTempDir . "/" . $user_id;

      }else{

        // $this->userTempDir = false;
        //
        // $this->arr_ip= (array) geoip()->getLocation($_SERVER['REMOTE_ADDR']);
        //
        //  $jsonArray = array();
        //  foreach($this->arr_ip as $innerArray){
        //    foreach($innerArray as $field => $value){
        //      $jsonArray[$field] = $value;
        //    }
        //    break;
        //  }
        //
        // $this->jsonIPArray = json_encode($jsonArray);
      }
    }
}
