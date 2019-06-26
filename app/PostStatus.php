<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostStatus extends Model
{
  //Table Name
  protected $table = 'post_status';
  //Primary Key
  public $primaryKey = 'post_status_id';
  //Timestamps
  public $timestamps = false;

  protected $fillable = [
    "post_status",
    "post_status_created_at",
    "post_status_updated_at",
  ];

  protected $hidden = [

  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    "post_status_created_at" => "datetime",
    "post_status_updated_at" => "datetime",
  ];
}
