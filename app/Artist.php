<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $fillable = ['user_id' , 'name'];

    function User(){
      return $this->belongsTo('App\User');
    }

    function Songs(){
      return $this->hasMany('App\Song');
    }
}
