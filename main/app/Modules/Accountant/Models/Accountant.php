<?php

namespace App\Modules\Accountant\Models;

use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;

/**
 * App\Modules\Accountant\Models\Accountant
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
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductSaleRecord[] $product_sales_record
 * @property-read int|null $reseller_histories_count
 * @property-read int|null $product_sales_record_count
 * @method static Builder|Accountant newModelQuery()
 * @method static Builder|Accountant newQuery()
 * @method static Builder|Accountant query()
 * @method static Builder|Accountant whereCreatedAt($value)
 * @method static Builder|Accountant whereDeletedAt($value)
 * @method static Builder|Accountant whereEmail($value)
 * @method static Builder|Accountant whereFullName($value)
 * @method static Builder|Accountant whereGender($value)
 * @method static Builder|Accountant whereId($value)
 * @method static Builder|Accountant whereIsActive($value)
 * @method static Builder|Accountant whereOfficeBranchId($value)
 * @method static Builder|Accountant wherePassword($value)
 * @method static Builder|Accountant whereRememberToken($value)
 * @method static Builder|Accountant whereUpdatedAt($value)
 * @method static Builder|Accountant whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class Accountant extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'accountant-panel';


  public function product_sales_record()
  {
    return $this->morphMany(ProductSaleRecord::class, 'sales_rep');
  }

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
    Route::name('superadmin.manage_staff.')->prefix('accountants')->group(function () {
      Route::put('{accountant}/suspend', [self::class, 'suspendAccountant'])->name('accountant.suspend');
      Route::put('{accountant}/restore', [self::class, 'restoreAccountant'])->name('accountant.reactivate');
    });
  }

  public function suspendAccountant(self $accountant)
  {
    ActivityLog::logUserActivity(auth()->user()->email . ' suspended the account of ' . $accountant->email);

    $accountant->is_active = false;
    $accountant->save();

    return back()->withFlash(['success'=>'User account suspended']);
  }

  public function restoreAccountant(self $accountant)
  {
    $accountant->is_active = true;
    $accountant->save();

    ActivityLog::logUserActivity(auth()->user()->email . ' restored the account of ' . $accountant->email);

    return back()->withFlash(['success'=>'User account re-activated']);
  }


  protected static function booted()
  {
    static::addGlobalScope('safeRecords', function (Builder $builder) {
      $builder->where('id', '>', 1);
    });
  }
}
