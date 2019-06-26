<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
  //Table Name
    protected $table = 'categories';
    //Primary Key
    public $primaryKey = 'category_id';
    //Timestamps
    public $timestamps = false;

    protected $fillable = [
      'category'
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

    public function post(){
      return $this->hasMany('App\Post', 'category_id', 'post_category');
    }
}
