<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SongDetail extends Model
{
  protected $fillable = ['artist_id' , 'song_id', 'score' , 'comment'];

  function Song(){
    return $this->belongsTo('App\Song');
  }
}
