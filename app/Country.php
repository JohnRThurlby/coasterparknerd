<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    
  public function parks()
     {

       return $this->hasMany('App\Parks');

     }
 
}
