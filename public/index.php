<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

// phpinfo();
// die();

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
/*if(isset($_SERVER['SERVER_NAME']) && !empty($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == "oscblog.local" || $_SERVER['SERVER_NAME'] == "osc-blog.local"){
  define('ENVIRONMENT', "development");
}elseif(isset($_SERVER['SERVER_NAME']) && !empty($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == "192.168.0.99"){
  define('ENVIRONMENT', "testing");
}elseif(isset($_SERVER['SERVER_NAME']) && !empty($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != "oscblog.local"){
  define('ENVIRONMENT', "live");
}else{
  define('ENVIRONMENT', "testing");
}

if(defined("ENVIRONMENT") && ENVIRONMENT == "development"){
  require __DIR__.'/../vendor/autoload.php';
  $app = require_once __DIR__.'/../bootstrap/app.php';
}elseif(defined("ENVIRONMENT") && ENVIRONMENT == "testing"){
  // echo __DIR__;
  // echo "<br /><br />";
  // echo __DIR__.'/../vendor/autoload.php';
  // echo "<br /><br />";
  // echo file_exists(__DIR__.'/../vendor/autoload.php') ? "file exists" : "file does not exist";
  require __DIR__.'/../vendor/autoload.php';
  // $app = require_once __DIR__.'/../bootstrap/app.php';
}elseif(defined("ENVIRONMENT") && ENVIRONMENT == "live"){

}else{
  require __DIR__.'/../vendor/autoload.php';
  $app = require_once __DIR__.'/../bootstrap/app.php';
}
*/
/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
