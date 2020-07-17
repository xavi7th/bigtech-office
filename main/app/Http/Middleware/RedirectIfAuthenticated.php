<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string|null  $guard
   * @return mixed
   */
  public function handle($request, Closure $next, ...$guards)
  {
    /**
     * ? If no guard specified, authenticate agaings the default guard
     */
    if (is_null($guards)) {
      if (Auth::check()) {
        return redirect()->route(Auth::user()->dashboardRoute());
      }
    } else {
      foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
          return redirect()->route(Auth::guard($guard)->user()->dashboardRoute());
        }
      }
    }
    return $next($request);
  }
}
