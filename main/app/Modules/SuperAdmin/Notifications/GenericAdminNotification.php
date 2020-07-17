<?php

namespace App\Modules\SuperSuperAdmin\Notifications;

use Illuminate\Bus\Queueable;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

class GenericSuperAdminNotification extends Notification
{
  use Queueable;

  protected $notification;
  protected $subject;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(string $subject, string $notification)
  {
    $this->notification = $notification;
    $this->subject = $subject;
  }

  /**
   * Get the notification's delivery channels.
   * @param App\Modules\SuperAdmin\Models\SuperAdmin $superAdmin
   *
   * @return array
   */
  public function via(SuperAdmin $superAdmin)
  {
    return ['database', 'mail'];
  }

  /**
   * Get the mail representation of the notification.
   * @param App\Modules\SuperAdmin\Models\SuperAdmin $superAdmin
   *
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail(SuperAdmin $superAdmin)
  {

    return (new MailMessage)
      ->subject($this->subject)
      ->greeting('Hello ' . $superAdmin->full_name . ',')
      ->line($this->notification)
      ->salutation(new HtmlString('Cheers, <br>' . config('app.name')));
  }

  /**
   * Get the database representation of the notification.
   *
   * @param App\Modules\SuperAdmin\Models\SuperAdmin $superAdmin
   */
  public function toDatabase(SuperAdmin $superAdmin)
  {

    return [
      'action' => $this->subject . ': ' . $this->notification,

    ];
  }
}
