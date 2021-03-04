<?php

namespace App\Modules\Accountant\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\Reseller;
use App\Modules\SuperAdmin\Models\SwapDeal;
use App\Modules\Accountant\Models\Accountant;
use App\Modules\AppUser\Models\ProductReceipt;
use App\Modules\SuperAdmin\Models\OfficeBranch;
use App\Modules\SuperAdmin\Models\OtherExpense;
use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Models\ProductPrice;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\ProductExpense;
use App\Modules\SuperAdmin\Models\ProductHistory;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;

class AccountantController extends Controller
{

  static function routes()
  {
    Route::group(['middleware' => ['web']], function () {
      Route::prefix(Accountant::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::group(['middleware' => ['auth:accountant']], function () {
          Route::get('/', [self::class, 'index'])->name('accountant.dashboard')->defaults('ex', __e('ac', 'home', true));
          Reseller::accountantRoutes();
          Product::accountantRoutes();
          SwapDeal::accountantRoutes();
          ProductSaleRecord::accountantRoutes();
          ProductPrice::accountantRoutes();
          ProductBatch::accountantRoutes();
        });

        Route::name('accountant.')->group(function () {
          Product::multiAccessRoutes();
          SwapDeal::multiAccessRoutes();
          ProductHistory::multiAccessRoutes();
          ProductBatch::multiAccessRoutes();
          ProductExpense::multiAccessRoutes();
          ProductSaleRecord::multiAccessRoutes();
          OtherExpense::multiAccessRoutes();
          Reseller::multiAccessRoutes();
          ProductReceipt::multiAccessRoutes();
          OfficeBranch::multiAccessRoutes();
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
    return Inertia::render('Accountant,AccountantDashboard', [
      'products_in_posession' => Product::whereProductStatusId(ProductStatus::justArrivedId())->count(),
      'pending_confirmations' => Product::whereProductStatusId($sold_id = ProductStatus::soldId())->orWhere('product_status_id', ProductStatus::soldByResellerId())->count(),
      'pending_local_products' => Product::whereIsLocal(true)->whereIsPaid(false)->count(),
      'swap_deals_in_stock' => SwapDeal::whereProductStatusId($sold_id)->count(),
      'products_with_resellers' => Product::whereProductStatusId(ProductStatus::withResellerId())->count(),
    ]);
  }
}
