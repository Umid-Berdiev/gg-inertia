<?php

namespace App\Imports;

use App\Models\Waterlevel;
use App\Models\Well;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WaterlevelImport implements ToCollection, WithHeadingRow
{
  public function collection(Collection $rows)
  {
    Validator::make($rows->toArray(), [
      '*.year' => [
        'required',
        'digits:4',
        'integer',
        'min:1970',
        'max:' . date('Y'),
      ],
      '*.cadaster_number' => [
        'required',
        Rule::exists('wells', 'cadaster_number')->where(function ($query) {
          $query->where('isDeleted', false);
        }),
      ]
    ], $this->messages())->validate();

    foreach ($rows as $row) {
      $skvajina_with_year = Well::where('isDeleted', false)->where('cadaster_number', $row["cadaster_number"])->first();

      $item = Waterlevel::updateOrCreate(
        [
          "skvajina_id" => $skvajina_with_year->id,
          "year" => (float)$row["year"]
        ],
        [
          "january" => $row["i"] ? (float)$row["i"] : null,
          "february" => $row["ii"] ? (float)$row["ii"] : null,
          "march" => $row["iii"] ? (float)$row["iii"] : null,
          "april" => $row["iv"] ? (float)$row["iv"] : null,
          "may" => $row["v"] ? (float)$row["v"] : null,
          "june" => $row["vi"] ? (float)$row["vi"] : null,
          "july" => $row["vii"] ? (float)$row["vii"] : null,
          "august" => $row["viii"] ? (float)$row["viii"] : null,
          "september" => $row["ix"] ? (float)$row["ix"] : null,
          "october" => $row["x"] ? (float)$row["x"] : null,
          "november" => $row["xi"] ? (float)$row["xi"] : null,
          "december" => $row["xii"] ? (float)$row["xii"] : null
        ]
      );

      $item->update([
        'min' => $item->min(),
        'max' => $item->max(),
        'average' => $item->average()
      ]);
    }
  }

  public function headingRow(): int
  {
    return 2;
  }

  /**
   * Get the error messages for the defined validation rules.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'required' => ':attribute - обязательное поле',
      'unique' => ':input уже есть в базе',
      'exists' => 'Кадастровый номер :input нет в базе скважин',
      'max' => 'В ячейке :attribute год :input не должен перевышать текущего года',
      'min' => 'В ячейке :attribute год :input не должен быть менше 1970 года'
    ];
  }
}
