<?php

namespace App\Modules\SalesRep\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\SalesRep\Models\ProductDispatchRequest;
use Illuminate\Support\Facades\Route;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\SwapDeal;

class SalesRepController extends Controller
{
  static function routes()
  {
    Route::group(['middleware' => ['web'], 'prefix' => SalesRep::DASHBOARD_ROUTE_PREFIX], function () {
      Route::group(['middleware' => ['auth:sales_rep']], function () {
        Route::get('/', [self::class, 'index'])->name('salesrep.dashboard')->defaults('ex', __e('s', 'home', true));

        ProductDispatchRequest::salesRepRoutes();
      });

      Product::multiAccessRoutes();
      SwapDeal::multiAccessRoutes();
    });
  }

  public function index(Request $request)
  {
    return Inertia::render('SalesRep,SalesRepDashboard');
  }
}
