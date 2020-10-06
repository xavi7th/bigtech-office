<?php

namespace App\Modules\AppUser\Http\Controllers\Auth;

use App\User;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\JWTGuard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\SessionGuard;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Modules\SuperAdmin\Events\NotificationEvent;
use App\Modules\SuperAdmin\Events\NotificationEvents;

class LoginController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;
  private $apiToken;
  private $authSuccess = false;
  private $authGuard;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest:' . collect(config('auth.guards'))->keys()->implode(','))->except('logout');
  }

  static function routes()
  {
    Route::group(['middleware' => 'web', 'namespace' => '\App\Modules\AppUser\Http\Controllers\Auth'], function () {
      Route::get('/login', [LoginController::class, 'showLoginForm'])->name('app.login.show');
      Route::post('login', [LoginController::class, 'login'])->name('app.login');
      Route::post('logout', [LoginController::class, 'logout'])->name('app.logout');
    });
  }

  public function showLoginForm(Request $request)
  {
    if ($request->isApi())  return 'Welcome to ' . config('app.name') . ' API';
    return Inertia::render('AppUser,Auth/Login');
  }

  /**
   * Handle a login request to the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function login(Request $request)
  {
    $this->validateLogin($request);

    if (
      method_exists($this, 'hasTooManyLoginAttempts') &&
      $this->hasTooManyLoginAttempts($request)
    ) {
      $this->fireLockoutEvent($request);

      return $this->sendLockoutResponse($request);
    }

    if ($this->attemptLogin($request)) {
      event(NotificationEvents::LOGGED_IN, new NotificationEvent($this->authenticatedGuard()->user()));
      return $this->sendLoginResponse($request);
    }

    $this->incrementLoginAttempts($request);

    return $this->sendFailedLoginResponse($request);
  }

  /**
   * Log the user out of the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function logout(Request $request)
  {
    $this->authenticatedGuard()->logout();
    collect(config('auth.guards'))->each(function ($details, $guard) {
      try {
        auth($guard)->logout();
      } catch (\Throwable $th) {
      }
    });
    $request->session()->invalidate();

    if ($request->isApi()) return response()->json(['LOGGED_OUT' => true], 200);
    return redirect()->route('app.login.show');
  }


  /**
   * Attempt to log the user into the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return bool
   */
  protected function attemptLogin()
  {
    collect(config('auth.guards'))->each(function ($details, $guard) {
      try {
        if ($this->attemptGuardLogin($guard)) {
          $this->authSuccess = true;
        }
      } catch (\Throwable $th) {
        ErrLog::notifyAdminAndFail(SuperAdmin::find(1), $th, 'Login Error');
        abort(500, 'Sorry there was an error logging you in.');
      }
    });
    return $this->authSuccess;
  }

  private function attemptGuardLogin(string $guard)
  {
    if (Auth::guard($guard)->attempt($this->credentials(request()), request()->filled('remember'))) {
      if (Arr::has(config('auth.guards'), $guard . '_api')) {
        $this->apiToken = Auth::guard($guard . '_api')->attempt($this->credentials(request()));
      }
      return true;
    }
  }

  /**
   * Send the response after the user was authenticated.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  protected function sendLoginResponse(Request $request)
  {
    $request->session()->regenerate();

    $this->clearLoginAttempts($request);
    if ($response = $this->authenticated($request, $this->authenticatedGuard()->user())) {
      return $response;
    }

    return $request->isApi() ? new Response('', 204) : redirect()->intended(route($this->authenticatedGuard()->user()->dashboardRoute()));
  }

  /**
   * The user has been authenticated.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App|User  $user
   * @return mixed
   */
  protected function authenticated(Request $request, User $user)
  {
    if ($user->isAppUser()) {
      redirect()->intended(route($user->dashboardRoute()));
    } else {
      if ($user->is_verified()) {
        if ($request->isApi()) return response()->json($this->respondWithToken(), 202);
        return redirect()->intended(route($user->dashboardRoute()))->withSuccess(202);
      } else {
        // $this->logout($request);
        if ($request->isApi()) return response()->json(['unverified' => 'Unverified user'], 401);

        /**
         * ?Watch out for this 401 on the client side and trigger a password reset
         */
        return back()->withError(401);
      }
    }
  }

  /**
   * Get the login username to be used by the controller.
   *
   * @return string
   */
  public function username(): string
  {
    return 'email';
  }

  /**
   * Get the guard to be used during authentication.
   *
   * @return \Illuminate\Contracts\Auth\StatefulGuard
   */
  protected function guard()
  {
    return Auth::guard('app_user');
  }

  protected function apiGuard(): JWTGuard
  {
    return Auth::guard('api');
  }

  protected function authenticatedGuard(): ?SessionGuard
  {
    collect(config('auth.guards'))->each(function ($details, $guard) {
      if (Auth($guard)->check()) {
        $this->authGuard = Auth::guard($guard);
        return false;
      }
    });
    return $this->authGuard;
  }

  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return array api jwt token details
   */
  protected function respondWithToken()
  {
    return [
      'access_token' => $this->apiToken,
      'token_type' => 'bearer',
      'expires_in' => $this->apiGuard()->factory()->getTTL() * 60
    ];
  }
}
