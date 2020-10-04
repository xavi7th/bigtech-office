<?php

namespace App\Modules\SalesRep\Models;

use App\User;
use Throwable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Models\StockRequest;
use App\Modules\SuperAdmin\Transformers\AdminUserTransformer;

/**
 * App\Modules\SalesRep\Models\SalesRep
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property string|null $avatar
 * @property string|null $gender
 * @property string|null $address
 * @property string $unit
 * @property int $office_branch_id
 * @property string|null $verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\UserComment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\OtherExpense[] $expenses
 * @property-read int|null $expenses_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ProductHistory[] $product_histories
 * @property-read int|null $product_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ResellerHistory[] $reseller_histories
 * @property-read int|null $reseller_histories_count
 * @property-read StockRequest|null $stock_request
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep callCenter()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep socialMedia()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep walkIn()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep whereOfficeBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep whereVerifiedAt($value)
 * @mixin \Eloquent
 * @property int|null $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|SalesRep whereIsActive($value)
 */
class SalesRep extends User
{
  protected $fillable = [
    'role_id', 'full_name', 'email', 'password', 'phone', 'avatar', 'gender', 'address',
  ];
  protected $dates = ['dob'];
  const DASHBOARD_ROUTE_PREFIX = 'sales-reps';

  public function stock_request()
  {
    return $this->hasOne(StockRequest::class);
  }

  public function is_verified(): bool
  {
    return $this->verified_at !== null;
  }

  static function defaultSystemAccountId(): int
  {
    return 1;
  }

  static function adminRoutes()
  {
    Route::group(['namespace' => '\App\Modules\SalesRep\Models'], function () {
      Route::get('sales-reps', 'SalesRep@getAllSalesReps')->middleware('auth:admin');

      Route::post('sales-rep/create', 'SalesRep@createSalesRep')->middleware('auth:admin');

      Route::put('sales-rep/{sales_rep}/suspend', 'SalesRep@suspendSalesRep')->middleware('auth:admin');

      Route::put('sales-rep/{id}/restore', 'SalesRep@restoreSalesRep')->middleware('auth:admin');

      Route::delete('sales-rep/{sales_rep}/delete', 'SalesRep@deleteSalesRep')->middleware('auth:admin');
    });
  }

  static function salesRepRoutes()
  {
    Route::group(['middleware' => ['auth:sales_rep', 'sales_reps'], 'namespace' => '\App\Modules\SalesRep\Models'], function () {
      Route::group(['prefix' => 'api'], function () {
        Route::get('statistics', 'SalesRep@getDashboardStatistics')->middleware('auth:sales_rep');
      });
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

      ActivityLog::logUserActivity(auth()->user()->email . ' created a sales rep account for ' . $sales_rep->email);

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
    ActivityLog::logUserActivity(auth()->user()->email . ' suspended the account of ' . $sales_rep->email);

    $sales_rep->delete();

    return response()->json(['rsp' => true], 204);
  }

  public function restoreSalesRep($id)
  {
    $sales_rep = self::withTrashed()->find($id);

    $sales_rep->restore();

    ActivityLog::logUserActivity(auth()->user()->email . ' restored the account of ' . $sales_rep->email);

    return response()->json(['rsp' => true], 204);
  }

  public function deleteSalesRep(self $sales_rep)
  {
    ActivityLog::logUserActivity(auth()->user()->email . ' permanently deleted the account of ' . $sales_rep->email);

    $sales_rep->forceDelete();

    return response()->json(['rsp' => true], 204);
  }

  public function scopeSocialMedia($query)
  {
    return $query->where('unit', 'social-media');
  }

  public function scopeWalkIn($query)
  {
    return $query->where('unit', 'walk-in');
  }

  public function scopeCallCenter($query)
  {
    return $query->where('unit', 'call-center');
  }
}
