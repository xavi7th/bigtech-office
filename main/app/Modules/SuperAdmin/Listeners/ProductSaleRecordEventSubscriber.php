<?php

namespace App\Modules\SuperAdmin\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\SuperAdmin\Events\ProductSaleRecordSaved;
use App\Modules\SuperAdmin\Events\ProductSaleRecordUpdated;
use App\Modules\SuperAdmin\Events\ProductSaleRecordConfirmed;

class ProductSaleRecordEventSubscriber
{
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
   *
   * @param  \Illuminate\Events\Dispatcher  $events
   */
  public function subscribe($events)
  {
    $events->listen(ProductSaleRecordConfirmed::class, [self::class, 'onProductSaleRecordConfirmed']);
    $events->listen(ProductSaleRecordUpdated::class, 'App\Modules\SuperAdmin\Listeners\ProductSaleRecordEventSubscriber@onProductSaleRecordUpdated');
    $events->listen(ProductSaleRecordSaved::class, 'App\Modules\SuperAdmin\Listeners\ProductSaleRecordEventSubscriber@onProductSaleRecordSaved');
  }


  static function onProductSaleRecordUpdated(ProductSaleRecordUpdated $event)
  {
    // dd('here56');
  }


  static function onProductSaleRecordSaved(ProductSaleRecordSaved $event)
  {
    // dd('heretr');
  }

  static function onProductSaleRecordConfirmed(ProductSaleRecordConfirmed $event)
  {
    dd($event);
    Cache::forget('bank_payments');
  }
}
