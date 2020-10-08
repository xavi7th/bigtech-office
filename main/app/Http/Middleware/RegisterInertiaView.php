<?php

namespace App\Http\Middleware;

use Closure;
use Inertia\Inertia;
use Illuminate\Support\Str;

class RegisterInertiaView
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    // dump(\Route::currentRouteName());
    // dd(routeHasRootNamespace('app.'));
    if ($request->user()) {
      Inertia::setRootView(strtolower($request->user()->getType()) . '::app');
    } elseif (Str::contains(\Route::currentRouteName(), 'login')) {
      Inertia::setRootView('appuser::app');
    } else {
      Inertia::setRootView('publicpages::app');
    }
    return $next($request);
  }
}
