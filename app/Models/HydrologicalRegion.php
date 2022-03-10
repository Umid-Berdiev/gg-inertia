<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HydrologicalRegion extends Model
{
  public function pools()
  {
    return $this->belongsTo(Pool::class, 'pool_id', 'id');
  }
}
