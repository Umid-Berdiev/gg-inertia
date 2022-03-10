<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MountainRange extends Model
{
  public $fillable = [
    'id',
    'code',
    'name',
    'comment',
    'year'
  ];

  public function MountainRangeAttr()
  {
    return $this->hasMany(MountainRangeAttr::class)->with('uz_districts');
  }
}
