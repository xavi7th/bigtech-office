<?php

namespace App\Modules\SalesRep\Models;

use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Models\StockRequest;
use App\Modules\SuperAdmin\Transformers\AdminUserTransformer;

class SalesRep extends User
{
  protected $fillable = [
    'role_id', 'full_name', 'email', 'password', 'phone', 'user_passport', 'gender', 'address',
  ];
  protected $dates = ['dob'];
  const DASHBOARD_ROUTE_PREFIX = 'sales-reps';


  public function is_verified()
  {
    return $this->verified_at !== null;
  }


  public function stock_request()
  {
    return $this->hasOne(StockRequest::class);
  }


  static function adminRoutes()
  {
    Route::group(['namespace' => '\App\Modules\SalesRep\Models'], function () {
      Route::get('sales-reps', 'SalesRep@getAllSalesReps')->middleware('auth:admin');

      Route::post('sales-rep/create', 'SalesRep@createSalesRep')->middleware('auth:admin');

      Route::get('sales-rep/{sales_rep}/permissions', 'SalesRep@getSalesRepPermissions')->middleware('auth:admin');

      Route::put('sales-rep/{sales_rep}/permissions', 'SalesRep@editSalesRepPermissions')->middleware('auth:admin');

      Route::put('sales-rep/{sales_rep}/suspend', 'SalesRep@suspendSalesRep')->middleware('auth:admin');

      Route::put('sales-rep/{id}/restore', 'SalesRep@restoreSalesRep')->middleware('auth:admin');

      Route::delete('sales-rep/{sales_rep}/delete', 'SalesRep@deleteSalesRep')->middleware('auth:admin');
    });
  }

  static function salesRepRoutes()
  {
    Route::group(['middleware' => ['auth:sales_rep', 'sales_reps'], 'namespace' => '\App\Modules\SalesRep\Models'], function () {

      Route::group(['prefix' => 'api'], function () {
        Route::post('test-route-permission', 'SalesRep@testRoutePermission');

        Route::get('statistics', 'SalesRep@getDashboardStatistics')->middleware('auth:sales_rep');
      });

      Route::get('/{subcat?}', 'SalesRep@loadSalesRepApplication')->name('salesrep.dashboard')->where('subcat', '^((?!(api)).)*');
    });
  }

  public function loadSalesRepApplication()
  {
    return view('salesrep::index');
  }

  public function getDashboardStatistics()
  {
    return [];
  }

  public function getAllSalesReps()
  {
    return (new AdminUserTransformer)->collectionTransformer(self::withTrashed()->get(), 'transformForAdminViewSalesReps');
  }

  public function createSalesRep()
  {
    try {
      DB::beginTransaction();
      $sales_rep = self::create(Arr::collapse([
        request()->all(),
        [
          'password' => bcrypt('itsefintech@sales_rep'),
        ]
      ]));

      DB::commit();

      ActivityLog::logAdminActivity(auth()->user()->email . ' created a sales rep account for ' . $sales_rep->email);

      return response()->json(['rsp' => $sales_rep], 201);
    } catch (Throwable $e) {
      if (app()->environment() == 'local') {
        return response()->json(['error' => $e->getMessage()], 500);
      }
      return response()->json(['rsp' => 'error occurred'], 500);
    }
  }
  public function suspendSalesRep(self $sales_rep)
  {
    ActivityLog::logAdminActivity(auth()->user()->email . ' suspended the account of ' . $sales_rep->email);

    $sales_rep->delete();

    return response()->json(['rsp' => true], 204);
  }

  public function restoreSalesRep($id)
  {
    $sales_rep = self::withTrashed()->find($id);

    $sales_rep->restore();

    ActivityLog::logAdminActivity(auth()->user()->email . ' restored the account of ' . $sales_rep->email);

    return response()->json(['rsp' => true], 204);
  }

  public function deleteSalesRep(self $sales_rep)
  {
    ActivityLog::logAdminActivity(auth()->user()->email . ' permanently deleted the account of ' . $sales_rep->email);

    $sales_rep->forceDelete();

    return response()->json(['rsp' => true], 204);
  }
}
