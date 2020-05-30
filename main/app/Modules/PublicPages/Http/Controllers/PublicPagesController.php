<?php

namespace App\Modules\PublicPages\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\AppUser\Http\Controllers\LoginController;

class PublicPagesController extends Controller
{
  public function __construct()
  {
    Inertia::setRootView('publicpages::app');
  }

  static function routes()
  {
    LoginController::routes();

    Route::group(['middleware' => 'web', 'namespace' => '\App\Modules\PublicPages\Http\Controllers'], function () {
      Route::get('/', [PublicPagesController::class, 'index'])->name('app.home');
    });
  }

  public function index(Request $request)
  {
    return Inertia::render('Home', [
      'event' => 'bar'
    ]);
  }
}
