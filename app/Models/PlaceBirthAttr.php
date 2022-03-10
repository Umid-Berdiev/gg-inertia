<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceBirthAttr extends Model
{
  public function uz_region()
  {
    return $this->belongsTo(UzRegion::class, 'region_id', 'regionid');
  }

  public function uz_district()
  {
    return $this->belongsTo(UzDistrict::class, 'district_id', 'areaid');
  }
}
