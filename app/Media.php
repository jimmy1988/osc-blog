<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
  //Table Name
    protected $table = 'media';
    //Primary Key
    public $primaryKey = 'media_id';
    //Timestamps
    public $timestamps = true;

    protected $fillable = [
      'media_title',
      'media_file_name',
      'media_file_type',
      'media_file_extension',
      'media_type',
      'media_alt_text',
      'media_description',
      'media_uploaded_by'
    ];

    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'media_type'=> 'integer',
      'media_uploaded_by' => 'integer',
      'media_description' => 'string'
    ];

    public function user(){
      return $this->belongsTo('App\User', 'media_uploaded_by', 'user_id');
    }

    public function mediaType(){
      return $this->belongsTo('App\mediaType', 'media_type', 'media_type_id');
    }
}
