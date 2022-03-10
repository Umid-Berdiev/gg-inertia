<?php

namespace App\Http\Controllers;

use App\Exports\ChemicalCompositionExport;
use App\models\Well;
use App\models\ChemicalComposition;
use App\Imports\ChemicalCompositionImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ChemicalCompositionController extends Controller
{
  public function index(Request $request)
  {

    $well_id = $request->well_id;
    $year = $request->year;
    $items = [];
    $roman_months = ["III", "VI", "IX", "XII"];

    if ($well_id && $year) {
      foreach ($roman_months as $month) {
        $items[] = ChemicalComposition::firstOrCreate(
          [
            'skvajina_id' => $well_id,
            'year' => $year,
            'month' => $month
          ],
          [
            'user_id' => auth()->id(),
            'hardness' => null,
            'pH' => null,
            'dry_residue' => null,
            'CO2' => null,
            'H2S' => null,
            'SiO2' => null,
            'CO3' => null,
            'HCO3' => null,
            'CI' => null,
            'SO4' => null,
            'NO3' => null,
            'NO2' => null,
            'Ca' => null,
            'Mg' => null,
            'Na+K' => null,
            'Na' => null,
            'K' => null,
            'Fe+2' => null,
            'Fe+3' => null,
            'NH4' => null,
            'okis' => null,
            'F' => null
          ]
        );
      }
    }

    $wells = Well::where('isDeleted', false)->whereHas('well_type', fn ($query) => $query->where('name', 'наблюдательный'))->select('id', 'number_auther', 'cadaster_number')->get();

    $elements = ['hardness', 'pH', 'dry_residue', 'CO2', 'H2S', 'SiO2', 'CO3', 'HCO3', 'CI', 'SO4', 'NO3', 'NO2', 'Ca', 'Mg', 'Na+K', 'Na', 'K', 'Fe+2', 'Fe+3', 'NH4', 'okis', 'F'];
    //        $romanMonths = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
    // ChemicalComposition::doesntHave('well')->delete();

    return Inertia::render('dannye/chemical-composition/Index', [
      'wells' => $wells,
      'elements' => $elements,
      'roman_months' => $roman_months,
      'items' => $items
    ]);
  }

  public function create()
  {
    $wells = Well::where('isDeleted', false)->whereHas('well_type', fn ($query) => $query->where('name', 'наблюдательный'))->get();
    $year = request('year');
    $year2 = request('year2');
    return view('gidrogeologiya.pages.chemical-composition.create', compact('year', 'year2', 'wells', 'year2'));
  }

  public function store(Request $request)
  {
    $well = Well::findOrFail($request->author_id);
    $year = $request->year;
    $romanMonths = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];

    foreach ($romanMonths as $month) {
      ChemicalComposition::firstOrCreate(
        [
          'skvajina_id' => $well->id,
          'year' => $year,
          'month' => $month
        ],
        [
          'user_id' => auth()->id(),
        ]
      );
    }

    return redirect(route('chemical-composition', ['skvajina_id' => $well->id, 'year' => $year]));
  }

  public function update(Request $request, $id)
  {
    $myStr = $request->datas;
    $data = ChemicalComposition::where('skvajina_id', $id)->where('year', $request->year)->get();

    foreach ($data as $item) {
      foreach ($myStr as $key => $value) {
        if ($key == trim($item->month)) {
          $item->update([
            'hardness' => $value['hardness'] ?? null,
            'pH' => $value['pH'] ?? null,
            'dry_residue' => $value['dry_residue'] ?? null,
            'CO2' => $value['CO2'] ?? null,
            'H2S' => $value['H2S'] ?? null,
            'SiO2' => $value['SiO2'] ?? null,
            'CO3' => $value['CO3'] ?? null,
            'HCO3' => $value['HCO3'] ?? null,
            'CI' => $value['CI'] ?? null,
            'SO4' => $value['SO4'] ?? null,
            'NO3' => $value['NO3'] ?? null,
            'NO2' => $value['NO2'] ?? null,
            'Ca' => $value['Ca'] ?? null,
            'Mg' => $value['Mg'] ?? null,
            'Na+K' => $value['Na+K'] ?? null,
            'Na' => $value['Na'] ?? null,
            'K' => $value['K'] ?? null,
            'Fe+2' => $value['Fe+2'] ?? null,
            'Fe+3' => $value['Fe+3'] ?? null,
            'NH4' => $value['NH4'] ?? null,
            'okis' => $value['okis'] ?? null,
            'F' => $value['F'] ?? null,
            'user_id' => auth()->id() ?? null,
            'is_approve' => false,
          ]);
        }
      }
    }

    $data = ChemicalComposition::where('skvajina_id', $id)->where('year', $request->year)->update([
      'is_approve' => false,
    ]);

    return redirect(route('chemical-composition', ['skvajina_id' => $id, 'year' => $request->year]))->with('success', 'Таблица успешно обновлена!');
  }

  public function import()
  {
    request()->validate([
      'select_file' => 'required|max:5000|mimes:xls,xlsx'
    ], $this->messages());

    Excel::import(new ChemicalCompositionImport(), request()->file('select_file'));

    return back()->with('success', 'Данные успешно добавлены!');
  }

  public function exportTemplate()
  {
    $data = [];
    return Excel::download(new ChemicalCompositionExport($data), 'Химсостав_воды_шаблон' . Carbon::now() . '.xlsx');
  }

  public function exportData(Request $request)
  {
    if (($request->year != "null" && $request->year != "") && ($request->year2 != "null" && $request->year2 != "") && ($request->skvajina_id != "null" && $request->skvajina_id != "")) {
      $data = ChemicalComposition::whereIn('month', ['III', 'VI', 'IX', 'XII'])->where('skvajina_id', $request->skvajina_id)->whereBetween('year', [$request->year, $request->year2])->orderby('year', 'desc')->with('well')->get();
      return Excel::download(new ChemicalCompositionExport($data), 'Химсостав_воды_за_' . $request->year . '_' . $request->year2 . '_' . Carbon::now() . '.xlsx');
    } else return back()->with('warning', 'Выберите год');
  }

  public function accept($year, $well)
  {
    ChemicalComposition::where('skvajina_id', $well)->where('year', $year)->update(
      [
        'user_id' => auth()->id(),
        'is_approve' => true,
      ]
    );

    return back()->with('success', __('messages.Таблица успешно одобрень!'));
  }

  /**
   * Get the error messages for the defined validation rules.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'required' => 'Файл отсуствует',
      'mimes' => 'Формат файла не верный',
      'max' => 'Максимальный размер файла должен быть не больше 5мб'
    ];
  }

  public function PostXimsostavItems(Request $request)
  {
    $dannie = ChemicalComposition::find($request->id);
    $dannie->update([
      $request->column => $request->value
    ]);
    $dannie->save();
  }
}
