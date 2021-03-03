<?php

namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\SuperAdmin\Models\Product;

class ProductExpensesTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('product_expenses')->delete();

    \DB::table('product_expenses')->insert(array(
      0 =>
      array(
        'product_id' => 1,
        'product_type' => Product::class,
        'amount' => 7000.0,
        'reason' => 'Top speaker repairs',
      ),
      1 =>
      array(
        'product_id' => 1,
        'product_type' => SwapDeal::class,
        'amount' => 5000.0,
        'reason' => 'Camera and battery replacement.',
      ),
    ));
  }
}
