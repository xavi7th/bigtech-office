<?php

namespace App\Modules\SuperAdmin\Events;

use App\User;
use Illuminate\Auth\SessionGuard;
use Illuminate\Queue\SerializesModels;

class NotificationEvent
{
  use SerializesModels;

  public $user;
  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct(User $user)
  {
    $this->user = $user;
  }

  /**
   * Get the channels the event should be broadcast on.
   *
   * @return array
   */
  public function broadcastOn()
  {
    return [];
  }
}
