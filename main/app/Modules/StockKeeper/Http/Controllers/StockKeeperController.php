<?php

namespace App\Modules\StockKeeper\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Modules\StockKeeper\Models\StockKeeper;
use Illuminate\Support\Facades\Route;

class StockKeeperController extends Controller
{

  static function routes()
  {
    Route::group(['middleware' => ['web', 'auth:admin'], 'namespace' => '\App\Modules\StockKeeper\Http\Controllers'], function () {
      Route::prefix(StockKeeper::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::get('/', 'StockKeeperController@index')->name('admin.dashboard');
      });
    });
  }


  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    return Inertia::render('StockKeeper,App', [
      'event' => $request->only(
        'id',
        'title',
        'start_date',
        'description'
      ),
    ]);
  }
}
