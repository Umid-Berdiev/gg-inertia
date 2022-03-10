<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
  protected $guarded = [];

  /**
   * Get all of the terms for the Language
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function terms()
  {
    return $this->hasMany(Term::class, 'group_id', 'id');
  }
}
