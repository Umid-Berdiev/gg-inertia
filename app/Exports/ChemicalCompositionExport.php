<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ChemicalCompositionExport implements FromView, ShouldAutoSize, WithStyles, WithEvents, WithPreCalculateFormulas
{
  private $data;

  public function __construct($data)
  {
    $this->data = $data;
  }


  public function view(): View
  {
    return view('excel.export.chemical_composition_template', ['data' => $this->data]);
  }

  public function styles(Worksheet $sheet)
  {
    $sheet->getStyle("B1")->getAlignment()->setTextRotation(90);
    $sheet->getStyle("D2")->getAlignment()->setTextRotation(90);
    $sheet->getStyle("E2")->getAlignment()->setTextRotation(90);
    $sheet->getStyle("I1")->getAlignment()->setTextRotation(90);
    $sheet->getStyle("K1")->getAlignment()->setTextRotation(90);
    $sheet->getStyle("M1")->getAlignment()->setTextRotation(90);
    $sheet->getStyle("N2:S2")->getAlignment()->setTextRotation(90);
    $sheet->getStyle("U2:AA2")->getAlignment()->setTextRotation(90);
    $sheet->getStyle("AC1")->getAlignment()->setTextRotation(90);
    $sheet->getStyle("AE1")->getAlignment()->setTextRotation(90);
    $sheet->getStyle("A1:AF30")->getAlignment()->setVertical('center')->setHorizontal('center');

    // TODO: Implement styles() method.
  }

  public function registerEvents(): array
  {
    return [
      AfterSheet::class => function (AfterSheet $event) {
        $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(80);
        $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(10);
        $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(10);
        $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(10);
        $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(10);

        $event->sheet->autoSize();
      },
    ];
  }
}
