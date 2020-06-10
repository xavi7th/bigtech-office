<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\SuperAdmin\Transformers\AdminActivityLogTransformer;

/**
 * App\Modules\SuperAdmin\Models\ActivityLog
 *
 * @property int $id
 * @property int $user_id
 * @property string $user_type
 * @property string $activity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog whereActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog whereUserType($value)
 * @mixin \Eloquent
 */
class ActivityLog extends Model
{
  protected $fillable = ['activity'];

  public function user()
  {
    return $this->morphTo();
  }

  static function logUserActivity(string $activity)
  {
    auth()->user()->activities()->create([
      'activity' => $activity
    ]);
  }

  static function logAdminActivity(string $activity)
  {
    auth()->user()->activities()->create([
      'activity' => $activity
    ]);
  }

  static function notifySuperAdmins(string $activity)
  {
    SuperAdmin::find(1)->activities()->create([
      'activity' => $activity
    ]);
  }


  static function adminRoutes()
  {
    Route::group(['middleware' => 'auth:admin,accountant,card_admin,account_officer,normal_admin,customer_support,sales_rep'], function () {
      Route::get('activity-logs', [self::class, 'getActivityLogs'])->name('superadmin.logs.activity_logs')->defaults('ex', __e('ss', 'activity', false));
      Route::get('activity-logs/sales-reps', [self::class, 'index'])->name('superadmin.logs.sales_reps_logs')->defaults('ex', __e('ss', 'activity', false));
      Route::get('activity-logs/accountant', [self::class, 'index'])->name('superadmin.logs.accountant_logs')->defaults('ex', __e('ss', 'activity', false));
    });
  }

  public function getActivityLogs()
  {
    if (auth('admin')->check()) {
      return (new AdminActivityLogTransformer)->collectionTransformer(SuperAdmin::find(1)->activities, 'basicTransform');
    }
  }
}
