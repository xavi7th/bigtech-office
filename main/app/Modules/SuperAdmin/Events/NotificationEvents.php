<?php

namespace App\Modules\SuperAdmin\Events;

use Illuminate\Queue\SerializesModels;

class NotificationEvents
{
  use SerializesModels;

  const LOGGED_IN = 'user.login';
  const SHIPPED = 'order.shipped';
}
