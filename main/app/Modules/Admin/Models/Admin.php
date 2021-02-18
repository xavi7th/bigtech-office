<?php

namespace App\Modules\Admin\Models;

use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\SuperAdmin\Models\ActivityLog;

/**
 * App\Modules\Admin\Models\Admin
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $password
 * @property string|null $gender
 * @property int $office_branch_id
 * @property int|null $is_active
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
 * @method static Builder|Admin newModelQuery()
 * @method static Builder|Admin newQuery()
 * @method static Builder|Admin query()
 * @method static Builder|Admin whereCreatedAt($value)
 * @method static Builder|Admin whereDeletedAt($value)
 * @method static Builder|Admin whereEmail($value)
 * @method static Builder|Admin whereFullName($value)
 * @method static Builder|Admin whereGender($value)
 * @method static Builder|Admin whereId($value)
 * @method static Builder|Admin whereIsActive($value)
 * @method static Builder|Admin whereOfficeBranchId($value)
 * @method static Builder|Admin wherePassword($value)
 * @method static Builder|Admin whereRememberToken($value)
 * @method static Builder|Admin whereUpdatedAt($value)
 * @method static Builder|Admin whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class Admin extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'admin-panel';
  // protected $table = 'adm';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }

  static function findByEmail(string $email)
  {
    return self::whereEmail($email)->first();
  }


  static function superAdminRoutes()
  {
    Route::name('superadmin.manage_staff.')->prefix('admins')->group(function () {
      Route::put('{admin}/suspend', [self::class, 'suspendAdmin'])->name('admin.suspend');
      Route::put('{admin}/restore', [self::class, 'restoreAdmin'])->name('admin.reactivate');
    });
  }

  public function suspendAdmin(self $admin)
  {
    ActivityLog::logUserActivity(auth()->user()->email . ' suspended the account of ' . $admin->email);

    $admin->is_active = false;
    $admin->save();

    return back()->withFlash(['success'=>'User account suspended']);
  }

  public function restoreAdmin(self $admin)
  {
    $admin->is_active = true;
    $admin->save();

    ActivityLog::logUserActivity(auth()->user()->email . ' restored the account of ' . $admin->email);

    return back()->withFlash(['success'=>'User account re-activated']);
  }


  protected static function booted()
  {
    static::addGlobalScope('safeRecords', function (Builder $builder) {
      $builder->where('id', '>', 1);
    });
  }
}
