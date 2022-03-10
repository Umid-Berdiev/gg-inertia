<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterIntake extends Model
{
  protected $table = 'water_collecctions';

  protected $guarded = [];

  public function water_intake_attrs()
  {
    return $this->hasMany(WaterIntakeAttr::class, 'water_collections_id')->with('uz_region', 'uz_district');
  }

  public function water_use_type()
  {
    return $this->belongsTo(WaterUseType::class, 'type_water_use_id', 'id');
  }

  public function water_intake_type()
  {
    return $this->belongsTo(WaterIntakeType::class, 'type_water_intakes_id', 'id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function place_birth()
  {
    return $this->belongsTo(PlaceBirth::class, 'birth_place_id', 'id')->with('place_birth_attrs');
  }
}
