<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class TypeServicies extends Model
{
  use SoftDeletes, Sortable;

  public $sortable = [
    'name',
  ];
}
