<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class ProductStatusesTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('product_statuses')->delete();

    \DB::table('product_statuses')->insert(array(
      0 =>
      array(
        'status' => 'Just arrived',
        'created_at' => '2020-03-21 14:57:59',
        'updated_at' => '2020-03-21 14:57:59',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'status' => 'Undergoing QA',
        'created_at' => '2020-03-22 07:53:21',
        'updated_at' => '2020-03-22 07:53:21',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'status' => 'Out for repairs',
        'created_at' => '2020-03-22 07:53:38',
        'updated_at' => '2020-03-22 07:53:38',
        'deleted_at' => NULL,
      ),
      3 =>
      array(
        'status' => 'RTO (Damaged)',
        'created_at' => '2020-03-22 07:54:31',
        'updated_at' => '2020-03-22 07:54:31',
        'deleted_at' => NULL,
      ),
      4 =>
      array(
        'status' => 'Back from repairs',
        'created_at' => '2020-03-22 07:54:46',
        'updated_at' => '2020-03-22 07:54:46',
        'deleted_at' => NULL,
      ),
      5 =>
      array(
        'status' => 'In stock',
        'created_at' => '2020-03-22 07:55:11',
        'updated_at' => '2020-03-22 07:55:11',
        'deleted_at' => NULL,
      ),
      6 =>
      array(
        'status' => 'With reseller',
        'created_at' => '2020-03-22 07:55:23',
        'updated_at' => '2020-03-22 07:55:23',
        'deleted_at' => NULL,
      ),
      7 =>
      array(
        'status' => 'Sold',
        'created_at' => '2020-03-22 07:59:21',
        'updated_at' => '2020-03-22 07:59:21',
        'deleted_at' => NULL,
      ),
      8 =>
      array(
        'status' => 'QA failed',
        'created_at' => '2020-03-22 08:00:02',
        'updated_at' => '2020-03-22 08:00:02',
        'deleted_at' => NULL,
      ),
      9 =>
      array(
        'status' => 'sale confirmed',
        'created_at' => '2020-03-24 04:00:12',
        'updated_at' => '2020-03-24 04:00:12',
        'deleted_at' => NULL,
      ),
      10 =>
      array(
        'status' => 'Sold by Reseller',
        'created_at' => '2020-03-31 15:04:53',
        'updated_at' => '2020-03-31 15:04:53',
        'deleted_at' => NULL,
      ),
    ));
  }
}
