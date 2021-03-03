<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class ProductBatchesTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('product_batches')->delete();

    \DB::table('product_batches')->insert(array(
      0 =>
      array(
        'batch_number' => 'LOCAL-SUPPLIER',
        'order_date' => '2019-07-30 07:51:07',
        'created_at' => '2020-03-20 15:37:07',
        'updated_at' => '2020-03-20 15:37:07',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'batch_number' => '90893498',
        'order_date' => '2019-12-08 16:03:37',
        'created_at' => '2020-03-20 15:37:15',
        'updated_at' => '2020-03-20 15:37:15',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'batch_number' => 'B27dKjfTfeINyX1j',
        'order_date' => '2019-12-07 04:52:04',
        'created_at' => '2020-03-20 15:42:02',
        'updated_at' => '2020-03-20 15:42:02',
        'deleted_at' => NULL,
      ),
    ));
  }
}
