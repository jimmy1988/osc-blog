<?php

namespace App;
use App\User;
use App\IPAddressPost;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  //Table Name
  protected $table = 'posts';
  //Primary Key
  public $primaryKey = 'post_id';
  //Timestamps
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'post_title',
    'post_slug',
    'post_meta_description',
    'post_content',
    'post_focus_keyword',
    'post_featured_image',
    'post_author',
    'post_created',
    'post_last_updated',
    'post_status',
    'post_category',
    'index_on_search_engines	',
    'follow_links',
    'views'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [

  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'post_author' => 'integer',
    'post_slug' => 'string',
    'post_created' => 'datetime',
    'post_last_updated' => 'datetime',
    'post_status' => 'integer',
    'post_category' => 'integer',
    'index_on_search_engines' => 'integer',
    'follow_links' => 'integer',
    'views' => 'integer',
  ];

  public function post(){
    return $this->belongsTo('App\IPAddressPost', 'post_id', 'post');
  }

  public function postTag(){
    return $this->hasMany('App\PostTag', 'post_id', 'post');
  }

  public function category(){
    return $this->belongsTo('App\Categories', 'post_category', 'category_id');
  }

  public function user(){
    return $this->belongsTo('App\User', 'post_author', 'user_id');
  }
}
