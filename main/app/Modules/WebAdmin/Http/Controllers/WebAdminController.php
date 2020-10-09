<?php

namespace App\Modules\WebAdmin\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\WebAdmin\Models\WebAdmin;

class WebAdminController extends Controller
{

  static function routes()
  {
    Route::group(['middleware' => ['web', 'auth:web_admin']], function () {
      Route::prefix(WebAdmin::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::get('/', [self::class, 'index'])->name('webadmin.dashboard')->defaults('ex', __e('a', 'home', true));
      });
    });
  }


  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    return Inertia::render('WebAdmin,App');
  }
}
