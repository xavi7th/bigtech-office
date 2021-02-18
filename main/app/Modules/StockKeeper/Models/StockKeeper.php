<?php

namespace App\Modules\StockKeeper\Models;

use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\SuperAdmin\Models\ActivityLog;

/**
 * App\Modules\StockKeeper\Models\StockKeeper
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
 * @method static Builder|StockKeeper newModelQuery()
 * @method static Builder|StockKeeper newQuery()
 * @method static Builder|StockKeeper query()
 * @method static Builder|StockKeeper whereCreatedAt($value)
 * @method static Builder|StockKeeper whereDeletedAt($value)
 * @method static Builder|StockKeeper whereEmail($value)
 * @method static Builder|StockKeeper whereFullName($value)
 * @method static Builder|StockKeeper whereGender($value)
 * @method static Builder|StockKeeper whereId($value)
 * @method static Builder|StockKeeper whereIsActive($value)
 * @method static Builder|StockKeeper whereOfficeBranchId($value)
 * @method static Builder|StockKeeper wherePassword($value)
 * @method static Builder|StockKeeper whereRememberToken($value)
 * @method static Builder|StockKeeper whereUpdatedAt($value)
 * @method static Builder|StockKeeper whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class StockKeeper extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'stock-panel';

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
    Route::name('superadmin.manage_staff.')->prefix('stock-keepers')->group(function () {
      Route::put('{stockKeepers}/suspend', [self::class, 'suspendStockKeeper'])->name('stock_keeper.suspend');
      Route::put('{stockKeeper}/restore', [self::class, 'restoreStockKeeper'])->name('stock_keeper.reactivate');
    });
  }

  public function suspendStockKeeper(self $stockKeepers)
  {
    ActivityLog::logUserActivity(auth()->user()->email . ' suspended the account of ' . $stockKeepers->email);

    $stockKeepers->is_active = false;
    $stockKeepers->save();

    return back()->withFlash(['success'=>'User account suspended']);
  }

  public function restoreStockKeeper(self $stockKeeper)
  {
    $stockKeeper->is_active = true;
    $stockKeeper->save();

    ActivityLog::logUserActivity(auth()->user()->email . ' restored the account of ' . $stockKeeper->email);

    return back()->withFlash(['success'=>'User account re-activated']);
  }

  protected static function booted()
  {
    static::addGlobalScope('safeRecords', function (Builder $builder) {
      $builder->where('id', '>', 1);
    });
  }
}
