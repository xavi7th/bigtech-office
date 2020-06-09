<?php

namespace App\Modules\AppUser\Http\Controllers\Auth;

use App\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Arr;
use App\Modules\SuperAdmin\Events\NotificationEvents;
use App\Modules\SuperAdmin\Events\NotificationEvent;

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

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
    Inertia::setRootView('appuser::app');
  }

  static function routes()
  {
    Route::group(['middleware' => 'web', 'namespace' => '\App\Modules\AppUser\Http\Controllers\Auth'], function () {
      Route::get('/login', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('app.login.show');
      Route::post('login', [LoginController::class, 'login'])->name('app.login');
      Route::post('logout', [LoginController::class, 'logout'])->name('app.logout')->middleware('auth');
    });
  }

  public function showLoginForm(Request $request)
  {
    if ($request->isApi()) {
      return 'Welcome to ' . config('app.name') . ' API';
    } else {
      return Inertia::render('Auth/Login');
    }
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
    $this->guard()->logout();
    $request->session()->invalidate();

    try {
      $this->apiGuard()->logout();
    } catch (\Throwable $e) { }

    if ($request->isApi()) {
      return response()->json(['rsp' => true], 200);
    }
    return redirect()->route('app.login.show');
  }



  /**
   * Attempt to log the user into the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return bool
   */
  protected function attemptLogin(Request $request)
  {
    return $this->attemptGuardLogin('app_user')
      ?? $this->attemptGuardLogin('admin')
      ?? $this->attemptGuardLogin('super_admin')
      ?? false;
  }

  private function attemptGuardLogin(string $guard)
  {
    if (Auth::guard($guard)->attempt($this->credentials(request()), request()->filled('remember'))) {
      if (Arr::has(config('auth.guards'), $guard . '_api')) {
        $this->apiToken = Auth::guard($guard . '_api')->attempt($this->credentials(request()), request()->filled('remember'));
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

    return $request->isApi()
      ? new Response('', 204)
      : redirect()->intended(route($this->authenticatedGuard()->user()->dashboardRoute()));
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
        if ($request->isApi()) {
          return response()->json($this->respondWithToken(), 202);
        }
        return redirect()->intended(route($user->dashboardRoute()));
      } else {
        $this->logout($request);
        if ($request->isApi()) {
          return response()->json(['unverified' => 'Unverified user'], 401);
        }
        return back()->withError(['unverified' => 'Unverified user']);
      }
    }
    return redirect()->route(Admin::dashboardRoute());
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

  protected function apiGuard()
  {
    return Auth::guard('jwt_api');
  }

  protected function authenticatedGuard()
  {
    if (Auth('app_user')->check()) {
      return Auth::guard('app_user');
    } elseif (Auth('admin')->check()) {
      return Auth::guard('admin');
    } elseif (Auth('super_admin')->check()) {
      return Auth::guard('super_admin');
    } else {
      return null;
    }
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
