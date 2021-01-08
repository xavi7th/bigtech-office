<?php

namespace App\Modules\SuperAdmin\Console;

use Illuminate\Console\Command;
use App\Modules\SuperAdmin\Models\Product;

class MigrateLocalProductPrice extends Command
{
  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'local_price:migrate';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Migrate local product\'s prices from the product_prices table to the locap_product_prices table';
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
    // Product::withoutEvents(function () {

    /**
     * @var Product $product
     */
    foreach (Product::local()->with('product_price')->get() as $product) {

      dump('********************* Initial Stage **************************\n', $product->toArray());

      if ($product->is_local) {
        dump('********************* This is already a processed local product. Skipping.... **************************\n. \n');
        continue;
      }

      $product->localProductPrice()->create([
        'cost_price' => $product->product_price->cost_price,
        'proposed_selling_price' => $product->product_price->proposed_selling_price,
      ]);
      $product->product_price()->delete();
      $product->is_local = true;
      $product::unsetEventDispatcher();
      $product->save();

      dump('********************* Final Stage **************************\n', $product->load('localProductPrice', 'product_price', 'product_expenses')->toArray());
    }
    dump(collect($this->notification)->implode(',' . PHP_EOL));
      // Admin::find(1)->notify(new GenericAdminNotification('Processed database backup', collect($this->notification)->implode(', ' . PHP_EOL)));
    // });
  }
}
