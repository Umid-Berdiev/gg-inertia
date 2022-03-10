<?php

namespace App\Http\Middleware;

use App\Models\Language;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
  /**
   * The root template that is loaded on the first page visit.
   *
   * @var string
   */
  protected $rootView = 'app';

  /**
   * Determine the current asset version.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return string|null
   */
  public function version(Request $request)
  {
    return parent::version($request);
  }

  /**
   * Define the props that are shared by default.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function share(Request $request)
  {
    $user = $request->user() ?
      User::with('roles')->select('id', 'firstname', 'lastname', 'lang_prefix')->find($request->user()->id) :
      null;

    return array_merge(parent::share($request), [
      'auth.user' => fn () => $user ? $user : null,
      'locales' => Language::all(),
      'dannycount1' => \App\Models\Waterlevel::where('is_approve', false)->count(),
      'dannycount2' => \App\Models\RasxodVody::where('is_approve', false)->count(),
      'dannycount3' => \App\Models\ChemicalComposition::where('is_approve', false)->count(),
      'reestr1' => \App\Models\PlaceBirth::where('isDeleted', false)->where('is_approve', false)->count(),
      'reestr2' => \App\Models\ApprovedPlot::where('isDeleted', false)->where('is_approve', false)->count(),
      'reestr3' => \App\Models\WaterIntake::where('isDeleted', false)->where('is_approve', false)->count(),
      'reestr4' => \App\Models\Well::where('isDeleted', false)->where('is_approve', false)->count(),
      'reestr5' => \App\Models\MineralWater::where('is_deleted', false)->where('is_approve', false)->count(),
    ]);
  }
}
