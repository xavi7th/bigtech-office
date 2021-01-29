<?php

namespace App\Modules\SuperAdmin\Console;

use App\Modules\AppUser\Models\ProductReceipt;
use Illuminate\Console\Command;
use App\Modules\SuperAdmin\Models\Product;

class MigrateProductReceiptUserNames extends Command
{
  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'product_receipt:migrate_name';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Migrate product receipts\' name from the associated user';
  protected $notification = [];

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    /**
     * @var ProductReceipt $productReceipt
     */
    foreach (ProductReceipt::with('product.app_user')->get() as $productReceipt) {
      /**
       * @var AppUser $appUser
       */
      $appUser = $productReceipt->product->app_user;

      dump('********************* Initial Stage **************************\n', $productReceipt->toArray());

      if ($productReceipt->user_name) {
        dump('********************* This is already a processed receipt. Skipping.... **************************\n. \n');
        continue;
      }

      $productReceipt->user_name = $appUser->first_name . ' ' . $appUser->last_name;
      $productReceipt->save();

      dump('********************* Final Stage **************************\n', $productReceipt->load('product.app_user')->toArray());
    }
    dump(collect($this->notification)->implode(',' . PHP_EOL));
  }
}
