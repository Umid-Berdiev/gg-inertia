<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Information;

class ReservoirForms extends Model
{
  protected $fillable = ['order_number', 'check', 'year', 'gvk_object_id'];

  public function object(): BelongsTo
  {
    return $this->belongsTo('App\GvkObject', 'gvk_object_id', 'id')->orderBy('number');
  }

  public function objects(): HasMany
  {
    return $this->hasMany(GvkObject::class, 'id', 'gvk_object_id');
  }
}
