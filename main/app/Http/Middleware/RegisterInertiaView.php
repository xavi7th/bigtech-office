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
    // dump(Str::contains(\Route::currentRouteName(), 'login'));
    // dd(routeHasRootNamespace('app.'));
    if (routeHasRootNamespace('app.') && !Str::contains(\Route::currentRouteName(), 'login')) {
      Inertia::setRootView('publicpages::app');
    } elseif (routeHasRootNamespace('appuser.') || Str::contains(\Route::currentRouteName(), 'login')) {
      Inertia::setRootView('appuser::app');
    } elseif (routeHasRootNamespace('admin.')) {
      Inertia::setRootView('admin::app');
    } elseif (routeHasRootNamespace('superadmin.')) {
      Inertia::setRootView('superadmin::app');
    }
    return $next($request);
  }
}
