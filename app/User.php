<?php

namespace App;
use App\Post;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable

// class User extends Authenticatable
{
  //Table Name
    protected $table = 'users';
    //Primary Key
    public $primaryKey = 'user_id';
    //Timestamps
    public $timestamps = false;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_first_name',
        'user_surname',
        'user_email',
        'user_email_verify_token',
        'user_email_verified_at',
        'user_password',
        'password_reset_token',
        'password_reset_token_last_sent',
        'password_last_reset',
        'remember_token',
        'user_profile_image',
        'user_level',
        'user_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_email_verified_at' => 'datetime',
        'user_level' => 'integer',
        'user_status' => 'integer'
    ];

    public function getAuthPassword()
    {
        return $this->user_password;
    }

    public function media(){
        return $this->hasMany('App\Media', 'user_id', 'media_uploaded_by');
    }

    public function userLevel(){
      return $this->belongsTo('App\UserLevel', 'user_level', 'level_id');
    }

    public function userStatus(){
      return $this->belongsTo('App\UserStatus', 'user_status', 'status_id');
    }

    public function posts(){
        return $this->hasMany('App\Post', 'user_id', 'post_author');
    }
}
