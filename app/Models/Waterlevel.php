<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waterlevel extends Model
{
  protected $table = "dannyes";
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
    return $this->belongsTo(Well::class, 'skvajina_id')->select('id', 'cadaster_number', 'number_auther');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id')->select('id', 'firstname', 'lastname');
  }

  public function min()
  {
    $data = [
      $this->january,
      $this->february,
      $this->march,
      $this->aprel,
      $this->may,
      $this->june,
      $this->july,
      $this->august,
      $this->september,
      $this->october,
      $this->november,
      $this->december,
    ];

    return collect($data)->min();
  }

  public function max()
  {
    $data = [
      $this->january,
      $this->february,
      $this->march,
      $this->aprel,
      $this->may,
      $this->june,
      $this->july,
      $this->august,
      $this->september,
      $this->october,
      $this->november,
      $this->december,
    ];

    return collect($data)->max();
  }

  public function average()
  {
    $data = [
      $this->january,
      $this->february,
      $this->march,
      $this->aprel,
      $this->may,
      $this->june,
      $this->july,
      $this->august,
      $this->september,
      $this->october,
      $this->november,
      $this->december,
    ];

    return collect($data)->average();
  }
}
