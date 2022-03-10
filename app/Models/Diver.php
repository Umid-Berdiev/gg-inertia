<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diver extends Model
{
  use SoftDeletes;
  protected $guarded = [];

  public function well()
  {
    return $this->belongsTo(Well::class, 'well_cadasterid', 'cadaster_number');
  }

  public function diver_logs()
  {
    return $this->hasMany(DiverLog::class, 'diver_simcard_number', 'simcard_number');
  }
}
