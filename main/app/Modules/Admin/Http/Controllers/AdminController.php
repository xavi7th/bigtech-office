<?php

namespace App\Modules\Admin\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Modules\Admin\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class AdminController extends Controller
{
  static function routes()
  {
    Route::group(['middleware' => ['web', 'auth:admin'], 'namespace' => '\App\Modules\Admin\Http\Controllers'], function () {
      Route::prefix(Admin::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::get('/', 'AdminController@index')->name('admin.dashboard');
      });
    });
  }


  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    return Inertia::render('Admin,App', [
      'event' => $request->only(
        'id',
        'title',
        'start_date',
        'description'
      ),
    ]);
  }
}
