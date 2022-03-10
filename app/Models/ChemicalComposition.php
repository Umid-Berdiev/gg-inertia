<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChemicalComposition extends Model
{
  protected $table = "ximsostav_vodies";
  protected $guarded = [];

  protected $casts = [
    'CO3' => 'float',
    'HCO3' => 'float',
    'CI' => 'float',
    'SO4' => 'float',
    'NO3' => 'float',
    'NO2' => 'float',
    'Ca' => 'float',
    'Mg' => 'float',
    'Na' => 'float',
    'K' => 'float',
    'Fe+2' => 'float',
    'NH4' => 'float',
  ];

  public function well()
  {
    return $this->belongsTo(Well::class)->where('isDeleted', false)->select('id', 'cadaster_number', 'number_auther', 'location');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id')->select('id', 'firstname', 'lastname');
  }
}
