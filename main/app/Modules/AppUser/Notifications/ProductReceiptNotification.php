<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\AppUser\Models\ProductReceipt;
use Illuminate\Notifications\Messages\MailMessage;
use App\Modules\AppUser\Notifications\Channels\BulkSMSMessage;
use App\Modules\PublicPages\Notifications\Channels\SMSSolutionsMessage;

class ProductReceiptNotification extends Notification implements ShouldQueue
{
  use Queueable;

  private $receipt;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(ProductReceipt $productReceipt)
  {
    $this->receipt = $productReceipt;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param AppUser $appUser
   * @return array
   */
  public function via($appUser)
  {
    return ['mail', BulkSMSMessage::class];
  }


  /**
   * Get the SMS representation of the notification.
   *
   * @param AppUser $appUser
   */
  public function toBulkSMS(AppUser $appUser)
  {
    return (new BulkSMSMessage)
      ->sms_message('Your receipt for ' . to_naira($this->receipt->amount_paid) . ' has been sent to your email.')
      ->to($appUser->phone);
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param AppUser $appUser
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($appUser)
  {
    return (new MailMessage)
      ->from('support@theelects.com')
      ->subject('Payment Receipt')
      ->view('appuser::emails.product_receipt', ['receipt' => $this->receipt->load('product.app_user', 'product.product_model', 'product.swapped_deal_device')]);
  }

  /**
   * Get the database representation of the notification.
   *
   * @param AppUser $appUser
   */
  public function toDatabase($appUser)
  {
    return [
      'action' =>  'Profile details updated.',

    ];
  }

  /**
   * Get the SMS representation of the notification.
   *
   * @param mixed $appUser
   */
  public function toSMSSolutions($appUser)
  {
    return (new SMSSolutionsMessage)
      ->sms_message('You just updated your profile details on Capital X.')
      ->to($appUser->phone);
  }
}
