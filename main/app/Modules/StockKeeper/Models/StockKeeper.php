<?php

namespace App\Modules\StockKeeper\Models;

use App\User;

/**
 * App\Modules\StockKeeper\Models\StockKeeper
 *
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
 * @property-write mixed $password
 * @method static \Illuminate\Database\Eloquent\Builder|StockKeeper newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockKeeper newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockKeeper query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|StockKeeper whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockKeeper whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockKeeper whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockKeeper whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockKeeper whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockKeeper wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockKeeper whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockKeeper whereUpdatedAt($value)
 */
class StockKeeper extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'stock-panel';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }
}
