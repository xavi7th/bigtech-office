<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;

class ProductSaleRecordsTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {
    /**
     * ! The products table seeder takes care of creating the commented out factories using state
     */
    // factory(ProductSaleRecord::class, 5)->create();
    // factory(ProductSaleRecord::class, 5)->states('confirmed')->create();
    // factory(ProductSaleRecord::class, 5)->states('confirmed', 'swap_transaction')->create();
    factory(ProductSaleRecord::class, 5)->states('sold', 'swap_transaction')->create();
  }
}
