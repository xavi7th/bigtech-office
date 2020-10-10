<?php

namespace App\Modules\Admin\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Modules\Admin\Models\Admin
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
 * @method static Builder|Admin newModelQuery()
 * @method static Builder|Admin newQuery()
 * @method static Builder|Admin query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string|null $gender
 * @property int $office_branch_id
 * @property int|null $is_active
 * @property string|null $verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static Builder|Admin whereCreatedAt($value)
 * @method static Builder|Admin whereDeletedAt($value)
 * @method static Builder|Admin whereEmail($value)
 * @method static Builder|Admin whereFullName($value)
 * @method static Builder|Admin whereGender($value)
 * @method static Builder|Admin whereId($value)
 * @method static Builder|Admin whereIsActive($value)
 * @method static Builder|Admin whereOfficeBranchId($value)
 * @method static Builder|Admin wherePassword($value)
 * @method static Builder|Admin whereRememberToken($value)
 * @method static Builder|Admin whereUpdatedAt($value)
 * @method static Builder|Admin whereVerifiedAt($value)
 */
class Admin extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'admin-panel';
  // protected $table = 'adm';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }

  // protected static function booted()
  // {
  //   static::addGlobalScope('safeRecords', function (Builder $builder) {
  //     $builder->where('full_name', '<>', 'SysDef Admin');
  //   });
  // }
}
