<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovedPlot extends Model
{
  protected $table = 'approval_plots';

  protected $guarded =  [];

  public function ap_attrs()
  {
    return $this->hasMany(ApprovedPlotAttr::class, 'approval_plots_id')->with('uz_region', 'uz_district');
  }

  public function type_water_uses()
  {
    return $this->belongsToMany(WaterUseType::class, 'approval_plot_type_water_use', 'approval_plot_id', 'type_water_use_id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function place_birth()
  {
    return $this->belongsTo(PlaceBirth::class, 'birth_place_id', 'id')->select(['id', 'name'])->with('place_birth_attrs');
  }
}
