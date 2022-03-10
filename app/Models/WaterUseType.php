<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterUseType extends Model
{
  protected $table = 'type_water_uses';
  protected $fillable = ['name'];

  public function  approved_plots()
  {
    return $this->belongsToMany(ApprovedPlot::class, 'approval_plot_type_water_use', 'approval_plot_id', 'type_water_use_id');
  }
}
