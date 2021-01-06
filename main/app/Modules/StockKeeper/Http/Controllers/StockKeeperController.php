<?php

namespace App\Modules\StockKeeper\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\Reseller;
use App\Modules\StockKeeper\Models\StockKeeper;
use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Models\ProductExpense;
use App\Modules\SuperAdmin\Models\SwapDeal;

class StockKeeperController extends Controller
{
  static function routes()
  {
    Route::group(['middleware' => ['web']], function () {

      Route::prefix(StockKeeper::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::group(['middleware' => ['auth:stock_keeper']], function () {

          Route::get('/', [self::class, 'index'])->name('stockkeeper.dashboard')->defaults('ex', __e('sk', 'home', true));
          Reseller::stockKeeperRoutes();
          Product::stockKeeperRoutes();
          SwapDeal::stockKeeperRoutes();
        });

        Route::name('stockkeeper.')->group(function () {
          Product::multiAccessRoutes();
          SwapDeal::multiAccessRoutes();
          ProductBatch::multiAccessRoutes();
          ProductExpense::multiAccessRoutes();
          Reseller::multiAccessRoutes();
        });
      });
    });
  }


  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    return Inertia::render('StockKeeper,StockKeeperDashboard');
  }
}
