<?php

namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Support\Str;
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
        'status' => strtolower('Just arrived'),
        'status-slug' => Str::slug('Just arrived'),
        'created_at' => '2020-03-21 14:57:59',
        'updated_at' => '2020-03-21 14:57:59',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'status' => strtolower('Undergoing QA'),
        'status-slug' => Str::slug('Undergoing QA'),
        'created_at' => '2020-03-22 07:53:21',
        'updated_at' => '2020-03-22 07:53:21',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'status' => strtolower('Out for repairs'),
        'status-slug' => Str::slug('Out for repairs'),
        'created_at' => '2020-03-22 07:53:38',
        'updated_at' => '2020-03-22 07:53:38',
        'deleted_at' => NULL,
      ),
      3 =>
      array(
        'status' => strtolower('RTO (Damaged)'),
        'status-slug' => Str::slug('RTO (Damaged)'),
        'created_at' => '2020-03-22 07:54:31',
        'updated_at' => '2020-03-22 07:54:31',
        'deleted_at' => NULL,
      ),
      4 =>
      array(
        'status' => strtolower('Back from repairs'),
        'status-slug' => Str::slug('Back from repairs'),
        'created_at' => '2020-03-22 07:54:46',
        'updated_at' => '2020-03-22 07:54:46',
        'deleted_at' => NULL,
      ),
      5 =>
      array(
        'status' => strtolower('In stock'),
        'status-slug' => Str::slug('In stock'),
        'created_at' => '2020-03-22 07:55:11',
        'updated_at' => '2020-03-22 07:55:11',
        'deleted_at' => NULL,
      ),
      6 =>
      array(
        'status' => strtolower('With reseller'),
        'status-slug' => Str::slug('With reseller'),
        'created_at' => '2020-03-22 07:55:23',
        'updated_at' => '2020-03-22 07:55:23',
        'deleted_at' => NULL,
      ),
      7 =>
      array(
        'status' => strtolower('Sold'),
        'status-slug' => Str::slug('Sold'),
        'created_at' => '2020-03-22 07:59:21',
        'updated_at' => '2020-03-22 07:59:21',
        'deleted_at' => NULL,
      ),
      8 =>
      array(
        'status' => strtolower('QA failed'),
        'status-slug' => Str::slug('QA failed'),
        'created_at' => '2020-03-22 08:00:02',
        'updated_at' => '2020-03-22 08:00:02',
        'deleted_at' => NULL,
      ),
      9 =>
      array(
        'status' => strtolower('sale confirmed'),
        'status-slug' => Str::slug('sale confirmed'),
        'created_at' => '2020-03-24 04:00:12',
        'updated_at' => '2020-03-24 04:00:12',
        'deleted_at' => NULL,
      ),
      10 =>
      array(
        'status' => strtolower('Sold by Reseller'),
        'status-slug' => Str::slug('Sold by Reseller'),
        'created_at' => '2020-03-31 15:04:53',
        'updated_at' => '2020-03-31 15:04:53',
        'deleted_at' => NULL,
      ),
      11 =>
      array(
        'status' => strtolower('Out for Delivery'),
        'status-slug' => Str::slug('Out for Delivery'),
        'created_at' => '2020-03-31 15:04:53',
        'updated_at' => '2020-03-31 15:04:53',
        'deleted_at' => NULL,
      ),
    ));
  }
}
