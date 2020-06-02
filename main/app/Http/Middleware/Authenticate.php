<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
  /**
   * Get the path the user should be redirected to when they are not authenticated.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return string|null
   */
  protected function redirectTo($request)
  {
    foreach (collect(config('auth.guards'))->except(['api']) as $key => $value) {
      try {
        auth($key)->logout();
      } catch (\Throwable $e) { }
    }
    if ($request->isApi()) {
      return response()->json(['message' => 'Unauthenticated'], 401);
    } else {
      return route('app.login');
    }
  }
}
