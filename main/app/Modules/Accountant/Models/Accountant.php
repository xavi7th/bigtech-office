<?php

namespace App\Modules\Accountant\Models;

use App\User;

/**
 * App\Modules\Accountant\Models\Accountant
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $password
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
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereIsActive($value)
 * @property string|null $gender
 * @property int $office_branch_id
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accountant whereOfficeBranchId($value)
 */
class Accountant extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'accountant-panel';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }
}
