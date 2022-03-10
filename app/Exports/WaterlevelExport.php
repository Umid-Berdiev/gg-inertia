<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class WaterlevelExport implements FromView
{
  private $data;

  public function __construct($data)
  {
    $this->data = $data;
  }

  public function view(): View
  {
    return view('excel.export.waterlevel_template', ['data' => $this->data]);
  }
}
