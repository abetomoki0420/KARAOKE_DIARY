<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name'];

    function Artists(){
      return $this->hasMany('App\Artist');
    }

    function Songs(){
      return $this->hasMany('App\Song');
    }
}
