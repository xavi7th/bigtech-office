<?php

namespace App\Modules\StockKeeper\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\StockKeeper\Models\StockKeeper;


class StockKeeperController extends Controller
{
  static function routes()
  {
    Route::group(['middleware' => ['web', 'auth:stockkeeper']], function () {
      Route::prefix(StockKeeper::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::get('/', [self::class, 'index'])->name('stockkeeper.dashboard')->defaults('ex', __e('a', 'home', true));

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
    return Inertia::render('StockKeeper,StockKeeperDashboard');
  }
}
