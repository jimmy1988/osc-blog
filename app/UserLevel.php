<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
  //Table Name
    protected $table = 'user_levels';
    //Primary Key
    public $primaryKey = 'level_id';
    //Timestamps
    public $timestamps = false;

    protected $fillable = [
      'level',
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
      return $this->hasMany('App\User', 'level_id', 'user_level');
    }


}
