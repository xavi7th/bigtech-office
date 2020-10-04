<?php

namespace App\Modules\WebAdmin\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Modules\WebAdmin\Models\WebAdmin;
use Illuminate\Support\Facades\Route;

class WebAdminController extends Controller
{

  public function __construct()
  {
    Inertia::setRootView('webadmin::app');
  }

  static function routes()
  {
    Route::group(['middleware' => ['web', 'auth:web_admin'], 'namespace' => '\App\Modules\WebAdmin\Http\Controllers'], function () {
      Route::prefix(WebAdmin::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::get('/', 'WebAdminController@index')->name('web-admin.dashboard');
      });
    });
  }


  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    return Inertia::render('WebAdmin,App', [
      'event' => $request->only(
        'id',
        'title',
        'start_date',
        'description'
      ),
    ]);
  }
}
