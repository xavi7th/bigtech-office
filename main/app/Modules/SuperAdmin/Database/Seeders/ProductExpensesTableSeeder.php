<?php

namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\ProductExpense;

class ProductExpensesTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {
    factory(ProductExpense::class, 5)->create();
    factory(ProductExpense::class, 5)->states('swapDeal')->create();
  }
}
