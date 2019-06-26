<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Post;

class IPAddressPost extends Model
{
  //Table Name
  protected $table = 'ip_address_post';
  //Primary Key
  public $primaryKey = 'ip_address_post_id';
  //Timestamps
  public $timestamps = false;

  protected $fillable = [
    'ip_address',
    'post'
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
    'ip_address' => "string",
    'post' => "integer"
  ];

  public function post(){
    return $this->belongsTo('App\Post', 'post', 'post_id');
  }
}
