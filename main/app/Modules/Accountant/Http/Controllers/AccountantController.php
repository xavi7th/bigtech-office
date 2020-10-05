<?php

namespace App\Modules\Accountant\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Modules\Accountant\Models\Accountant;
use Illuminate\Support\Facades\Route;

class AccountantController extends Controller
{

  static function routes()
  {
    Route::group(['middleware' => ['web', 'auth:admin'], 'namespace' => '\App\Modules\Accountant\Http\Controllers'], function () {
      Route::prefix(Accountant::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::get('/', 'AccountantController@index')->name('admin.dashboard');
      });
    });
  }


  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    return Inertia::render('Accountant,App', [
      'event' => $request->only(
        'id',
        'title',
        'start_date',
        'description'
      ),
    ]);
  }
}
