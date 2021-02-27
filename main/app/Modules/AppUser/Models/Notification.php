<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Notifications\DatabaseNotification;
use App\Modules\AppUser\Transformers\AppUserNotificationTransformer;

/**
 * App\Modules\AppUser\Models\Notification
 *
 * @property string $id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $notifiable
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection|static[] all($columns = ['*'])
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Notification whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Notification whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Notification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Notification extends DatabaseNotification
{
  protected $fillable = [];

  static function auditorRoutes()
  {
    Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {
      // Route::get('loan-requests/{auditor?}', 'Notification@showAllNotifications')->middleware('auth:auditor');
    });
  }

  static function appUserRoutes()
  {
    Route::group(['namespace' => '\App\Modules\AppUser\Models', 'middleware' => ['verified_app_users']], function () {
      Route::get('notifications', 'Notification@getUserNotifications')->middleware('auth:app_user');
    });
  }

  /**
   * ! Card User Route Methods
   */

  public function getUserNotifications()
  {
    return (new AppUserNotificationTransformer)->collectionTransformer(auth()->user()->unreadNotifications->take(30), 'transformForAppUserListNotifications');
  }
}
