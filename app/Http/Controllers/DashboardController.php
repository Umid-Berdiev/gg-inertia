<?php

namespace App\Http\Controllers;

use App\Models\ApprovedPlot;
use App\Models\Waterlevel;
use App\Models\GroundwaterTotalReserve;
use App\Models\MineralWater;
use App\Models\NumberProductionWell;
use App\Models\PlaceBirth;
use App\Models\WaterIntake;
use App\Models\Well;
use App\Models\ChemicalComposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
  public function index(Request $request)
  {
    $pb = PlaceBirth::where('isDeleted', false)->get()->count();
    $wi = WaterIntake::where('isDeleted', false)->get()->count();
    $approved_plots = ApprovedPlot::where('isDeleted', false)->with('ap_attrs')->get()->count();
    $mineral_waters = MineralWater::where('is_deleted', false)->get()->count();
    $wellsData = Well::where('isDeleted', false)->where('wells_type_id', 5)->with('well_attrs')->select('id')->get();
    $wellsDataWithDiver = Well::where('isDeleted', false)->where('wells_type_id', 5)->has('diver')->with('well_attrs')->select('id')->get();
    $groundwater_total_reserve = GroundwaterTotalReserve::where('year', date('Y') - 2)->latest('year')->first();
    $numberProductionWells = NumberProductionWell::where('year', date('Y') - 2)->latest('year')->first();

    return Inertia::render('Dashboard', [
      'pb' => $pb,
      'wi' => $wi,
      'approved_plots' => $approved_plots,
      'mineral_waters' => $mineral_waters,
      'wellsData' => $wellsData,
      'wellsDataWithDiver' => $wellsDataWithDiver,
      'groundwaterTotalReserve' => $groundwater_total_reserve,
      'numberProductionWells' => $numberProductionWells
    ]);
  }

  public function groundwaterTotalAdd(Request $request)
  {
    // return $request->all();
    if ($request->firstData) {
      GroundwaterTotalReserve::updateOrCreate(
        [
          'year' => $request['firstData']['year']
        ],
        [
          'karakalpak' => $request['firstData']['karakalpak'],
          'andijan' => $request['firstData']['andijan'],
          'buhara' => $request['firstData']['buhara'],
          'djizak' => $request['firstData']['djizak'],
          'kashkadarya' => $request['firstData']['kashkadarya'],
          'navai' => $request['firstData']['navai'],
          'namangan' => $request['firstData']['namangan'],
          'samarkand' => $request['firstData']['samarkand'],
          'surhandarya' => $request['firstData']['surhandarya'],
          'sirdarya' => $request['firstData']['sirdarya'],
          'tashkent' => $request['firstData']['tashkent'],
          'fergana' => $request['firstData']['fergana'],
          'xorezm' => $request['firstData']['xorezm']
        ]
      );
    }

    if ($request->secondData) {
      NumberProductionWell::updateOrCreate(
        [
          'year' => $request['secondData']['year']
        ],
        [
          'karakalpak' => $request['secondData']['karakalpak'],
          'andijan' => $request['secondData']['andijan'],
          'buhara' => $request['secondData']['buhara'],
          'djizak' => $request['secondData']['djizak'],
          'kashkadarya' => $request['secondData']['kashkadarya'],
          'navai' => $request['secondData']['navai'],
          'namangan' => $request['secondData']['namangan'],
          'samarkand' => $request['secondData']['samarkand'],
          'surhandarya' =>  $request['secondData']['surhandarya'],
          'sirdarya' => $request['secondData']['sirdarya'],
          'tashkent' => $request['secondData']['tashkent'],
          'fergana' => $request['secondData']['fergana'],
          'xorezm' => $request['secondData']['xorezm']
        ]
      );
    }

    return response()->json(['Success'], 200);
  }

  public function groundwaterTotals(Request $request)
  {
    if ($request->year) {
      $data1 = GroundwaterTotalReserve::where('year', $request->year)->first();
      $data2 = NumberProductionWell::where('year', $request->year)->first();
      //      $data = NumberProductionWell::whereIn('year', [$request->year1, $request->year2])->get();
      return response()->json([
        'groundwaterTotalReserve' => $data1,
        'numberProductionWells' => $data2
      ]);
    }
  }

  public function getChart4DataByInterval(Request $request)
  {
    $finish_year = $request->year_finish ?? (int)date('Y');
    $start_year = $request->year_start ?? $finish_year - 11;

    $groundwater_total_reserves = GroundwaterTotalReserve::orderBy('year', 'DESC')
      ->select([
        'year',
        DB::raw("SUM(karakalpak + andijan + buhara + djizak + kashkadarya + navai + namangan + samarkand + surhandarya + sirdarya + tashkent + fergana + xorezm) as sum")
      ])
      ->groupBy('year')
      ->get()
      ->toArray();

    $years = [];

    for ($i = (int)$start_year; $i <= (int)$finish_year; $i++) {
      $temp_sum = null;

      foreach ($groundwater_total_reserves as $value) {
        if ($value['year'] == $i) {
          $temp_sum = round($value['sum']);
          break;
        }
      }

      $years[] = [
        'year' => $i,
        'sum' => $temp_sum
      ];
    }

    return response()->json($years);
  }

  public function getChangesLog(Request $request)
  {
    $urevenvodys = Waterlevel::where('updated_at', '>=', now()->subDays(3))->orderBy('updated_at', 'DESC')->select('id', 'updated_at', 'skvajina_id', 'user_id', 'year')->with('well', 'user')->get();
    $ximsostav = ChemicalComposition::where('updated_at', '>=', now()->subDays(3))->orderBy('updated_at', 'DESC')->select('id', 'updated_at', 'skvajina_id', 'user_id', 'year')->with('well', 'user')->get();
    // $rasxodvody = RasxodVody::with('well', 'user')->where('updated_at', '>=', now()->subDays(3))->orderBy('updated_at', 'DESC')->select('updated_at')->get();
    // dd();
    $grouped_ximsostav = collect($ximsostav->groupBy('skvajina_id'))->toArray();
    $res_ximsostav = [];

    foreach ($grouped_ximsostav as $value) {
      $res_ximsostav[] = $value[0];
    }

    return response()->json([
      'urevenvodys' => $urevenvodys,
      'ximsostav' => $res_ximsostav,
      // 'rasxodvody' => $rasxodvody,
    ]);
  }
}
