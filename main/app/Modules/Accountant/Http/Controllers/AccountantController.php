<?php

namespace App\Modules\Accountant\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\Accountant\Models\Accountant;
use App\Modules\SuperAdmin\Models\OtherExpense;
use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Models\ProductExpense;
use App\Modules\SuperAdmin\Models\ProductHistory;
use App\Modules\SuperAdmin\Models\ProductPrice;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Models\Reseller;
use App\Modules\SuperAdmin\Models\SwapDeal;

class AccountantController extends Controller
{

  static function routes()
  {
    Route::group(['middleware' => ['web']], function () {
      Route::prefix(Accountant::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::group(['middleware' => ['auth:accountant']], function () {
          Route::get('/', [self::class, 'index'])->name('accountant.dashboard')->defaults('ex', __e('ac', 'home', true));
          Product::accountantRoutes();
          OtherExpense::accountantRoutes();
          SwapDeal::accountantRoutes();
          ProductSaleRecord::accountantRoutes();
          ProductPrice::accountantRoutes();
          ProductBatch::accountantRoutes();
        });
        Route::name('acccountant.')->group(function () {
          Product::multiAccessRoutes();
          SwapDeal::multiAccessRoutes();
          ProductHistory::multiAccessRoutes();
          ProductBatch::multiAccessRoutes();
          ProductExpense::multiAccessRoutes();
          ProductSaleRecord::multiAccessRoutes();
          OtherExpense::multiAccessRoutes();
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
    // dd($request->user());
    return Inertia::render('Accountant,AccountantDashboard');
  }
}
