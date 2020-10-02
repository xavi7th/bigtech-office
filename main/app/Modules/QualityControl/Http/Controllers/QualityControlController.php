<?php

namespace App\Modules\QualityControl\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Modules\QualityControl\Models\QualityControl;
use Illuminate\Support\Facades\Route;

class QualityControlController extends Controller
{

  public function __construct()
  {
    Inertia::setRootView('quality_control::app');
  }

  static function routes()
  {
    Route::group(['middleware' => ['web', 'auth:quality_control'], 'namespace' => '\App\Modules\QualityControl\Http\Controllers'], function () {
      Route::prefix(QualityControl::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::get('/', 'QualityControlController@index')->name('quality-control.dashboard');
      });
    });
  }


  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    return Inertia::render('QualityControl,App', [
      'event' => $request->only(
        'id',
        'title',
        'start_date',
        'description'
      ),
    ]);
  }
}
