<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WellAttr extends Model
{
  protected $table = 'wells_attrs';

  public function  uz_region()
  {
    return $this->belongsTo(UzRegion::class, 'region_id', 'regionid')->select('regionid', 'nameUz', 'nameRu');
  }

  public function  uz_district()
  {
    return $this->belongsTo(UzDistrict::class, 'district_id', 'areaid')->select('regionid', 'nameUz', 'nameRu', 'areaid');
  }
}
