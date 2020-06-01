<?php

namespace App\Modules\AppUser\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Http\Controllers\Auth\LoginController;
use App\Modules\AppUser\Http\Controllers\Auth\RegisterController;

class AppUserController extends Controller
{
  public function __construct()
  {
    Inertia::setRootView('appuser::app');
  }


  static function routes()
  {
    LoginController::routes();
    RegisterController::routes();
    // ResetPasswordController::routes();
    // ForgotPasswordController::routes();
    // ConfirmPasswordController::routes();
    // VerificationController::routes();

    Route::group(['middleware' => ['web', 'auth'], 'namespace' => '\App\Modules\AppUser\Http\Controllers'], function () {
      Route::prefix(AppUser::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::get('/', 'AppUserController@index')->name('appuser.dashboard');
      });
    });
  }

  public function index(Request $request)
  {
    Auth::logout();
    return Inertia::render('Welcome');
  }
}
