<?php

namespace App\Modules\AppUser\Models;

use App\User;

/**
 * App\Modules\AppUser\Models\AppUser
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereUpdatedAt($value)
 * @property string $name
 * @property string $unenc_password
 * @property string $phone
 * @property string $country
 * @property string $currency
 * @property string|null $id_card
 * @property string|null $verified_at
 * @property int $can_withdraw
 * @property int $is_active
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereCanWithdraw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereUnencPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereVerifiedAt($value)
 */
class AppUser extends User
{
	protected $fillable = [];
	const DASHBOARD_ROUTE_PREFIX = 'user';
}
