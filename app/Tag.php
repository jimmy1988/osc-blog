<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  //Table Name
    protected $table = 'tags';
    //Primary Key
    public $primaryKey = 'tag_id';
    //Timestamps
    public $timestamps = false;

    protected $fillable = [
      'tag_name',
      'tag_created',
      'tag_last_updated',
    ];

    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'tag_created' => 'datetime',
      'tag_last_updated' => 'datetime',
    ];

    public function postTag(){
      return $this->hasMany('App\PostTag', 'tag_id', 'tag');
    }
}
