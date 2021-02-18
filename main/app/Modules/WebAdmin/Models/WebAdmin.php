<?php

namespace App\Modules\WebAdmin\Models;

use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\SuperAdmin\Models\ActivityLog;

/**
 * App\Modules\WebAdmin\Models\WebAdmin
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
 * @method static Builder|WebAdmin newModelQuery()
 * @method static Builder|WebAdmin newQuery()
 * @method static Builder|WebAdmin query()
 * @method static Builder|WebAdmin whereCreatedAt($value)
 * @method static Builder|WebAdmin whereDeletedAt($value)
 * @method static Builder|WebAdmin whereEmail($value)
 * @method static Builder|WebAdmin whereFullName($value)
 * @method static Builder|WebAdmin whereGender($value)
 * @method static Builder|WebAdmin whereId($value)
 * @method static Builder|WebAdmin whereIsActive($value)
 * @method static Builder|WebAdmin whereOfficeBranchId($value)
 * @method static Builder|WebAdmin wherePassword($value)
 * @method static Builder|WebAdmin whereRememberToken($value)
 * @method static Builder|WebAdmin whereUpdatedAt($value)
 * @method static Builder|WebAdmin whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class WebAdmin extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'web-admins';

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
    Route::name('superadmin.manage_staff.')->prefix('web-admins')->group(function () {
      Route::put('{webAdmin}/suspend', [self::class, 'suspendWebAdmin'])->name('web_admin.suspend');
      Route::put('{webAdmin}/restore', [self::class, 'restoreWebAdmin'])->name('web_admin.reactivate');
    });
  }

  public function suspendWebAdmin(self $webAdmin)
  {
    ActivityLog::logUserActivity(auth()->user()->email . ' suspended the account of ' . $webAdmin->email);

    $webAdmin->is_active = false;
    $webAdmin->save();

    return back()->withFlash(['success'=>'User account suspended']);
  }

  public function restoreWebAdmin(self $webAdmin)
  {
    $webAdmin->is_active = true;
    $webAdmin->save();

    ActivityLog::logUserActivity(auth()->user()->email . ' restored the account of ' . $webAdmin->email);

    return back()->withFlash(['success'=>'User account re-activated']);
  }

  protected static function booted()
  {
    static::addGlobalScope('safeRecords', function (Builder $builder) {
      $builder->where('id', '>', 1);
    });
  }
}
