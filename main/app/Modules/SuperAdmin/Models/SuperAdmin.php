<?php

namespace App\Modules\SuperAdmin\Models;

use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Transformers\AdminUserTransformer;

/**
 * App\Modules\SuperAdmin\Models\SuperAdmin
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property string|null $user_passport
 * @property string|null $gender
 * @property string|null $address
 * @property int $office_branch_id
 * @property string|null $verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ActivityLog[] $activities
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin whereOfficeBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin whereUserPassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SuperAdmin whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class SuperAdmin extends User
{
  protected $fillable = [];
  protected $table = 'trusted_romzy';
  const DASHBOARD_ROUTE_PREFIX = 'super-panel';

  public function is_verified()
  {
    return true;
  }


  static function adminRoutes()
  {
    Route::group(['namespace' => '\App\Modules\Admin\Models'], function () {
      Route::get('admins', 'Admin@getAllAdmins')->middleware('auth:admin,normal_admin');

      Route::post('admin/create', 'Admin@createAdminAccount')->middleware('auth:admin');

      Route::get('admin/{admin}/permissions', 'Admin@getAdminPermittedRoutes')->middleware('auth:admin');

      Route::put('admin/{admin}/permissions', 'Admin@editAdminPermittedRoutes')->middleware('auth:admin');

      Route::put('admin/{admin}/suspend', 'Admin@suspendAdminAccount')->middleware('auth:admin');

      Route::put('admin/{id}/restore', 'Admin@restoreAdminAccount')->middleware('auth:admin');

      Route::delete('admin/{admin}/delete', 'Admin@deleteAdminAccount')->middleware('auth:admin');
    });
  }

  public function getAllAdmins()
  {
    return (new AdminUserTransformer)->collectionTransformer(Admin::withTrashed()->get(), 'transformForAdminViewAdmins');
  }

  public function createAdminAccount()
  {
    try {
      DB::beginTransaction();
      $admin = Admin::create(Arr::collapse([
        request()->all(),
        [
          'password' => bcrypt('itsefintech@admin'),
        ]
      ]));

      ActivityLog::notifySuperAdmins(auth()->user()->email . ' created a new admin account for ' . $admin->email);

      DB::commit();
      return response()->json(['rsp' => $admin], 201);
    } catch (\Throwable $e) {
      if (app()->environment() == 'local') {
        return response()->json(['error' => $e->getMessage()], 500);
      }
      return response()->json(['rsp' => 'error occurred'], 500);
    }
  }

  public function suspendAdminAccount(Admin $admin)
  {
    if ($admin->id === auth()->id()) {
      return response()->json(['rsp' => false], 403);
    }
    $admin->delete();
    ActivityLog::notifySuperAdmins(auth()->user()->email . ' suspended the account of ' . $admin->email);
    return response()->json(['rsp' => true], 204);
  }

  public function restoreAdminAccount($id)
  {
    $admin = Admin::withTrashed()->find($id);
    $admin->restore();

    ActivityLog::notifySuperAdmins(auth()->user()->email . ' restored the account of ' . $admin->email);

    return response()->json(['rsp' => true], 204);
  }

  public function deleteAdminAccount(Admin $admin)
  {
    if ($admin->id === auth()->id()) {
      return response()->json(['rsp' => false], 403);
    }
    /** log the activity before deleting */
    ActivityLog::notifySuperAdmins(auth()->user()->email . ' permanently deleted the account of ' . $admin->email);

    $admin->forceDelete();

    return response()->json(['rsp' => true], 204);
  }
}
