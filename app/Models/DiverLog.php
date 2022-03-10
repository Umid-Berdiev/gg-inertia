<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiverLog extends Model
{
  use SoftDeletes;
  protected $guarded = [];

  public function diver()
  {
    return $this->belongsTo(Diver::class, 'diver_simcard_number', 'simcard_number');
  }

  public function well()
  {
    return $this->belongsTo(Well::class, 'well_cadasterid', 'cadaster_number');
  }
}
