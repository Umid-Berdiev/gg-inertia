<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceBirth extends Model
{
  protected $guarded = [];

  public function place_birth_attrs()
  {
    return $this->hasMany(PlaceBirthAttr::class)->with('uz_region', 'uz_district');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function wells()
  {
    return $this->hasMany(Well::class, 'pv_field_id');
  }

  public function waterIntakes()
  {
    return $this->hasMany(WaterIntake::class, 'birth_place_id');
  }

  public function polygon_coords()
  {
    return $this->hasMany(PolygonCoord::class, 'place_birth_code', 'code');
  }
}
