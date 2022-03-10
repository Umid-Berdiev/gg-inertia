<?php

namespace App\Http\Controllers;

use App\Exports\WaterlevelExport;
use App\models\Waterlevel;
use App\models\RasxodVody;
use App\models\Well;
use App\Imports\WaterlevelImport;
use App\Models\UzRegion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class WaterlevelController extends Controller
{
  public function index(Request $request)
  {
    $well_id = $request->well_id;
    $year = $request->year;
    $item = [];
    if ($well_id && $year) {
      $item = Waterlevel::firstOrCreate(
        [
          'skvajina_id' => $well_id,
          'year' => $year
        ],
        [
          'user_id' => auth()->id(),
        ]
      );
    }

    $wells = Well::where('isDeleted', false)->whereHas('well_type', fn ($query) => $query->where('name', 'наблюдательный'))->select('id', 'number_auther', 'cadaster_number')->get();

    // Waterlevel::doesntHave('well')->delete();

    $currentLocale = ucfirst($request->user()->lang_prefix) ?? ucfirst(app()->currentLocale());
    // dd($request->user()->lang_prefix);
    // dd($currentLocale);
    $name = "name$currentLocale";
    $regions = UzRegion::select('id', 'regionid', "$name AS name")->get();

    return Inertia::render('dannye/waterlevel/Index', [
      'wells' => $wells,
      'item' => $item,
      'regions' => $regions
    ]);
  }

  // public function search(Request $request)
  // {
  //   $well_id = $request->well_id;
  //   $year = $request->year;
  //   $item = [];

  //   if ($well_id && $year) {
  //     $item = Waterlevel::firstOrCreate(
  //       [
  //         'skvajina_id' => $well_id,
  //         'year' => $year
  //       ],
  //       [
  //         'user_id' => auth()->id(),
  //       ]
  //     );
  //   }

  //   return Inertia::render('dannye/waterlevel/Index', ['item' => $item]);
  // }

  public function create()
  {
    $wells = Well::where('isDeleted', false)->whereHas('well_type', fn ($query) => $query->where('name', 'наблюдательный'))->get();

    return view('gidrogeologiya.pages.waterlevel.create', compact('wells'));
  }

  public function store(Request $request)
  {
    // dd($request->all());
    $well = Well::findOrFail($request->well_id);
    $item = Waterlevel::firstOrCreate(
      [
        'skvajina_id' => $well->id,
        'year' => $request->year
      ],
      [
        'user_id' => auth()->id(),
      ]
    );
    // $wells = Well::where('isDeleted', false)
    //   ->whereHas('well_type', fn ($query) => $query->where('name', 'наблюдательный'))
    //   ->select('id', 'number_auther', 'cadaster_number')
    //   ->get();

    // $item = Waterlevel::where('skvajina_id', $request->well_id)->where('year', request('year'))->orderby('year', 'desc')->get();

    return back()->with('item', $item);
  }

  public function update(Request $request, Waterlevel $waterlevel)
  {
    // dd($waterlevel);
    // $data = Waterlevel::where('skvajina_id', $request->well)->where('year', $request->year,)->orderby('year', 'desc')->get();

    $waterlevel->update([
      'january' => $request->january ? (float)$request->january : null,
      'february' => $request->february ? (float)$request->february : null,
      'march' => $request->march ? (float)$request->march : null,
      'april' => $request->april ? (float)$request->april : null,
      'may' => $request->may ? (float)$request->may : null,
      'june' => $request->june ? (float)$request->june : null,
      'july' => $request->july ? (float)$request->july : null,
      'august' => $request->august ? (float)$request->august : null,
      'september' => $request->september ? (float)$request->september : null,
      'october' => $request->october ? (float)$request->october : null,
      'november' => $request->november ? (float)$request->november : null,
      'december' => $request->december ? (float)$request->december : null,
      'user_id' => \Illuminate\Support\Facades\Auth::id(),
      'is_approve' => false,
    ]);

    $waterlevel->update([
      'min' => $waterlevel->min(),
      'max' => $waterlevel->max(),
      'average' => $waterlevel->average()
    ]);


    //        $data = Waterlevel::where('skvajina_id', request('skvajina_id'))->whereBetween('year', [request('year'), request('year2')])->orderby('year', 'desc')->get();
    //        return redirect(route('waterlevel', ['id' => $data->id, 'skvajina_id' => $data->skvajina_id, 'year' => $data->year]))->with('success', 'Таблица успешно обновлена!');
    return Redirect::back();
  }

  public function import()
  {
    request()->validate([
      'select_file' => 'required|max:5000|mimes:xls,xlsx'
    ], $this->messages());

    Excel::import(new WaterlevelImport(), request()->file('select_file'));
    return back()->with('success', 'Импорт успешно выполнено!');
  }

  public function exportTemplate()
  {
    $data = [];
    return Excel::download(new WaterlevelExport($data), 'Уровень_воды_шаблон' . Carbon::now() . '.xlsx');
  }

  public function exportData(Request $request)
  {
    $current_year = date('Y');
    $request->validate([
      'year1' => "required|integer|min:1970|max:$current_year",
      'year2' => "required|integer|min:1970|max:$current_year",
      'well_id' => "required|integer",
    ]);

    $data = Waterlevel::where('skvajina_id', $request->well_id)->whereBetween('year', [$request->year1, $request->year2])->orderby('year', 'desc')->get();
    return Excel::download(new WaterlevelExport($data), 'Уровень_воды_за_' . $request->year1 . '_' . $request->year2 . '_' . Carbon::now() . '.xlsx');
  }

  // public function rasxodVodyIndex()
  // {
  //   $item = RasxodVody::findOrFail(request('id'));
  //   $well = Well::findOrFail(request('skvajina_id'));
  //   $year = request('year');

  //   return view('gidrogeologiya.pages.rasxod_vody.index', compact('item', 'well', 'year'));
  // }

  // public function rasxodVodyCreate()
  // {

  //   return view('gidrogeologiya.pages.rasxod_vody.create');
  // }

  // public function rasxodVodyStore(Request $request)
  // {
  //   $well = Well::findOrFail($request->author_id);
  //   $year = $request->year;

  //   $data = RasxodVody::firstOrCreate(
  //     [
  //       'skvajina_id' => $well->id,
  //       'year' => $year
  //     ],
  //     [
  //       'user_id' => \Illuminate\Support\Facades\Auth::id(),
  //     ]
  //   );

  //   return redirect(route('rasxod_vody', ['id' => $data->id, 'skvajina_id' => $well->id, 'year' => $year]));
  // }

  // public function rasxodVodyUpdate(Request $request, $id)
  // {
  //   $data = RasxodVody::findOrFail($id);

  //   $data->update([
  //     'january' => $request->january ? (float)$request->january : null,
  //     'february' => $request->february ? (float)$request->february : null,
  //     'march' => $request->march ? (float)$request->march : null,
  //     'april' => $request->april ? (float)$request->april : null,
  //     'may' => $request->may ? (float)$request->may : null,
  //     'june' => $request->june ? (float)$request->june : null,
  //     'july' => $request->july ? (float)$request->july : null,
  //     'august' => $request->august ? (float)$request->august : null,
  //     'september' => $request->september ? (float)$request->september : null,
  //     'october' => $request->october ? (float)$request->october : null,
  //     'november' => $request->november ? (float)$request->november : null,
  //     'december' => $request->december ? (float)$request->december : null,
  //     'user_id' => \Illuminate\Support\Facades\Auth::id(),
  //     'is_approve' => false,
  //   ]);

  //   return redirect(route('rasxod_vody', ['id' => $data->id, 'skvajina_id' => $data->skvajina_id, 'year' => $data->year]))->with('success', 'Таблица успешно обновлена!');
  // }



  public function accept(Request $request)
  {
    $data = Waterlevel::where('skvajina_id', $request->well_id)->where('year', $request->year)->update([
      'user_id' => \Illuminate\Support\Facades\Auth::id(),
      'is_approve' => true,
    ]);

    return response()->json([
      'message' => __('messages.data_accepted'),
      'data' => $data
    ]);
  }

  // public function RasxodAccept($id)
  // {
  //   $data = RasxodVody::findOrFail($id);

  //   $data->update([
  //     'user_id' => \Illuminate\Support\Facades\Auth::id(),
  //     'is_approve' => true,
  //   ]);

  //   return redirect()->back()->with('success', __('messages.Таблица успешно одобрень!'));
  // }

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

  public function getDiagramma(Request $request)
  {
    $last_year = date('Y') - 1;
    $current_year = date('Y');
    $last_year_data = Waterlevel::where('skvajina_id', $request->well_id)->where('year', $last_year)->first();
    $current_year_data = Waterlevel::where('skvajina_id', $request->well_id)->where('year', $current_year)->first();

    $data = [
      ['year' => $last_year],
      ['year' => $current_year]
    ];

    if ($last_year_data) {
      for ($month = 1; $month <= 12; $month++) {
        $month_str = lcfirst(date('F', strtotime("$last_year-$month-01")));
        if ($month >= date('n')) {
          $data[0]['data'][] = ['month' => ucfirst($month_str), 'value' => $last_year_data->$month_str];
        }
      }
    }

    if ($current_year_data) {
      for ($month = 1; $month <= 12; $month++) {
        $month_str = lcfirst(date('F', strtotime("$current_year-$month-01")));
        if ($month < date('n')) {
          $data[1]['data'][] = ['month' => ucfirst($month_str), 'value' => $current_year_data->$month_str];
        }
      }
    }

    // dd($data);
    return response()->json([
      'years' => $data,
      'result' => 1
    ]);
  }

  public function getlastMonth()
  {
    Carbon::setLocale('en');
    $str = '';
    for ($i = Carbon::now()->month; $i <= 12; $i++) {
      $str .= strtolower(Carbon::now()->months($i)->monthName . ' as Last' . Carbon::now()->months($i)->monthName . ' , ');
    }
    return rtrim($str, ", ");
  }

  public function getCurrentMonth()
  {
    Carbon::setLocale('en');
    $str = '';
    for ($i = 1; $i <= Carbon::now()->month; $i++) {
      $str .= strtolower(Carbon::now()->months($i)->monthName . ' , ');
    }
    return rtrim($str, ", ");
  }
}
