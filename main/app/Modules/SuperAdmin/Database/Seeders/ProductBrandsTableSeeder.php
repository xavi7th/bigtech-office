<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class ProductBrandsTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('product_brands')->delete();

    \DB::table('product_brands')->insert(array(
      0 =>
      array(
        'name' => 'Samsung',
        'logo_url' => 'http://lorempixel.com/640/480/business',
        'created_at' => '2020-03-29 16:04:56',
        'updated_at' => '2020-03-29 16:04:56',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'name' => 'Apple',
        'logo_url' => 'http://lorempixel.com/640/480/business',
        'created_at' => '2020-03-29 16:05:11',
        'updated_at' => '2020-03-29 16:05:11',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'name' => 'Sony',
        'logo_url' => 'http://lorempixel.com/640/480/business',
        'created_at' => '2020-03-29 16:05:18',
        'updated_at' => '2020-03-29 16:05:18',
        'deleted_at' => NULL,
      ),
      3 =>
      array(
        'name' => 'Nokia',
        'logo_url' => 'http://lorempixel.com/640/480/business',
        'created_at' => '2020-03-29 16:05:26',
        'updated_at' => '2020-03-29 16:05:26',
        'deleted_at' => NULL,
      ),
      4 =>
      array(
        'name' => 'Lenovo',
        'logo_url' => 'http://lorempixel.com/640/480/business',
        'created_at' => '2020-03-29 16:05:41',
        'updated_at' => '2020-03-29 16:05:41',
        'deleted_at' => NULL,
      ),
      5 =>
      array(
        'name' => 'HP',
        'logo_url' => 'http://lorempixel.com/640/480/business',
        'created_at' => '2020-03-29 16:06:00',
        'updated_at' => '2020-03-29 16:06:00',
        'deleted_at' => NULL,
      ),
      6 =>
      array(
        'name' => 'Dell',
        'logo_url' => 'http://lorempixel.com/640/480/business',
        'created_at' => '2020-03-29 16:06:03',
        'updated_at' => '2020-03-29 16:06:03',
        'deleted_at' => NULL,
      ),
      7 =>
      array(
        'name' => 'Motorola',
        'logo_url' => 'http://lorempixel.com/640/480/business',
        'created_at' => '2020-03-29 16:06:17',
        'updated_at' => '2020-03-29 16:06:17',
        'deleted_at' => NULL,
      ),
      8 =>
      array(
        'name' => 'Gionee',
        'logo_url' => 'http://lorempixel.com/640/480/business',
        'created_at' => '2020-03-29 16:06:21',
        'updated_at' => '2020-03-29 16:06:21',
        'deleted_at' => NULL,
      ),
      9 =>
      array(
        'name' => 'Infinix',
        'logo_url' => 'http://lorempixel.com/640/480/business',
        'created_at' => '2020-03-29 16:06:30',
        'updated_at' => '2020-03-29 16:06:30',
        'deleted_at' => NULL,
      ),
      10 =>
      array(
        'name' => 'Techno',
        'logo_url' => 'http://lorempixel.com/640/480/business',
        'created_at' => '2020-03-29 16:06:44',
        'updated_at' => '2020-03-29 16:06:44',
        'deleted_at' => NULL,
      ),
      11 =>
      array(
        'name' => 'HTC',
        'logo_url' => 'http://lorempixel.com/640/480/business',
        'created_at' => '2020-03-29 16:06:47',
        'updated_at' => '2020-03-29 16:06:47',
        'deleted_at' => NULL,
      ),
      12 =>
      array(
        'name' => 'OnePlus',
        'logo_url' => 'http://lorempixel.com/640/480/business',
        'created_at' => '2020-03-29 16:06:52',
        'updated_at' => '2020-03-29 16:06:52',
        'deleted_at' => NULL,
      ),
      13 =>
      array(
        'name' => 'Huawei',
        'logo_url' => 'http://lorempixel.com/640/480/business',
        'created_at' => '2020-03-29 16:07:00',
        'updated_at' => '2020-03-29 16:07:00',
        'deleted_at' => NULL,
      ),
    ));
  }
}
