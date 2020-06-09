<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSaleRecordsTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('product_sale_records')->delete();

    \DB::table('product_sale_records')->insert(array(
      0 =>
      array(
        'product_id' => 22,
        'selling_price' => 70000.0,
        'sales_channel_id' => 2,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => 1,
        'sale_confirmer_type' => 'App\\Modules\\Admin\\Models\\Admin',
      ),
      1 =>
      array(
        'product_id' => 15,
        'selling_price' => 20000.0,
        'sales_channel_id' => 2,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      2 =>
      array(
        'product_id' => 43,
        'selling_price' => 190000.0,
        'sales_channel_id' => 4,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      3 =>
      array(
        'product_id' => 3,
        'selling_price' => 10000.0,
        'sales_channel_id' => 6,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      4 =>
      array(
        'product_id' => 14,
        'selling_price' => 30000.0,
        'sales_channel_id' => 6,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      5 =>
      array(
        'product_id' => 29,
        'selling_price' => 120000.0,
        'sales_channel_id' => 3,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      6 =>
      array(
        'product_id' => 16,
        'selling_price' => 90000.0,
        'sales_channel_id' => 3,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      7 =>
      array(
        'product_id' => 46,
        'selling_price' => 280000.0,
        'sales_channel_id' => 1,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      8 =>
      array(
        'product_id' => 18,
        'selling_price' => 90000.0,
        'sales_channel_id' => 7,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      9 =>
      array(
        'product_id' => 47,
        'selling_price' => 140000.0,
        'sales_channel_id' => 2,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      10 =>
      array(
        'product_id' => 31,
        'selling_price' => 20000.0,
        'sales_channel_id' => 2,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      11 =>
      array(
        'product_id' => 24,
        'selling_price' => 60000.0,
        'sales_channel_id' => 4,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      12 =>
      array(
        'product_id' => 30,
        'selling_price' => 120000.0,
        'sales_channel_id' => 6,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      13 =>
      array(
        'product_id' => 6,
        'selling_price' => 80000.0,
        'sales_channel_id' => 4,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      14 =>
      array(
        'product_id' => 28,
        'selling_price' => 220000.0,
        'sales_channel_id' => 4,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      15 =>
      array(
        'product_id' => 5,
        'selling_price' => 220000.0,
        'sales_channel_id' => 5,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      16 =>
      array(
        'product_id' => 13,
        'selling_price' => 100000.0,
        'sales_channel_id' => 7,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      17 =>
      array(
        'product_id' => 9,
        'selling_price' => 200000.0,
        'sales_channel_id' => 1,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      18 =>
      array(
        'product_id' => 17,
        'selling_price' => 40000.0,
        'sales_channel_id' => 5,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      19 =>
      array(
        'product_id' => 21,
        'selling_price' => 140000.0,
        'sales_channel_id' => 8,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      20 =>
      array(
        'product_id' => 7,
        'selling_price' => 260000.0,
        'sales_channel_id' => 8,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      21 =>
      array(
        'product_id' => 20,
        'selling_price' => 50000.0,
        'sales_channel_id' => 7,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      22 =>
      array(
        'product_id' => 11,
        'selling_price' => 160000.0,
        'sales_channel_id' => 8,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      23 =>
      array(
        'product_id' => 36,
        'selling_price' => 180000.0,
        'sales_channel_id' => 5,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      24 =>
      array(
        'product_id' => 32,
        'selling_price' => 100000.0,
        'sales_channel_id' => 7,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      25 =>
      array(
        'product_id' => 4,
        'selling_price' => 300000.0,
        'sales_channel_id' => 6,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      26 =>
      array(
        'product_id' => 23,
        'selling_price' => 190000.0,
        'sales_channel_id' => 2,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      27 =>
      array(
        'product_id' => 19,
        'selling_price' => 170000.0,
        'sales_channel_id' => 3,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      28 =>
      array(
        'product_id' => 48,
        'selling_price' => 260000.0,
        'sales_channel_id' => 7,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      29 =>
      array(
        'product_id' => 49,
        'selling_price' => 210000.0,
        'sales_channel_id' => 2,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      30 =>
      array(
        'product_id' => 1,
        'selling_price' => 170000.0,
        'sales_channel_id' => 8,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      31 =>
      array(
        'product_id' => 41,
        'selling_price' => 260000.0,
        'sales_channel_id' => 8,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      32 =>
      array(
        'product_id' => 8,
        'selling_price' => 170000.0,
        'sales_channel_id' => 2,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      33 =>
      array(
        'product_id' => 12,
        'selling_price' => 60000.0,
        'sales_channel_id' => 8,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      34 =>
      array(
        'product_id' => 33,
        'selling_price' => 90000.0,
        'sales_channel_id' => 6,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      35 =>
      array(
        'product_id' => 40,
        'selling_price' => 50000.0,
        'sales_channel_id' => 6,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      36 =>
      array(
        'product_id' => 34,
        'selling_price' => 120000.0,
        'sales_channel_id' => 3,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
      37 =>
      array(
        'product_id' => 27,
        'selling_price' => 40000.0,
        'sales_channel_id' => 5,
        'online_rep_id' => 1,
        'sales_rep_id' => 1,
        'sale_confirmed_by' => NULL,
        'sale_confirmer_type' => NULL,
      ),
    ));
  }
}
