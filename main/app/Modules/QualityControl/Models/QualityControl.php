<?php

namespace App\Modules\QualityControl\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\SuperAdmin\Traits\IsAStaff;

/**
 * App\Modules\QualityControl\Models\QualityControl
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
 * @method static Builder|QualityControl newModelQuery()
 * @method static Builder|QualityControl newQuery()
 * @method static Builder|QualityControl query()
 * @method static Builder|QualityControl whereCreatedAt($value)
 * @method static Builder|QualityControl whereDeletedAt($value)
 * @method static Builder|QualityControl whereEmail($value)
 * @method static Builder|QualityControl whereFullName($value)
 * @method static Builder|QualityControl whereGender($value)
 * @method static Builder|QualityControl whereId($value)
 * @method static Builder|QualityControl whereIsActive($value)
 * @method static Builder|QualityControl whereOfficeBranchId($value)
 * @method static Builder|QualityControl wherePassword($value)
 * @method static Builder|QualityControl whereRememberToken($value)
 * @method static Builder|QualityControl whereUpdatedAt($value)
 * @method static Builder|QualityControl whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class QualityControl extends User
{
  use IsAStaff;

  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'quality-control-panel';

  static function superAdminRoutes()
  {
    self::staffRoutes();
  }
}
