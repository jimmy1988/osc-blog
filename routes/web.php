<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//frontend routes
Route::get('/', 'PagesController@index')->name('pages.index');
Route::get('/post/{slug}', 'PagesController@showSingle')->name('pages.single');
Route::get('/search/{string}/{ajax}/{searchItems}', 'PagesController@searchPosts')->name('pages.search');
Route::get('/category/{id}', 'PagesController@getPostsByCategory')->name('pages.postCatgegories');

//authentication routes
Auth::routes();
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{token}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend/{id}', 'Auth\VerificationController@resend')->name('verification.resend.token');
Route::get('password/reset/{id}/{token}', 'Auth\ResetPasswordController@showPasswordResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
// Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->middleware('verified')->name('register');

//backend routes
Route::group(['middleware' => 'auth'], function () {
  //dashboard
  Route::get('/admin', 'DashController@index');

  //users routes
  Route::resource("/admin/users", "UsersController");
  Route::get("/admin/users", "UsersController@showAll");
  Route::get("/admin/user/profile", "UsersController@profile");
  Route::get("/admin/users/{id}", "UsersController@show");
  Route::delete("/admin/users/{id}/{softDelete}", "UsersController@destroy");
  Route::get("/admin/users/create", "UsersController@create");
  Route::get("/admin/user/{id}/edit", "UsersController@edit");
  Route::get("/admin/users/all/deleted", "UsersController@allDeleted");

  //posts routes
  Route::resource("/admin/posts", "PostsController");
  Route::get('/admin/user/posts', "PostsController@user");
  Route::get('/admin/post/create', "PostsController@create");
  Route::get('/admin/posts/status/{id}', "PostsController@status");
  Route::get('/admin/post/{slug}', "PostsController@show");
  Route::get('/admin/post/{id}/edit', "PostsController@edit");
  Route::post('/admin/post/preview', "PostsController@preview")->name("post.preview");

  //Tags routes
  Route::resource("/admin/tags", "TagsController");
  Route::get("/admin/tags/new", "TagsController@create");
  Route::get("/admin/tags/getAddTagSearchResults/{string}", "TagsController@addTagLiveSearch");
  Route::get("admin/tags/{tag}/delete", "TagsController@destroy")->name("tags.destroy");

  //Categories Routes
  Route::resource("/admin/categories", "CategoriesController");
  Route::get("/admin/category/new", "CategoriesController@create");
  Route::get("/admin/category/{id}/delete", "CategoriesController@destroy")->name("categories.destroy");

  //Media Routes
  Route::resource("/admin/media", "MediaController");
  Route::get("/admin/media/new", "MediaController@create");
  Route::get("/admin/media/{id}/{ajax}/edit", "MediaController@edit");
});

Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
//Test Route
// Route::get('/admin/test', "TestController@index");
