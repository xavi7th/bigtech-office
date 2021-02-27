<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\SuperAdmin\Transformers\AdminActivityLogTransformer;

class ActivityLog extends Model
{
  protected $fillable = ['activity', 'user_id', 'user_type'];

  public function user()
  {
    return $this->morphTo();
  }

  static function logUserActivity(string $activity)
  {
    request()->user()->activities()->create([
      'activity' => $activity
    ]);
  }

  static function notifySuperAdmins(string $activity)
  {
    self::create([
      'activity' => $activity,
      'user_id' => 1,
      'user_type' => SuperAdmin::class,
    ]);
  }

  static function notifyAccountants(string $activity)
  {
    self::create([
      'activity' => $activity,
      'user_id' => 1,
      'user_type' => SuperAdmin::class,
    ]);
  }


  static function auditorRoutes()
  {
    Route::group(['middleware' => 'auth:auditor,accountant,sales_rep'], function () {
      Route::get('activity-logs', [self::class, 'getActivityLogs'])->name('superadmin.logs.activity_logs')->defaults('ex', __e('ss', 'activity', false));
      Route::get('activity-logs/sales-reps', [self::class, 'index'])->name('superadmin.logs.sales_reps_logs')->defaults('ex', __e('ss', 'activity', false));
      Route::get('activity-logs/accountant', [self::class, 'index'])->name('superadmin.logs.accountant_logs')->defaults('ex', __e('ss', 'activity', false));
    });
  }

  public function getActivityLogs()
  {
    if (auth('auditor')->check()) {
      return (new AuditorActivityLogTransformer)->collectionTransformer(SuperAdmin::find(1)->activities, 'basicTransform');
    }
  }
}
