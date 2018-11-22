<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = ['artist_id' , 'name'];

    function Details(){
      return $this->hasMany('App\SongDetail');
    }

    function Categories(){
      return $this->hasMany('App\Category');
    }

    function Artist(){
      return $this->belongsTo('App\Artist');
    }
}
