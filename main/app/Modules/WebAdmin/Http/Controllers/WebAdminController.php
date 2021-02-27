<?php

namespace App\Modules\WebAdmin\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\QATest;
use App\Modules\WebAdmin\Models\WebAdmin;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\Reseller;
use App\Modules\SuperAdmin\Models\SwapDeal;
use App\Modules\SuperAdmin\Models\StorageSize;
use App\Modules\SuperAdmin\Models\StorageType;
use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Models\ProductBrand;
use App\Modules\SuperAdmin\Models\ProductColor;
use App\Modules\SuperAdmin\Models\ProductGrade;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Models\SalesChannel;
use App\Modules\SuperAdmin\Models\ProcessorSpeed;
use App\Modules\SuperAdmin\Models\ProductHistory;
use App\Modules\SuperAdmin\Models\ProductCategory;
use App\Modules\SalesRep\Models\ProductDispatchRequest;
use App\Modules\SuperAdmin\Models\ProductDescriptionSummary;


class WebAdminController extends Controller
{
  static function routes()
  {
    Route::group(['middleware' => ['web']], function () {
      Route::prefix(WebAdmin::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::group(['middleware' => ['auth:web_admin']], function () {
          Route::get('/', [self::class, 'index'])->name('webadmin.dashboard')->defaults('ex', __e('w', 'home', true));

          Product::webAdminRoutes();
          SwapDeal::webAdminRoutes();
          ProductDispatchRequest::webAdminRoutes();
        });

        Route::name('webadmin.')->group(function () {
          Product::multiAccessRoutes();
          ProductModel::multiAccessRoutes();
          ProductBrand::multiAccessRoutes();
          ProductDescriptionSummary::multiAccessRoutes();
          SwapDeal::multiAccessRoutes();
          ProductHistory::multiAccessRoutes();
          ProductBatch::multiAccessRoutes();
          Reseller::multiAccessRoutes();
          ProductColor::multiAccessRoutes();
          ProductGrade::multiAccessRoutes();
          ProductCategory::multiAccessRoutes();
          SalesChannel::multiAccessRoutes();
          QATest::multiAccessRoutes();
          ProcessorSpeed::multiAccessRoutes();
          StorageSize::multiAccessRoutes();
          StorageType::multiAccessRoutes();
          ProductDescriptionSummary::multiAccessRoutes();
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
    // dd(collect(\Illuminate\Support\Facades\Route::getRoutes()->getRoutesByName()));
    return Inertia::render('WebAdmin,WebAdminDashboard');
  }
}
