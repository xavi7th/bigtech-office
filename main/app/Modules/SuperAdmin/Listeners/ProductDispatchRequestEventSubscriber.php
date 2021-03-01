<?php

namespace App\Modules\SuperAdmin\Listeners;

use App\Modules\SuperAdmin\Events\ProductDispatchRequestDeleted;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\SuperAdmin\Events\ProductDispatchRequestSaved;
use Illuminate\Bus\Queueable;

class ProductDispatchRequestEventSubscriber implements ShouldQueue
{
  use Queueable;
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Register the listeners for the subscriber.
   */
  public function subscribe(Dispatcher $events)
  {
    $events->listen(ProductDispatchRequestSaved::class, 'App\Modules\SuperAdmin\Listeners\ProductDispatchRequestEventSubscriber@handleProductDispatchRequestSaved');
    $events->listen(ProductDispatchRequestDeleted::class, 'App\Modules\SuperAdmin\Listeners\ProductDispatchRequestEventSubscriber@handleProductDispatchRequestDeleted');
  }

  static function handleProductDispatchRequestSaved(ProductDispatchRequestSaved $event)
  {
    Cache::forget('dispatchRequests');
    Cache::forget('completedDispatchRequests');

    // ActivityLog::notifySuperAdmins(auth()->user()->email . ' confirmed the sale of product with ' . $$event->product_sale_record->product->primary_identifier() . '.');
  }

  static function handleProductDispatchRequestDeleted(ProductDispatchRequestSaved $event)
  {
    Cache::forget('dispatchRequests');
    Cache::forget('products');
    Cache::forget('webAdminProducts');
    Cache::forget('accountantProducts');
    Cache::forget('salesRepProducts');
    Cache::forget('qualityControlProducts');
    Cache::forget('brandsWithProductCount');
  }
}
