<?php

namespace App\Modules\DispatchAdmin\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\DispatchAdmin\Models\DispatchAdmin;

class DispatchAdminController extends Controller
{

  static function routes()
  {
    Route::group(['middleware' => ['web', 'auth:dispatch_admin']], function () {
      Route::prefix(DispatchAdmin::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::get('/', [self::class, 'index'])->name('dispatchadmin.dashboard')->defaults('ex', __e('d', 'home', true));

        Product::multiAccessRoutes();
      });
    });
  }


  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    return Inertia::render('DispatchAdmin,DispatchAdminDashboard');
  }
}
