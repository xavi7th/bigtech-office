<?php

namespace App\Modules\StockKeeper\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;

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

  protected static function booted()
  {
    static::addGlobalScope('safeRecords', function (Builder $builder) {
      $builder->where('id', '>', 1);
    });
  }
}
