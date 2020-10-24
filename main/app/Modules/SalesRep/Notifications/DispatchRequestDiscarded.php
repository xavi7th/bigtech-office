<?php

namespace App\Modules\SalesRep\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Modules\AppUser\Notifications\Channels\SMSSolutionsMessage;
use App\Modules\SalesRep\Models\ProductDispatchRequest;

class DispatchRequestDiscarded extends Notification implements ShouldQueue
{
  use Queueable;

  protected $dispatchRequest;
  protected $discardReason;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(ProductDispatchRequest $dispatchRequest, string $discardReason)
  {
    $this->dispatchRequest = $dispatchRequest;
    $this->discardReason = $discardReason;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param App\Modules\AppUser\Models\AppUser $app_user
   * @return array
   */
  public function via($app_user)
  {
    return ['database'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param App\Modules\AppUser\Models\AppUser $app_user
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($app_user)
  {

    return (new MailMessage)
      ->subject('Card Funding Request Processed!')
      ->greeting('Dear ' . $app_user->first_name . '.')
      ->line('Your card funding request of ' . $this->amount . ' has been processed & is ready for immediate access on your card. For more enquiries, call ' . config('app.phone'));
  }

  /**
   * Get the database representation of the notification.
   *
   * @param App\Modules\AppUser\Models\AppUser $app_user
   */
  public function toDatabase($app_user)
  {

    return [
      'action' => 'Your delivery request for ' . $this->dispatchRequest->product__description . ' has just been discarded because ' . $this->discardReason,

    ];
  }

  /**
   * Get the SMS representation of the notification.
   *
   * @param App\Modules\AppUser\Models\AppUser $app_user
   */
  public function toSMSSolutions($app_user)
  {

    return (new SMSSolutionsMessage)
      ->sms_message('Your card funding request of ' . $this->amount . ' has been processed & is ready for immediate access on your card. For more enquiries, call ' . config('app.phone'))
      ->to($app_user->phone);
  }
}
