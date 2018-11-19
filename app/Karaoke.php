<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Karaoke extends Model
{
    protected $fillable = ['user_id','artist','title','memo'] ;
}
