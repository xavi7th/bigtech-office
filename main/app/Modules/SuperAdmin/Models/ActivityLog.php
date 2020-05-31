<?php

namespace App\Modules\SuperAdmin\Models;

use App\Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\CardAdmin\Models\CardAdmin;
use App\Modules\Accountant\Models\Accountant;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\NormalAdmin\Models\NormalAdmin;
use App\Modules\AccountOfficer\Models\AccountOfficer;
use App\Modules\CustomerSupport\Models\CustomerSupport;
use App\Modules\Admin\Transformers\AdminActivityLogTransformer;

/**
 * This class is intended to create general activity notifications for class groups eg all admins
 *
 * Whereas the notification system creates notifications for particular users
 *
 * App\Modules\SuperAdmin\Models\ActivityLog
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $user_type
 * @property string $activity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog whereActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ActivityLog whereUserType($value)
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

  static function notifySalesReps(string $activity)
  {
    SalesRep::find(1)->activities()->create([
      'activity' => $activity
    ]);
  }

  static function notifyCardAdmins(string $activity)
  {
    CardAdmin::find(1)->activities()->create([
      'activity' => $activity
    ]);
  }

  static function notifyAccountants(string $activity)
  {
    Accountant::find(1)->activities()->create([
      'activity' => $activity
    ]);
  }

  static function notifyAccountOfficers(string $activity)
  {
    AccountOfficer::find(1)->activities()->create([
      'activity' => $activity
    ]);
  }

  static function notifySuperAdmins(string $activity)
  {
    SuperAdmin::find(1)->activities()->create([
      'activity' => $activity
    ]);
  }

  static function notifyAdmins(string $activity)
  {
    Admin::find(1)->activities()->create([
      'activity' => $activity
    ]);
  }

  static function notifyCustomerSupports(string $activity)
  {
    CustomerSupport::find(1)->activities()->create([
      'activity' => $activity
    ]);
  }


  static function adminRoutes()
  {
    Route::group(['namespace' => '\App\Modules\Admin\Models'], function () {
      Route::get('activity-logs', 'ActivityLog@getActivityLogs')->middleware('auth:admin,accountant,card_admin,account_officer,normal_admin,customer_support,sales_rep');
    });
  }

  public function getActivityLogs()
  {
    if (auth('admin')->check()) {
      return (new AdminActivityLogTransformer)->collectionTransformer(Admin::find(1)->activities, 'basicTransform');
    } else if (auth('accountant')->check()) {
      return (new AdminActivityLogTransformer)->collectionTransformer(Accountant::find(1)->activities, 'basicTransform');
    } else if (auth('account_officer')->check()) {
      return (new AdminActivityLogTransformer)->collectionTransformer(AccountOfficer::find(1)->activities, 'basicTransform');
    } else if (auth('card_admin')->check()) {
      return (new AdminActivityLogTransformer)->collectionTransformer(CardAdmin::find(1)->activities, 'basicTransform');
    } else if (auth('customer_support')->check()) {
      return (new AdminActivityLogTransformer)->collectionTransformer(CustomerSupport::find(1)->activities, 'basicTransform');
    } else if (auth('normal_admin')->check()) {
      return (new AdminActivityLogTransformer)->collectionTransformer(NormalAdmin::find(1)->activities, 'basicTransform');
    } else if (auth('sales_rep')->check()) {
      return (new AdminActivityLogTransformer)->collectionTransformer(SalesRep::find(1)->activities, 'basicTransform');
    }
  }
}
