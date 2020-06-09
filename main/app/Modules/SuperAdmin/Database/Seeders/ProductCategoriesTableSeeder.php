<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class ProductCategoriesTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('product_categories')->delete();

    \DB::table('product_categories')->insert(array(
      0 =>
      array(
        'name' => 'desktops',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 16:44:34',
        'updated_at' => '2020-03-29 16:44:34',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'name' => 'phones',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 16:44:41',
        'updated_at' => '2020-03-29 16:44:41',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'name' => 'laptops',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 16:44:47',
        'updated_at' => '2020-03-29 16:44:47',
        'deleted_at' => NULL,
      ),
      3 =>
      array(
        'name' => 'tablets',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 16:44:51',
        'updated_at' => '2020-03-29 16:44:51',
        'deleted_at' => NULL,
      ),
      4 =>
      array(
        'name' => 'watches',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 16:44:55',
        'updated_at' => '2020-03-29 16:44:55',
        'deleted_at' => NULL,
      ),
      5 =>
      array(
        'name' => 'consoles',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 16:44:59',
        'updated_at' => '2020-03-29 16:44:59',
        'deleted_at' => NULL,
      ),
      6 =>
      array(
        'name' => 'accessories',
        'img_url' => 'http://lorempixel.com/640/480/nightlife',
        'created_at' => '2020-03-29 16:45:13',
        'updated_at' => '2020-03-29 16:45:13',
        'deleted_at' => NULL,
      ),
    ));
  }
}
