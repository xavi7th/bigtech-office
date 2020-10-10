<?php

namespace App\Modules\QualityControl\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\QualityControl\Models\QualityControl;

class QualityControlController extends Controller
{

  static function routes()
  {
    Route::group(['middleware' => ['web', 'auth:quality_control'], 'namespace' => '\App\Modules\QualityControl\Http\Controllers'], function () {
      Route::prefix(QualityControl::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::get('/', [self::class, 'index'])->name('qualitycontrol.dashboard')->defaults('ex', __e('q', 'home', true));

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
    return Inertia::render('QualityControl,AdminDashboard');
  }
}
