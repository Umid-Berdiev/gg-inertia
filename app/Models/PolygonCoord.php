<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolygonCoord extends Model
{
  protected $guarded = [];
  protected $table = 'polygon_coords';

  public function place_birth()
  {
    return $this->belongsTo(PlaceBirth::class, 'place_birth_code', 'code');
  }
}
