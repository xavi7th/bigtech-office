<?php

namespace App\Modules\WebAdmin\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\ProductBrand;
use App\Modules\SuperAdmin\Models\ProductDescriptionSummary;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\WebAdmin\Models\WebAdmin;


class WebAdminController extends Controller
{
  static function routes()
  {
    Route::group(['middleware' => ['web']], function () {
      Route::prefix(WebAdmin::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::group(['middleware' => ['auth:web_admin']], function () {
          Route::get('/', [self::class, 'index'])->name('webadmin.dashboard')->defaults('ex', __e('w', 'home', true));
        });
        Product::multiAccessRoutes();
        ProductModel::multiAccessRoutes();
        ProductBrand::multiAccessRoutes();
        ProductDescriptionSummary::multiAccessRoutes();
      });
    });
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    return Inertia::render('WebAdmin,WebAdminDashboard');
  }
}
