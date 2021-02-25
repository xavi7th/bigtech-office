<?php

namespace App\Modules\Accountant\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Traits\IsAStaff;

/**
 * App\Modules\Accountant\Models\Accountant
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
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductSaleRecord[] $product_sales_record
 * @property-read int|null $reseller_histories_count
 * @property-read int|null $product_sales_record_count
 * @method static Builder|Accountant newModelQuery()
 * @method static Builder|Accountant newQuery()
 * @method static Builder|Accountant query()
 * @method static Builder|Accountant whereCreatedAt($value)
 * @method static Builder|Accountant whereDeletedAt($value)
 * @method static Builder|Accountant whereEmail($value)
 * @method static Builder|Accountant whereFullName($value)
 * @method static Builder|Accountant whereGender($value)
 * @method static Builder|Accountant whereId($value)
 * @method static Builder|Accountant whereIsActive($value)
 * @method static Builder|Accountant whereOfficeBranchId($value)
 * @method static Builder|Accountant wherePassword($value)
 * @method static Builder|Accountant whereRememberToken($value)
 * @method static Builder|Accountant whereUpdatedAt($value)
 * @method static Builder|Accountant whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class Accountant extends User
{

  use IsAStaff;

  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'accountant-panel';


  public function product_sales_record()
  {
    return $this->morphMany(ProductSaleRecord::class, 'sales_rep');
  }

  static function superAdminRoutes()
  {
    self::staffRoutes();
  }
}
