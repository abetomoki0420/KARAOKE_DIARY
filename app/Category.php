<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['song_id' , 'name'];

    function Song(){
      return $this->belongsTo('App\Song');
    }
}
