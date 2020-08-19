<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{


  /**
   * Handle an unauthenticated user.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  array  $guards
   * @return void
   *
   * @throws \Illuminate\Auth\AuthenticationException
   */
  protected function unauthenticated($request, array $guards)
  {
    // if ($request->header('X-Inertia')) {
    //   foreach (collect(config('auth.guards'))->except(['api']) as $key => $value) {
    //     try {
    //       auth($key)->logout();
    //     } catch (\Throwable $e) {
    //     }
    //   }

    //   return abort(409, 'Unauthenticated', ['X-Inertia-Location'], route('app.login'));
    // } else {
    throw new AuthenticationException(
      'Unauthenticated.',
      $guards,
      $this->redirectTo($request)
    );
    // }
  }

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
      } catch (\Throwable $e) {
      }
    }
    if ($request->isApi()) {
      return response()->json(['message' => 'Unauthenticated'], 401);
    } else {
      return route('app.login.show');
    }
  }
}
