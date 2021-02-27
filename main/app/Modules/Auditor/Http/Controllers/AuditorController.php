<?php

namespace App\Modules\Auditor\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Modules\Auditor\Models\Auditor;
use App\Http\Controllers\Controller;
use App\Modules\SuperAdmin\Models\OtherExpense;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\QATest;
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
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\ProcessorSpeed;
use App\Modules\SuperAdmin\Models\ProductHistory;
use App\Modules\SuperAdmin\Models\ProductCategory;
use App\Modules\SuperAdmin\Models\ProductDescriptionSummary;
use App\Modules\SuperAdmin\Models\SalesChannel;

class AuditorController extends Controller
{
  static function routes()
  {
    Route::group(['middleware' => ['web']], function () {
      Route::prefix(Auditor::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::group(['middleware' => ['auth:auditor']], function () {
          Route::get('/', [self::class, 'index'])->name('auditor.dashboard')->defaults('ex', __e('a', 'home', true));
        });

        Route::name('auditor.')->group(function () {
          Product::multiAccessRoutes();
          ProductHistory::multiAccessRoutes();
          ProductBatch::multiAccessRoutes();
          ProductModel::multiAccessRoutes();
          ProductBrand::multiAccessRoutes();
          SwapDeal::multiAccessRoutes();
          Reseller::multiAccessRoutes();
          ProductColor::multiAccessRoutes();
          ProductGrade::multiAccessRoutes();
          ProductCategory::multiAccessRoutes();
          ProductStatus::multiAccessRoutes();
          SalesChannel::multiAccessRoutes();
          QATest::multiAccessRoutes();
          ProcessorSpeed::multiAccessRoutes();
          StorageSize::multiAccessRoutes();
          StorageType::multiAccessRoutes();
          OtherExpense::multiAccessRoutes();
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
    return Inertia::render('Auditor,AdminDashboard');
  }
}
