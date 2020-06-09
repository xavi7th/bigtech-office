<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class ProductModelsTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('product_models')->delete();

    \DB::table('product_models')->insert(array(
      0 =>
      array(
        'product_brand_id' => 13,
        'product_category_id' => 6,
        'name' => 'Galaxy Note 10',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:52:09',
        'updated_at' => '2020-03-29 18:52:09',
      ),
      1 =>
      array(
        'product_brand_id' => 1,
        'product_category_id' => 3,
        'name' => 'iPhone XsMax',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:52:24',
        'updated_at' => '2020-03-29 18:52:24',
      ),
      2 =>
      array(
        'product_brand_id' => 5,
        'product_category_id' => 2,
        'name' => 'iPhone 7',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:52:35',
        'updated_at' => '2020-03-29 18:52:35',
      ),
      3 =>
      array(
        'product_brand_id' => 10,
        'product_category_id' => 2,
        'name' => 'iPhone 8',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:52:43',
        'updated_at' => '2020-03-29 18:52:43',
      ),
      4 =>
      array(
        'product_brand_id' => 3,
        'product_category_id' => 4,
        'name' => 'iPhone 7+',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:52:56',
        'updated_at' => '2020-03-29 18:52:56',
      ),
      5 =>
      array(
        'product_brand_id' => 11,
        'product_category_id' => 3,
        'name' => 'iPhone 8+',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:53:08',
        'updated_at' => '2020-03-29 18:53:08',
      ),
      6 =>
      array(
        'product_brand_id' => 14,
        'product_category_id' => 1,
        'name' => 'iPhone 6s+',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:53:12',
        'updated_at' => '2020-03-29 18:53:12',
      ),
      7 =>
      array(
        'product_brand_id' => 10,
        'product_category_id' => 5,
        'name' => 'iPhone 11',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:53:22',
        'updated_at' => '2020-03-29 18:53:22',
      ),
      8 =>
      array(
        'product_brand_id' => 7,
        'product_category_id' => 4,
        'name' => 'iPhone 11 pro',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:53:25',
        'updated_at' => '2020-03-29 18:53:25',
      ),
      9 =>
      array(
        'product_brand_id' => 9,
        'product_category_id' => 6,
        'name' => 'iPhone 11 pro max',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:53:33',
        'updated_at' => '2020-03-29 18:53:33',
      ),
      10 =>
      array(
        'product_brand_id' => 3,
        'product_category_id' => 3,
        'name' => 'iPhone X',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:53:37',
        'updated_at' => '2020-03-29 18:53:37',
      ),
      11 =>
      array(
        'product_brand_id' => 14,
        'product_category_id' => 7,
        'name' => 'iPhone Xs',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:53:44',
        'updated_at' => '2020-03-29 18:53:44',
      ),
      12 =>
      array(
        'product_brand_id' => 13,
        'product_category_id' => 5,
        'name' => 'iPhone Xr',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:53:47',
        'updated_at' => '2020-03-29 18:53:47',
      ),
      13 =>
      array(
        'product_brand_id' => 5,
        'product_category_id' => 7,
        'name' => 'iPhone 12',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:53:56',
        'updated_at' => '2020-03-29 18:53:56',
      ),
      14 =>
      array(
        'product_brand_id' => 6,
        'product_category_id' => 2,
        'name' => 'iPhone 6',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:54:01',
        'updated_at' => '2020-03-29 18:54:01',
      ),
      15 =>
      array(
        'product_brand_id' => 4,
        'product_category_id' => 6,
        'name' => 'iPhone 6+',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:54:06',
        'updated_at' => '2020-03-29 18:54:06',
      ),
      16 =>
      array(
        'product_brand_id' => 7,
        'product_category_id' => 2,
        'name' => 'Galaxy S7',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:54:20',
        'updated_at' => '2020-03-29 18:54:20',
      ),
      17 =>
      array(
        'product_brand_id' => 12,
        'product_category_id' => 4,
        'name' => 'Galaxy S7 edge',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:54:23',
        'updated_at' => '2020-03-29 18:54:23',
      ),
      18 =>
      array(
        'product_brand_id' => 4,
        'product_category_id' => 6,
        'name' => 'Galaxy S8',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:54:33',
        'updated_at' => '2020-03-29 18:54:33',
      ),
      19 =>
      array(
        'product_brand_id' => 3,
        'product_category_id' => 5,
        'name' => 'Galaxy S8+',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:54:36',
        'updated_at' => '2020-03-29 18:54:36',
      ),
      20 =>
      array(
        'product_brand_id' => 13,
        'product_category_id' => 5,
        'name' => 'Galaxy S9',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:54:39',
        'updated_at' => '2020-03-29 18:54:39',
      ),
      21 =>
      array(
        'product_brand_id' => 2,
        'product_category_id' => 5,
        'name' => 'Galaxy S9+',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:54:52',
        'updated_at' => '2020-03-29 18:54:52',
      ),
      22 =>
      array(
        'product_brand_id' => 14,
        'product_category_id' => 3,
        'name' => 'Galaxy S8 active',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:55:04',
        'updated_at' => '2020-03-29 18:55:04',
      ),
      23 =>
      array(
        'product_brand_id' => 13,
        'product_category_id' => 3,
        'name' => 'Galaxy Note 9',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 18:55:16',
        'updated_at' => '2020-03-29 18:55:16',
      ),
      24 =>
      array(
        'product_brand_id' => 5,
        'product_category_id' => 3,
        'name' => 'Galaxy Note 8',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 19:02:13',
        'updated_at' => '2020-03-29 19:02:13',
      ),
      25 =>
      array(
        'product_brand_id' => 6,
        'product_category_id' => 6,
        'name' => 'Galaxy Note 8+',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 19:02:17',
        'updated_at' => '2020-03-29 19:02:17',
      ),
    ));
  }
}
