<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parks extends Model
{
    
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [

      'parkname', 'parkphone', 'parkaddress1', 'parkcity', 'parkstate', 'parkzip', 'parkurl', 'parklat', 'parklon', 'parkpic', 'countryid'
      
  ];

  public $timestamps = false;
 
}
