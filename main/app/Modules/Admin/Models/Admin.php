<?php

namespace App\Modules\Admin\Models;

use App\User;

/**
 * App\Modules\Admin\Models\Admin
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-write mixed $password
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\UserComment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\Expense[] $expenses
 * @property-read int|null $expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ProductHistory[] $product_histories
 * @property-read int|null $product_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ResellerHistory[] $reseller_histories
 * @property-read int|null $reseller_histories_count
 * @property int|null $role_id
 * @property string|null $phone
 * @property string|null $bvn
 * @property string|null $user_passport
 * @property string|null $gender
 * @property string|null $address
 * @property string|null $dob
 * @property string|null $verified_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereUserPassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereVerifiedAt($value)
 */
class Admin extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'admin-panel';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }
}
