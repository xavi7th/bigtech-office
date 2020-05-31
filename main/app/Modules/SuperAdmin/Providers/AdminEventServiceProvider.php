<?php

namespace App\Modules\SuperAdmin\Providers;

use App\Modules\SuperAdmin\Listeners\NotificationEventSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class AdminEventServiceProvider extends ServiceProvider
{
  /**
   * The event listener mappings for the application.
   *
   * @var array
   */
  protected $listen = [
    //
  ];

  /**
   * The subscriber classes to register.
   *
   * @var array
   */
  protected $subscribe = [
    NotificationEventSubscriber::class,
  ];
}
