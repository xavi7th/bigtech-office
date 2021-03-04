<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\SuperAdmin\Models\ProductBatch;

class ProductBatchesTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {
    factory(ProductBatch::class)->create(['batch_number' => 'LOCAL-SUPPLIER']);
    app()->environment('local') && factory(ProductBatch::class, 2)->create();
  }
}
