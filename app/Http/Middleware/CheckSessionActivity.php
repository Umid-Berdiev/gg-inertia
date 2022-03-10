<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CheckSessionActivity
{
  protected $session;
  protected $timeout = 120;

  public function __construct(Store $session)
  {
    $this->session = $session;
  }

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $new_pass = Str::random(10);
    $hashed_random_password = Hash::make($new_pass);

    if (now()->diffInMinutes(session('lastActivityTime')) >= (120)) {
      auth()->user()->update([
        'password' => $hashed_random_password
      ]);
      auth()->logout();
      return redirect(route('reset'))->with('warning', 'Ваша сессия завершена!');
    }

    return $next($request);
  }
}
