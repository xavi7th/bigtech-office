<?php

namespace App\Modules\SuperAdmin\Models;

use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Modules\Auditor\Models\Auditor;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Transformers\AdminUserTransformer;

/**
 * App\Modules\SuperAdmin\Models\SuperAdmin
 *
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
 * @property-write mixed $password
 * @method static Builder|SuperAdmin newModelQuery()
 * @method static Builder|SuperAdmin newQuery()
 * @method static Builder|SuperAdmin query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string|null $phone
 * @property string|null $avatar
 * @property string|null $gender
 * @property string|null $address
 * @property int $office_branch_id
 * @property string|null $verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static Builder|SuperAdmin whereAddress($value)
 * @method static Builder|SuperAdmin whereAvatar($value)
 * @method static Builder|SuperAdmin whereCreatedAt($value)
 * @method static Builder|SuperAdmin whereDeletedAt($value)
 * @method static Builder|SuperAdmin whereEmail($value)
 * @method static Builder|SuperAdmin whereFullName($value)
 * @method static Builder|SuperAdmin whereGender($value)
 * @method static Builder|SuperAdmin whereId($value)
 * @method static Builder|SuperAdmin whereOfficeBranchId($value)
 * @method static Builder|SuperAdmin wherePassword($value)
 * @method static Builder|SuperAdmin wherePhone($value)
 * @method static Builder|SuperAdmin whereRememberToken($value)
 * @method static Builder|SuperAdmin whereUpdatedAt($value)
 * @method static Builder|SuperAdmin whereVerifiedAt($value)
 */
class SuperAdmin extends User
{
  protected $fillable = [];
  protected $table = 'he_control';
  const DASHBOARD_ROUTE_PREFIX = 'super-panel';

  public function is_verified()
  {
    return true;
  }


  static function auditorRoutes()
  {
    Route::group(['namespace' => '\App\Modules\Auditor\Models'], function () {
      Route::get('auditors', 'Auditor@getAllAuditors')->middleware('auth:auditor,normal_auditor');

      Route::post('auditor/create', 'Auditor@createAuditorAccount')->middleware('auth:auditor');

      Route::get('auditor/{auditor}/permissions', 'Auditor@getAuditorPermittedRoutes')->middleware('auth:auditor');

      Route::put('auditor/{auditor}/permissions', 'Auditor@editAuditorPermittedRoutes')->middleware('auth:auditor');

      Route::put('auditor/{auditor}/suspend', 'Auditor@suspendAuditorAccount')->middleware('auth:auditor');

      Route::put('auditor/{id}/restore', 'Auditor@restoreAuditorAccount')->middleware('auth:auditor');

      Route::delete('auditor/{auditor}/delete', 'Auditor@deleteAuditorAccount')->middleware('auth:auditor');
    });
  }

  public function getAllAuditors()
  {
    return (new AuditorUserTransformer)->collectionTransformer(Auditor::withTrashed()->get(), 'transformForAuditorViewAuditors');
  }

  public function createAuditorAccount()
  {
    try {
      DB::beginTransaction();
      $auditor = Auditor::create(Arr::collapse([
        request()->all(),
        [
          'password' => bcrypt('itsefintech@auditor'),
        ]
      ]));

      ActivityLog::notifySuperAdmins(auth()->user()->email . ' created a new auditor account for ' . $auditor->email);

      DB::commit();
      return response()->json(['rsp' => $auditor], 201);
    } catch (\Throwable $e) {
      if (app()->environment() == 'local') {
        return response()->json(['error' => $e->getMessage()], 500);
      }
      return response()->json(['rsp' => 'error occurred'], 500);
    }
  }

  public function suspendAuditorAccount(Auditor $auditor)
  {
    if ($auditor->id === auth()->id()) {
      return response()->json(['rsp' => false], 403);
    }
    $auditor->delete();
    ActivityLog::notifySuperAdmins(auth()->user()->email . ' suspended the account of ' . $auditor->email);
    return response()->json(['rsp' => true], 204);
  }

  public function restoreAuditorAccount($id)
  {
    $auditor = Auditor::withTrashed()->find($id);
    $auditor->restore();

    ActivityLog::notifySuperAdmins(auth()->user()->email . ' restored the account of ' . $auditor->email);

    return response()->json(['rsp' => true], 204);
  }

  public function deleteAuditorAccount(Auditor $auditor)
  {
    if ($auditor->id === auth()->id()) {
      return response()->json(['rsp' => false], 403);
    }
    /** log the activity before deleting */
    ActivityLog::notifySuperAdmins(auth()->user()->email . ' permanently deleted the account of ' . $auditor->email);

    $auditor->forceDelete();

    return response()->json(['rsp' => true], 204);
  }

  protected static function booted()
  {
    static::addGlobalScope('safeRecords', function (Builder $builder) {
      $builder->where('id', '>', 1);
    });
  }
}
