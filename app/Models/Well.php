<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Well extends Model
{
  protected $table = 'wells';

  protected $casts = [
    'static_level' => 'double'
  ];

  protected $guarded = [];

  public function well_attrs()
  {
    return $this->hasMany(WellAttr::class, 'wells_id')->with('uz_region', 'uz_district');
  }

  public function place_birth()
  {
    return $this->belongsTo(PlaceBirth::class, 'pv_field_id', 'id')->select('id', 'name');
  }

  public function uroven_vodies()
  {
    return $this->hasMany(Dannye::class, 'skvajina_id')->orderBy('year', 'DESC');
  }

  public function rasxod_vodies()
  {
    return $this->hasMany(RasxodVody::class, 'skvajina_id')->orderBy('year', 'DESC');
  }

  public function ximsostav_vodies()
  {
    return $this->hasMany(ChemicalComposition::class, 'skvajina_id')->orderBy('year', 'DESC');
  }

  public function well_type()
  {
    return $this->belongsTo(WellType::class, 'wells_type_id', 'id');
  }

  public function intended()
  {
    return $this->belongsTo(Intended::class, 'intended_id', 'id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function diver()
  {
    return $this->hasOne(Diver::class, 'well_cadasterid', 'cadaster_number')->select('id', 'simcard_number', 'well_cadasterid');
  }

  public function diver_logs()
  {
    return $this->hasMany(DiverLog::class, 'well_cadasterid', 'cadaster_number');
  }

  /**
   * Get all of the ground_water_levels for the Well
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function ground_water_levels()
  {
    return $this->hasMany(GroundWaterLevel::class, 'well_cadaster_number', 'cadaster_number');
  }

  public function region()
  {
    return $this->hasOneThrough(
      UzRegion::class,
      WellAttr::class,
      'wells_id', // Foreign key on the wells_attrs table...
      'regioncode', // Foreign key on the regions table...
      'id', // Local key on the wells table...
      'region_id' // Local key on the well_attrs table...
    );
  }
}
