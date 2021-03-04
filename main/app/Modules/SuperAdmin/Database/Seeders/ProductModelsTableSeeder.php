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
        'product_brand_id' => 1,
        'product_category_id' => 2,
        'name' => 'Galaxy Note 10',
        'img_url' => null,
        'created_at' => '2020-03-29 18:52:09',
        'updated_at' => '2020-03-29 18:52:09',
      ),
      1 =>
      array(
        'product_brand_id' => 2,
        'product_category_id' => 2,
        'name' => 'iPhone XsMax',
        'img_url' => null,
        'created_at' => '2020-03-29 18:52:24',
        'updated_at' => '2020-03-29 18:52:24',
      ),
      2 =>
      array(
        'product_brand_id' => 2,
        'product_category_id' => 2,
        'name' => 'iPhone 7+',
        'img_url' => null,
        'created_at' => '2020-03-29 18:52:24',
        'updated_at' => '2020-03-29 18:52:24',
      ),
      3 =>
      array(
        'product_brand_id' => 2,
        'product_category_id' => 2,
        'name' => 'iPhone 6',
        'img_url' => null,
        'created_at' => '2020-03-29 18:52:24',
        'updated_at' => '2020-03-29 18:52:24',
      ),
      4 =>
      array(
        'product_brand_id' => 1,
        'product_category_id' => 2,
        'name' => 'S9+',
        'img_url' => null,
        'created_at' => '2020-03-29 18:52:24',
        'updated_at' => '2020-03-29 18:52:24',
      ),
      5 =>
      array(
        'product_brand_id' => 1,
        'product_category_id' => 2,
        'name' => 'S10',
        'img_url' => null,
        'created_at' => '2020-03-29 18:52:24',
        'updated_at' => '2020-03-29 18:52:24',
      ),
    ));
  }
}
