<?php

namespace App\Modules\Accountant\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\Accountant\Models\Accountant;

class AccountantController extends Controller
{

  static function routes()
  {
    Route::group(['middleware' => ['web', 'auth:accountant']], function () {
      Route::prefix(Accountant::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::get('/', [self::class, 'index'])->name('accountant.dashboard')->defaults('ex', __e('a', 'home', true));
      });
    });
  }


  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    return Inertia::render('Accountant,App');
  }
}
