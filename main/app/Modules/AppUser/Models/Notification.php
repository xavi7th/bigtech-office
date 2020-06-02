<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Notifications\DatabaseNotification;
use App\Modules\AppUser\Transformers\AppUserNotificationTransformer;

class Notification extends DatabaseNotification
{
  protected $fillable = [];

  static function adminRoutes()
  {
    Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {
      // Route::get('loan-requests/{admin?}', 'Notification@showAllNotifications')->middleware('auth:admin');
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
