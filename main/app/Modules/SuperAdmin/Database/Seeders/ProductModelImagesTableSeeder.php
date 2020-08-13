<?php

namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class ProductModelImagesTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('product_model_images')->delete();

    \DB::table('product_model_images')->insert(array(
      0 =>
      array(
        'product_model_id' => 1,
        'img_url' => 'http://lorempixel.com/640/480/business',
        'thumb_url' => 'http://lorempixel.com/150/200/business',
        'created_at' => '2020-03-23 16:57:51',
        'updated_at' => '2020-03-23 16:57:51',
      ),
      1 =>
      array(
        'product_model_id' => 1,
        'img_url' => 'http://lorempixel.com/640/480',
        'thumb_url' => 'http://lorempixel.com/150/200',
        'created_at' => '2020-03-23 16:58:59',
        'updated_at' => '2020-03-23 16:58:59',
      ),
      2 =>
      array(
        'product_model_id' => 1,
        'img_url' => 'http://lorempixel.com/640/480',
        'thumb_url' => 'http://lorempixel.com/150/200',
        'created_at' => '2020-03-23 16:59:02',
        'updated_at' => '2020-03-23 16:59:02',
      ),
      3 =>
      array(
        'product_model_id' => 1,
        'img_url' => 'http://lorempixel.com/640/480',
        'thumb_url' => 'http://lorempixel.com/150/200',
        'created_at' => '2020-03-23 16:59:04',
        'updated_at' => '2020-03-23 16:59:04',
      ),
      4 =>
      array(
        'product_model_id' => 1,
        'img_url' => 'http://lorempixel.com/640/480',
        'thumb_url' => 'http://lorempixel.com/150/200',
        'created_at' => '2020-03-23 16:59:06',
        'updated_at' => '2020-03-23 16:59:06',
      ),
      5 =>
      array(
        'product_model_id' => 1,
        'img_url' => 'http://lorempixel.com/640/480',
        'thumb_url' => 'http://lorempixel.com/150/200',
        'created_at' => '2020-03-23 16:59:08',
        'updated_at' => '2020-03-23 16:59:08',
      ),
      6 =>
      array(
        'product_model_id' => 1,
        'img_url' => 'http://lorempixel.com/640/480',
        'thumb_url' => 'http://lorempixel.com/150/200',
        'created_at' => '2020-03-23 16:59:09',
        'updated_at' => '2020-03-23 16:59:09',
      ),
      7 =>
      array(
        'product_model_id' => 1,
        'img_url' => 'http://lorempixel.com/640/480',
        'thumb_url' => 'http://lorempixel.com/150/200',
        'created_at' => '2020-03-23 16:59:10',
        'updated_at' => '2020-03-23 16:59:10',
      ),
      8 =>
      array(
        'product_model_id' => 1,
        'img_url' => 'http://lorempixel.com/640/480',
        'thumb_url' => 'http://lorempixel.com/150/200',
        'created_at' => '2020-03-23 16:59:11',
        'updated_at' => '2020-03-23 16:59:11',
      ),
      9 =>
      array(
        'product_model_id' => 1,
        'img_url' => 'http://lorempixel.com/640/480',
        'thumb_url' => 'http://lorempixel.com/150/200',
        'created_at' => '2020-03-23 16:59:19',
        'updated_at' => '2020-03-23 16:59:19',
      ),
      10 =>
      array(
        'product_model_id' => 1,
        'img_url' => 'http://lorempixel.com/640/480',
        'thumb_url' => 'http://lorempixel.com/150/200',
        'created_at' => '2020-03-23 16:59:20',
        'updated_at' => '2020-03-23 16:59:20',
      ),
      11 =>
      array(
        'product_model_id' => 1,
        'img_url' => 'http://lorempixel.com/640/480',
        'thumb_url' => 'http://lorempixel.com/150/200',
        'created_at' => '2020-03-23 16:59:21',
        'updated_at' => '2020-03-23 16:59:21',
      ),
      12 =>
      array(
        'product_model_id' => 2,
        'img_url' => 'http://lorempixel.com/640/480',
        'thumb_url' => 'http://lorempixel.com/150/200',
        'created_at' => '2020-03-23 16:59:28',
        'updated_at' => '2020-03-23 16:59:28',
      ),
      13 =>
      array(
        'product_model_id' => 2,
        'img_url' => 'http://lorempixel.com/640/480',
        'thumb_url' => 'http://lorempixel.com/150/200',
        'created_at' => '2020-03-23 16:59:29',
        'updated_at' => '2020-03-23 16:59:29',
      ),
      14 =>
      array(
        'product_model_id' => 5,
        'img_url' => 'http://lorempixel.com/640/480',
        'thumb_url' => 'http://lorempixel.com/150/200',
        'created_at' => '2020-03-23 16:59:34',
        'updated_at' => '2020-03-23 16:59:34',
      ),
    ));
  }
}
