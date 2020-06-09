<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSuppliersTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('product_suppliers')->delete();

    \DB::table('product_suppliers')->insert(array(
      0 =>
      array(
        'name' => 'WeSell Cellular',
        'created_at' => '2020-03-20 13:01:41',
        'updated_at' => '2020-03-20 13:03:16',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'name' => 'Ontronics',
        'created_at' => '2020-03-20 13:01:48',
        'updated_at' => '2020-03-20 13:01:48',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'name' => 'Saheed',
        'created_at' => '2020-03-20 13:01:52',
        'updated_at' => '2020-03-20 13:01:52',
        'deleted_at' => NULL,
      ),
      3 =>
      array(
        'name' => 'Biggie',
        'created_at' => '2020-03-20 13:02:02',
        'updated_at' => '2020-03-20 13:02:02',
        'deleted_at' => NULL,
      ),
    ));
  }
}
