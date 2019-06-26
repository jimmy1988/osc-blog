<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
  //Table Name
    protected $table = 'user_status';
    //Primary Key
    public $primaryKey = 'status_id';
    //Timestamps
    public $timestamps = false;

    protected $fillable = [
      'status',
    ];

    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      
    ];

    public function user(){
      return $this->hasMany('App\User', 'status_id', 'user_status');
    }
}
