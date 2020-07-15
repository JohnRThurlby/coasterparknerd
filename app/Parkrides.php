<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parkrides extends Model
{
     protected $fillable = [

     'parkid','ridename', 'rideduration', 'rideopened', 'ridespeed', 'ridelevel', 'ridelength', 'ridehgtreq', 'ridetype', 'rideurl',
     'ridemanu', 'parkarea', 'rideoccup', 'ridehgt', 'ridevehtype'
      
  ];

  public $timestamps = false;

  }
