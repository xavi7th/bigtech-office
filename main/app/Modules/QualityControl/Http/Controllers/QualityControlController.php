<?php

namespace App\Modules\QualityControl\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\QualityControl\Models\QualityControl;
use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Models\ProductExpense;
use App\Modules\SuperAdmin\Models\SwapDeal;

class QualityControlController extends Controller
{

  static function routes()
  {
    Route::group(['middleware' => ['web'], 'namespace' => '\App\Modules\QualityControl\Http\Controllers'], function () {
      Route::prefix(QualityControl::DASHBOARD_ROUTE_PREFIX)->group(function () {

        Route::group(['middleware' => ['auth:quality_control']], function () {
          Route::get('/', [self::class, 'index'])->name('qualitycontrol.dashboard')->defaults('ex', __e('q', 'home', true));

          ProductExpense::qualityControlRoutes();
          Product::qualityControlRoutes();
          SwapDeal::qualityControlRoutes();
        });

        Product::multiAccessRoutes();
        SwapDeal::multiAccessRoutes();
        ProductBatch::multiAccessRoutes();
        ProductExpense::multiAccessRoutes();
      });
    });
  }


  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    return Inertia::render('QualityControl,QualityControlDashboard');
  }
}
