<?php

namespace App\Modules\DispatchAdmin\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Modules\DispatchAdmin\Models\DispatchAdmin;
use Illuminate\Support\Facades\Route;

class DispatchAdminController extends Controller
{

  static function routes()
  {
    Route::group(['middleware' => ['web', 'auth:dispatch_admin'], 'namespace' => '\App\Modules\DispatchAdmin\Http\Controllers'], function () {
      Route::prefix(DispatchAdmin::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::get('/', 'DispatchAdminController@index')->name('dispatch_admin.dashboard');
      });
    });
  }


  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    return Inertia::render('DispatchAdmin,App', [
      'event' => $request->only(
        'id',
        'title',
        'start_date',
        'description'
      ),
    ]);
  }
}
