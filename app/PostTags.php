<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTags extends Model
{
  //Table Name
  protected $table = 'post_tags';
  //Primary Key
  public $primaryKey = 'posts_id';
  //Timestamps
  public $timestamps = false;

  protected $fillable = [
    "tag",
    "post",
    "post_tag_created_at",
    "post_tag_updated_at",
  ];

  protected $hidden = [

  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    "tag" => "integer",
    "post" => "integer",
    "post_tag_created_at" => "datetime",
    "post_tag_updated_at" => "datetime",
  ];

  public function postTag(){
    return $this->belongsTo('App\Tag', 'tag', 'tag_id');
  }

  public function post(){
    return $this->belongsTo('App\Post', 'post', 'post_id');
  }

}
