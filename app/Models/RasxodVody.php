<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RasxodVody extends Model
{
  protected $guarded = [];

  protected $casts = [
    'january' => 'double',
    'february' => 'double',
    'march' => 'double',
    'april' => 'double',
    'may' => 'double',
    'june' => 'double',
    'july' => 'double',
    'august' => 'double',
    'september' => 'double',
    'october' => 'double',
    'november' => 'double',
    'december' => 'double',
  ];

  public function well()
  {
    return $this->belongsTo(Well::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}
