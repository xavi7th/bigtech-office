<?php

namespace App\Modules\DispatchAdmin\Models;

use App\User;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Traits\IsAStaff;

/**
 * App\Modules\DispatchAdmin\Models\DispatchAdmin
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
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductSaleRecord[] $product_sales_record
 * @property-read int|null $product_sales_record_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ResellerHistory[] $reseller_histories
 * @property-read int|null $reseller_histories_count
 * @method static \Illuminate\Database\Eloquent\Builder|DispatchAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DispatchAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DispatchAdmin query()
 * @method static \Illuminate\Database\Eloquent\Builder|DispatchAdmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DispatchAdmin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DispatchAdmin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DispatchAdmin whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DispatchAdmin whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DispatchAdmin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DispatchAdmin whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DispatchAdmin whereOfficeBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DispatchAdmin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DispatchAdmin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DispatchAdmin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DispatchAdmin whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class DispatchAdmin extends User
{
  use IsAStaff;

  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'dispatch-admins';

  public function product_sales_record()
  {
    return $this->morphMany(ProductSaleRecord::class, 'sales_rep');
  }

  static function superAdminRoutes()
  {
    self::staffRoutes();
  }
}
