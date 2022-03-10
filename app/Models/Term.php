<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{

  protected $guarded = [];
  protected $table = 'metkis';

  public function language()
  {
    return $this->belongsTo(App\language::class, 'group_id');
  }
}
