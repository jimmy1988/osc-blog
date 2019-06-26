<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaType extends Model
{
  //Table Name
    protected $table = 'media_types';
    //Primary Key
    public $primaryKey = 'media_type';
    //Timestamps
    public $timestamps = false;

    protected $fillable = [
      'media_type'
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

    public function media(){
      return $this->hasMany('App\Media', 'media_tyoe_id', 'media_type');
    }
}
