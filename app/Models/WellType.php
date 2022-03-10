<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WellType extends Model
{
  protected $table = 'wells_types';

  protected $guarded = [];

  public function wells()
  {
    return $this->hasMany('App\Well', 'wells_type_id', 'id');
  }
}
