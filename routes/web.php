<?php

use App\Http\Controllers\ChemicalCompositionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\WaterlevelController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use UniSharp\LaravelFilemanager\Lfm;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  // return Inertia::render('Welcome', [
  //     'canLogin' => Route::has('login'),
  //     'canRegister' => Route::has('register'),
  //     'laravelVersion' => Application::VERSION,
  //     'phpVersion' => PHP_VERSION,
  // ]);
  return redirect()->route('dashboard');
});

// Route::middleware(['auth', 'verified'])->group(function () {
//   Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });

// Route::get('reset', [AuthController::class,'reset'])->name('reset');

// Route::post('confirm', [AuthController::class,'confirm'])->name('confirm');

Route::middleware(['auth', 'verified', 'checkSessionActivity'])->group(function () {
  Route::get('/user-id', function () {
    return response()->json(['user_id' => auth()->user()->id]);
  });

  Broadcast::routes();

  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('get-changes-log', [DashboardController::class, 'getChangesLog'])->name('get-changes-log');
  Route::get('get-chart4-data-by-interval', [DashboardController::class, 'getChart4DataByInterval'])->name('get_chart4_data_by_interval');
  Route::get('groundwater_totals', [DashboardController::class, 'groundwaterTotals'])->name('gw_total_reserves');
  Route::post('groundwater_totals/add', [DashboardController::class, 'groundwaterTotalAdd'])->name('gw_total_reserves.add');
  Route::post('groundwater_totals/edit', [DashboardController::class, 'groundwaterTotalEdit'])->name('gw_total_reserves.edit');

  Route::get('media-gallery', [AuthController::class, 'getMediaGalleryPage'])->name('media-gallery');
  Route::get('map-gallery', [MediaController::class, 'index'])->name('media2');
  Route::get('media', [MediaController::class, 'media'])->name('media2.mediagallery');
  Route::get('getMedia', [MediaController::class, 'getMedia'])->name('media2.getMedia');
  Route::get('media/edit', [MediaController::class, 'edit'])->name('media2.edit');
  Route::post('media/update', [MediaController::class, 'update'])->name('media2.post');
  Route::post('media/delete/{id}', [MediaController::class, 'delete'])->name('media2.delete');
  Route::post('store-multiple-image', [MediaController::class, 'store'])->name('media2.store');
  Route::group(['prefix' => 'reestr'], function () {
    Route::group(['prefix' => 'wells'], function () {
      Route::get('edit', [WellController::class, 'editByAxios'])->name('wells.edit_by_axios');
      Route::get('export', [WellController::class, 'export'])->name('wells.export');
      Route::get('export/template', [WellController::class, 'exportTemplate'])->name('wells.export.template');
      Route::post('import', [WellController::class, 'import'])->name('wells.import');
      Route::get('search', [WellController::class, 'search'])->name('wells.search');
      Route::post('accept', [WellController::class, 'accept'])->name('wells.accept');
      Route::get('acceptall', [WellController::class, 'acceptAll'])->name('wells.accept.all');
    });

    Route::resource('wells', WellController::class)->except(['create', 'edit', 'show']);

    Route::group(['prefix' => 'place_births'], function () {
      Route::get('edit', [PlaceBirthController::class, 'editByAxios'])->name('place_births.edit_by_axios');
      Route::get('export', [PlaceBirthController::class, 'export'])->name('place_births.export');
      Route::get('export/template', [PlaceBirthController::class, 'exportTemplate'])->name('place_births.export.template');
      Route::post('import', [PlaceBirthController::class, 'import'])->name('place_births.import');
      Route::get('search', [PlaceBirthController::class, 'search'])->name('place_births.search');
      Route::post('accept', [PlaceBirthController::class, 'accept'])->name('place_births.accept');
      Route::get('acceptall', [PlaceBirthController::class, 'acceptAll'])->name('place_births.accept.all');
    });

    Route::resource('place_births', PlaceBirthController::class)->except(['create', 'edit', 'show']);

    Route::group(['prefix' => 'approved_plots'], function () {
      Route::get('edit', [ApprovedPlotController::class, 'editByAxios'])->name('approved_plots.edit_by_axios');
      Route::get('export', [ApprovedPlotController::class, 'export'])->name('approved_plots.export');
      Route::get('export/template', [ApprovedPlotController::class, 'exportTemplate'])->name('approved_plots.export.template');
      Route::post('import', [ApprovedPlotController::class, 'import'])->name('approved_plots.import');
      Route::get('search', [ApprovedPlotController::class, 'search'])->name('approved_plots.search');
      Route::post('accept', [ApprovedPlotController::class, 'accept'])->name('approved_plots.accept');
      Route::get('acceptall', [ApprovedPlotController::class, 'acceptAll'])->name('approved_plots.accept.all');
    });

    Route::resource('approved_plots', ApprovedPlotController::class)->except(['create', 'edit', 'show']);

    Route::group(['prefix' => 'water_intakes'], function () {
      Route::get('edit', [WaterIntakeController::class, 'editByAxios'])->name('water_intakes.edit_by_axios');
      Route::get('export', [WaterIntakeController::class, 'export'])->name('water_intakes.export');
      Route::get('export/template', [WaterIntakeController::class, 'exportTemplate'])->name('water_intakes.export.template');
      Route::post('import', [WaterIntakeController::class, 'import'])->name('water_intakes.import');
      Route::get('search', [WaterIntakeController::class, 'search'])->name('water_intakes.search');
      Route::post('accept', [WaterIntakeController::class, 'accept'])->name('water_intakes.accept');
      Route::get('acceptall', [WaterIntakeController::class, 'acceptAll'])->name('water_intakes.accept.all');
    });

    Route::resource('water_intakes', WaterIntakeController::class)->except(['create', 'edit', 'show']);

    Route::group(['prefix' => 'mineral_waters'], function () {
      Route::get('/edit', [MineralWaterController::class, 'editByAxios'])->name('mineral_waters.edit_by_axios');
      Route::get('/export', [MineralWaterController::class, 'export'])->name('mineral_waters.export');
      Route::get('/export/template', [MineralWaterController::class, 'exportTemplate'])->name('mineral_waters.export.template');
      Route::post('/import', [MineralWaterController::class, 'import'])->name('mineral_waters.import');
      Route::get('/search', [MineralWaterController::class, 'search'])->name('mineral_waters.search');
      Route::post('/accept', [MineralWaterController::class, 'accept'])->name('mineral_waters.accept');
      Route::get('/accept_all', [MineralWaterController::class, 'acceptAll'])->name('mineral_waters.accept.all');
    });
    Route::resource('mineral_waters', MineralWaterController::class)->except(['create', 'edit', 'show']);
  });

  Route::group(['prefix' => 'directories'], function () {
    Route::get(
      'pools/edit',
      [PoolController::class, 'editByAxios']
    )->name('pools.edit_by_axios');
    Route::resource('pools', PoolController::class)->except(['create', 'edit', 'show']);

    Route::get(
      'intendeds/edit',
      [IntendedController::class, 'editByAxios']
    )->name('intendeds.edit_by_axios');
    Route::resource('intendeds', IntendedController::class)->except(['create', 'edit', 'show']);

    Route::get(
      'well_types/edit',
      [WellTypeController::class, 'editByAxios']
    )->name('well_types.edit_by_axios');
    Route::resource('well_types', WellTypeController::class)->except(['create', 'edit', 'show']);

    Route::get(
      'water_use_types/edit',
      [WaterUseTypeController::class, 'editByAxios']
    )->name('water_use_types.edit_by_axios');
    Route::resource('water_use_types', WaterUseTypeController::class)->except(['create', 'edit', 'show']);

    Route::get(
      'water_intake_types/edit',
      [WaterIntakeTypeController::class, 'editByAxios']
    )->name('water_intake_types.edit_by_axios');
    Route::resource('water_intake_types', WaterIntakeTypeController::class)->except(['create', 'edit', 'show']);
  });

  Route::group(['prefix' => 'dannye'], function () {
    Route::get('waterlevel', [WaterlevelController::class, 'index'])->name('waterlevel');
    // Route::get('waterlevel', [WaterlevelController::class, 'search'])->name('waterlevel.search');
    Route::get('waterlevel/create', [WaterlevelController::class, 'create'])->name('waterlevel.create');
    Route::get('waterlevel/store', [WaterlevelController::class, 'store'])->name('waterlevel.store');
    Route::post('waterlevel/import', [WaterlevelController::class, 'import'])->name('waterlevel.import');
    Route::get('waterlevel/template', [WaterlevelController::class, 'exportTemplate'])->name('waterlevel.template');
    Route::get('waterlevel/export', [WaterlevelController::class, 'exportData'])->name('waterlevel.export');
    Route::get('waterlevel/diagramm', [WaterlevelController::class, 'getDiagramma'])->name('waterlevel.diagramma');
    Route::post('waterlevel/accept', [WaterlevelController::class, 'accept'])->name('waterlevel.accept');
    Route::post('waterlevel/interpolation', [InterpolationController::class, 'create'])->name('waterlevel-create-interpolation');

    Route::post(
      'waterlevel/{waterlevel}',
      [WaterlevelController::class, 'update']
    )->name('waterlevel.update');

    Route::get('rasxod_vody', [WaterlevelController::class, 'rasxodVodyIndex'])->name('rasxod_vody');
    Route::get('rasxod_vody/create', [WaterlevelController::class, 'rasxodVodyCreate'])->name('rasxod_vody.create');
    Route::post('rasxod_vody/store', [WaterlevelController::class, 'rasxodVodyStore'])->name('rasxod_vody.store');
    Route::post('rasxod_vody/accept/{id}', [WaterlevelController::class, 'RasxodAccept'])->name('rasxod_vody.accept');

    Route::patch(
      'rasxod_vody/{id}/update',
      [WaterlevelController::class, 'rasxodVodyUpdate']
    )->name('rasxod_vody.update');

    Route::get('chemical-composition', [ChemicalCompositionController::class, 'index'])->name('chemical-composition');
    Route::get('chemical-composition/create', [ChemicalCompositionController::class, 'create'])->name('chemical-composition.create');
    Route::post('chemical-composition/store', [ChemicalCompositionController::class, 'store'])->name('chemical-composition.store');
    Route::post('chemical-composition/import', [ChemicalCompositionController::class, 'import'])->name('chemical-composition.import');
    Route::get('chemical-composition/template', [ChemicalCompositionController::class, 'exportTemplate'])->name('chemical-composition.template');
    Route::post('chemical-composition/export', [ChemicalCompositionController::class, 'exportData'])->name('chemical-composition.export');
    Route::post('chemical-composition/accept', [ChemicalCompositionController::class, 'accept'])->name('chemical-composition.accept');
    Route::post(
      'chemical-composition/{chemical-composition}',
      [ChemicalCompositionController::class, 'update']
    )->name('chemical-composition.update');
    Route::get(
      'chemical-composition/{id}/update',
      [ChemicalCompositionController::class, 'update']
    )->name('chemical-composition.get');
  });

  Route::group(['prefix' => 'reports'], function () {
    Route::get('/print', [ReportController::class, 'print_report'])->name('reports.print');
    Route::post('generate-docx', [ReportController::class, 'generateDocx'])->name('reports.print.download');
  });

  Route::get('divers/edit', [DiverController::class, 'editByAxios'])->name('divers.edit_by_axios');
  Route::get('divers/export', [DiverController::class, 'export'])->name('divers.export');
  Route::get('divers/export/template', [DiverController::class, 'exportTemplate'])->name('divers.export.template');
  Route::post('divers/import', [DiverController::class, 'import'])->name('divers.import');

  Route::group(['prefix' => 'divers-info'], function () {
    Route::get('divers', [DiverController::class, 'index'])->name('divers.index');
    Route::resource('divers', DiverController::class)->except(['index', 'create', 'edit', 'show']);

    Route::get('diver-logs', [DiverLogController::class, 'index'])->name('diver_logs.index');
    Route::get('diver-logs/export', [DiverLogController::class, 'export'])->name('diver_logs.export');
    Route::get('diver-error-messages', [DiverErrorMessageController::class, 'index'])->name('diver_error_messages.index');
  });

  Route::resource('contacts', ContactController::class);

  Route::group(['prefix' => 'map'], function () {
    Route::get('/', [MapController::class, 'index'])->name('map');
    Route::get('/diagramma/years', [MapController::class, 'getDiagrammaForYears'])->name('map.diagramma.years');
    Route::get('/diagramma/months', [MapController::class, 'getDiagrammaForMonths'])->name('map.diagramma.months');
    Route::get('/diagramma/diver-info', [MapController::class, 'getDataForDiverChart'])->name('map.diagramma.diver-info');
    Route::get('/approved_plots', [MapController::class, 'getApprovalPlots'])->name('map.approved_plots');
    Route::get('/wells', [MapController::class, 'getWells'])->name('map.wells');
    Route::get('/water_intakes', [MapController::class, 'getWaterIntakes'])->name('map.water_intakes');
    Route::get('/mineral_waters', [MapController::class, 'getMineralWaters'])->name('map.mineral_waters');
    Route::get('/groundwater_fields', [MapController::class, 'getGroundwaterFields'])->name('map.groundwater_fields');
    Route::get('/groundwater_field', [MapController::class, 'getGroundwaterField'])->name('map.groundwater_field');
  });

  Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [AuthController::class, 'adminIndex'])->name('admin.index');

    Route::resource('languages', LanguageController::class);

    Route::resource('terms', TermController::class)->except(['create', 'edit', 'show']);

    Route::get('get/division', [UserController::class, 'selectPosition'])->name('admin.users.get_division');
    Route::get('users/edit', [UserController::class, 'editByAxios'])->name('users.edit_by_axios');
    Route::post('users/close-all-users', [UserController::class, 'closeAllUsers'])->name('close-all-users');
    Route::resource('users', UserController::class)->except(['edit', 'show']);
  });

  Route::post('locale', [LanguageController::class, 'setLocale'])->name('set.locale');

  // Route::prefix('laravel-filemanager')->group(function () {
  //   Lfm::routes();
  // });

  Route::get('all-notifications', [NotificationController::class, 'getAllNotifications']);
  Route::post('mark-as-read', [NotificationController::class, 'markNotification']);
  // Route::get('import-errors/{id}', [NotificationController::class, 'errors']);

  Route::get('get-interpolation-layers', [MapController::class, 'getIdwLayersByParams']);
  Route::get('get-all-interpolation', [MapController::class, 'getAllInterpolation']);
  Route::post('interpolation-notify', [NotificationController::class, 'interpolationCreatedNotify']);
});

require __DIR__ . '/auth.php';
