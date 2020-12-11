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

  /**
   * The database record to build the receipt from
   *
   * @var ProductReceipt
   */
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
    return (new \Coconuts\Mail\MailMessage)
      ->identifier(21372102)
      ->include([
        "currentYear" => now()->year,
        "coyAddress" => config('app.address'),
        "coyPhone" => config('app.phone'),
        "coyEmail" => config('app.email'),
        "coySupportEmail" => config('app.email'),
        "coyComplaintsPhoneNumber" => config('app.complaint_phone_line'),
        "customerFullName" => $appUser->full_name,
        "customerAddress" => $appUser->address,
        "customerCity" => $appUser->city,
        "customerPhone" => $appUser->phone,
        "customerEmail" => $appUser->email,
        "receiptNo" => str_pad($this->receipt->id, 7, '0', STR_PAD_LEFT),
        "receiptUrl" => route('appuser.preview_receipt', $this->receipt->order_ref),
        "orderRef" => $this->receipt->order_ref,
        "purchaseDate" => $this->receipt->created_at->toDateString(),
        "productName" => $this->receipt->product->product_model->name,
        "productId" => $this->receipt->product->primary_identifier(),
        "amountPaid" => to_naira($this->receipt->amount_paid),
        "swapDevices" => $this->receipt->product->swapped_deal_device ? [
          [
            "swapDeviceDescription" => $this->receipt->product->swapped_deal_device->description,
            "swapDeviceId" => $this->receipt->product->swapped_deal_device->primary_identifier(),
            "swapDeviceValue" => $this->receipt->product->swapped_deal_device->swap_value
          ]
        ] : [],
        "taxRate" => $this->receipt->tax_rate,
        "taxAmount" => to_naira($this->receipt->tax_rate / 100 * $this->receipt->amount_paid),
        "shippingFee" => to_naira($this->receipt->delivery_fee ?? 0),
        "grandTotal" => to_naira($this->receipt->amount_paid + ($this->receipt->tax_rate / 100 * $this->receipt->amount_paid) + $this->receipt->delivery_fee),
      ]);

    // return (new MailMessage)
    //   ->from('support@theelects.com')
    //   ->subject('Payment Receipt')
    //   ->view('appuser::emails.product_receipt', ['receipt' => $this->receipt->load('product.app_user', 'product.product_model', 'product.swapped_deal_device')]);
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
