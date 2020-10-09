<?php

namespace App\Modules\SalesRep\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\SalesRep\Models\SalesRep;

class SalesRepController extends Controller
{

  static function routes()
  {
    Route::group(['middleware' => ['web', 'auth:sales_rep']], function () {
      Route::prefix(SalesRep::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::get('/', [self::class, 'index'])->name('salesrep.dashboard')->defaults('ex', __e('a', 'home', true));
      });
    });
  }


  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    return Inertia::render('SalesRep,App');
  }
}
