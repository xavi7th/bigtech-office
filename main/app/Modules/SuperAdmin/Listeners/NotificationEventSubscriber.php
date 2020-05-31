<?php

namespace App\Modules\SuperAdmin\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Events\NotificationEvent;
use App\Modules\SuperAdmin\Events\NotificationEvents;

class NotificationEventSubscriber
{

  /**
   * Register the listeners for the subscriber.
   *
   * @param  \Illuminate\Events\Dispatcher  $events
   */
  public function subscribe($events)
  {
    $events->listen(
      NotificationEvents::LOGGED_IN,
      [self::class, 'onLoggedIn']
    );
  }


  static function onLoggedIn(NotificationEvent $event)
  {
    $message = $event->user->email  . ' logged into the ' . $event->user->getType() . ' dashboard';
    ActivityLog::notifySuperAdmins($message);
    // $event->loan_request->card_user->notify(new LoanOverdue($event->loan_request));
  }
}
