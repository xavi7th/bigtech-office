<?php

namespace App\Modules\Admin\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Modules\Admin\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\Product;

class AdminController extends Controller
{
  static function routes()
  {
    Route::group(['middleware' => ['web', 'auth:admin']], function () {
      Route::prefix(Admin::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::get('/', [self::class, 'index'])->name('admin.dashboard')->defaults('ex', __e('a', 'home', true));

        Product::multiAccessRoutes();
      });
    });
  }


  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    return Inertia::render('Admin,AdminDashboard');
  }
}
