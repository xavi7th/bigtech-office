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
    throw new AuthenticationException(
      'Unauthenticated.',
      $guards,
      $this->redirectTo($request)
    );
  }

  private function accountSuspended($request, array $guards)
  {
    throw new AuthenticationException(
      'Account Suspended. Contact your manager.',
      $guards,
      $this->redirectTo($request)
    );
  }

  /**
    * Determine if the user is logged in to any of the given guards.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  array  $guards
    * @return void
    *
    * @throws \Illuminate\Auth\AuthenticationException
    */
  protected function authenticate($request, array $guards)
  {
    if (empty($guards)) {
        $guards = [null];
    }

    foreach ($guards as $guard) {
      if ($this->auth->guard($guard)->check()) {

        /** Check if the user is active and deny access if not*/
        if (!$this->auth->guard($guard)->user()->is_active && !$this->auth->guard($guard)->user()->isSuperAdmin()) {
          $this->auth->guard($guard)->logout();
          $this->accountSuspended($request, $guards);
        }

        return $this->auth->shouldUse($guard);
      }
    }

    $this->unauthenticated($request, $guards);
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
