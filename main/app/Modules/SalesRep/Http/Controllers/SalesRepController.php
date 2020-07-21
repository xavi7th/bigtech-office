<?php

namespace App\Modules\SalesRep\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class SalesRepController extends Controller
{
  public static function routes()
  {
    Route::group(['middleware' => 'web', 'prefix' => SalesRep::DASHBOARD_ROUTE_PREFIX], function () {
      LoginController::routes();

      SalesRep::salesRepRoutes();

      StockRequest::salesRepRoutes();
    });
  }
}
