<?php

namespace App\Modules\StockKeeper\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class StockKeeperController extends Controller
{
  static function routes()
  {
    Route::group(['middleware' => ['web']], function () {
      // Route::prefix(StockKeeper::DASHBOARD_ROUTE_PREFIX)->group(function () {
      //   Route::group(['middleware' => ['auth:stock_keeper']], function () {
      //     Route::get('/', [self::class, 'index'])->name('stockkeeper.dashboard')->defaults('ex', __e('sk', 'home', true));
      //   });
      // });
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
