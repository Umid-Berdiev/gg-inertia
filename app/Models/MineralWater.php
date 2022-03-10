<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MineralWater extends Model
{
  protected $guarded = [];

  protected $table = 'mineral_waters';

  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  public function updatedBy()
  {
    return $this->belongsTo(User::class, 'updated_by');
  }

  public function region()
  {
    return $this->belongsTo(UzRegion::class, 'region_id', 'regionid');
  }

  public function district()
  {
    return $this->belongsTo(UzDistrict::class, 'district_id', 'areaid');
  }
}
