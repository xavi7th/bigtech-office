<?php

namespace App\Modules\WebAdmin\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\SuperAdmin\Traits\IsAStaff;

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
  use IsAStaff;

  protected $fillable = [
    'full_name', 'email', 'password', 'phone', 'avatar', 'gender', 'address', 'office_branch_id', 'is_active'
  ];
  const DASHBOARD_ROUTE_PREFIX = 'web-admins';

  static function superAdminRoutes()
  {
    self::staffRoutes();
  }
}
