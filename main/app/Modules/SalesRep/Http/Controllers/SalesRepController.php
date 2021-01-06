<?php

namespace App\Modules\SalesRep\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\SwapDeal;
use App\Modules\SalesRep\Models\ProductDispatchRequest;
use App\Modules\SalesRep\Transformers\SalesRepTransformer;
use App\Modules\SuperAdmin\Models\SuperAdmin;

class SalesRepController extends Controller
{
  static function routes()
  {
    Route::group(['middleware' => ['web'], 'prefix' => SalesRep::DASHBOARD_ROUTE_PREFIX], function () {
      Route::group(['middleware' => ['auth:sales_rep']], function () {
        Route::get('/', [self::class, 'index'])->name('salesrep.dashboard')->defaults('ex', __e('s', 'home', true));

        ProductDispatchRequest::salesRepRoutes();
      });

      Route::name('salesrep.')->group(function () {
        Product::multiAccessRoutes();
        SwapDeal::multiAccessRoutes();
      });
    });
  }

  public function index(Request $request)
  {
    return Inertia::render('SalesRep,SalesRepDashboard', [
      'salesStatistics' => (new SalesRepTransformer)->transformForSalesRepsDashboard($request->user()->loadCount([
        'walkInSalesRecords',
        'onlineSalesRecords',
        'onlineSalesRecords AS total_online_sales_amount' => fn ($query) => $query->select(DB::raw('SUM(selling_price)')),
        'walkInSalesRecords AS total_walk_in_sales_amount' => fn ($query) => $query->select(DB::raw('SUM(selling_price)')),
        'onlineSalesRecords AS monthly_online_sales_amount' => fn ($query) => $query->thisMonth()->select(DB::raw('SUM(selling_price)')),
        'walkInSalesRecords AS monthly_walk_in_sales_amount' => fn ($query) => $query->thisMonth()->select(DB::raw('SUM(selling_price)')),
        'onlineSalesRecords AS monthly_online_sales_bonus_amount' => fn ($query) => $query->thisMonth()->select(DB::raw('SUM(online_rep_bonus)')),
        'walkInSalesRecords AS monthly_walk_in_sales_bonus_amount' => fn ($query) => $query->thisMonth()->select(DB::raw('SUM(walk_in_rep_bonus)')),
        'onlineSalesRecords AS monthly_online_sales_count' => fn ($query) => $query->thisMonth(),
        'walkInSalesRecords AS monthly_walk_in_sales_count' => fn ($query) => $query->thisMonth(),
        'onlineSalesRecords AS today_online_sales_count' => fn ($query) => $query->today(),
        'walkInSalesRecords AS today_walk_in_sales_count' => fn ($query) => $query->today(),
        'onlineSalesRecords AS today_online_sales_amount' => fn ($query) => $query->today()->select(DB::raw('SUM(selling_price)')),
        'walkInSalesRecords AS today_walk_in_sales_amount' => fn ($query) => $query->today()->select(DB::raw('SUM(selling_price)')),
        'onlineSalesRecords AS today_online_sales_bonus_amount' => fn ($query) => $query->today()->select(DB::raw('SUM(online_rep_bonus)')),
        'walkInSalesRecords AS today_walk_in_sales_bonus_amount' => fn ($query) => $query->today()->select(DB::raw('SUM(walk_in_rep_bonus)')),
      ]))
    ]);
  }
}
