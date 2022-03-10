<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Reservoirs_attr extends Model
{
  public function  uz_regions()
  {
    return $this->belongsTo(UzRegion::class, 'region_id', 'regionid');
  }

  public function  uz_districts()
  {
    return $this->belongsTo(UzDistrict::class, 'district_id', 'areaid');
  }
}
