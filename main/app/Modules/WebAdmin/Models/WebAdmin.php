<?php

namespace App\Modules\WebAdmin\Models;

use App\User;

/**
 * App\Modules\WebAdmin\Models\WebAdmin
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
 * @method static \Illuminate\Database\Eloquent\Builder|WebAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WebAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WebAdmin query()
 * @method static \Illuminate\Database\Eloquent\Builder|WebAdmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebAdmin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebAdmin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebAdmin whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebAdmin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebAdmin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebAdmin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebAdmin whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $gender
 * @property int $office_branch_id
 * @property int|null $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|WebAdmin whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebAdmin whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebAdmin whereOfficeBranchId($value)
 */
class WebAdmin extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'web-admin-panel';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }
}
