<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroundWaterLevel extends Model
{
  use HasFactory;

  protected $guarded = [];

  /**
   * Get the well that owns the GroundWaterLevel
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function well()
  {
    return $this->belongsTo(Well::class, 'well_cadaster_number', 'cadaster_number')->select('id', 'cadaster_number');
  }
}
