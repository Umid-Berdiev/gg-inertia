<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, HasRoles;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function level()
  {
    return $this->belongsTo(Level::class, 'level_id', 'id');
  }

  public function user_attrs()
  {
    return $this->hasMany(UserAttr::class, 'user_id');
  }

  public function getFullname()
  {
    return $this->lastname . ' ' . $this->firstname . ' ' . $this->middlename;
  }

  public function region()
  {
    return $this->belongsTo(UzRegion::class, 'region_id', 'regioncode');
  }

  public function waterlevels()
  {
    return $this->hasMany(Waterlevel::class);
  }
}
