<?php

namespace App\Modules\QualityControl\Models;

use App\User;

/**
 * App\Modules\QualityControl\Models\QualityControl
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
 * @method static \Illuminate\Database\Eloquent\Builder|QualityControl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QualityControl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QualityControl query()
 * @method static \Illuminate\Database\Eloquent\Builder|QualityControl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QualityControl whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QualityControl whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QualityControl whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QualityControl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QualityControl wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QualityControl whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QualityControl whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $gender
 * @property int $office_branch_id
 * @property int|null $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|QualityControl whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QualityControl whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QualityControl whereOfficeBranchId($value)
 * @property string|null $verified_at
 * @method static \Illuminate\Database\Eloquent\Builder|QualityControl whereVerifiedAt($value)
 */
class QualityControl extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'quality-control-panel';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }
}
