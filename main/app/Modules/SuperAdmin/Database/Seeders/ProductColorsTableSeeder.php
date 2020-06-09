<?php

namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class ProductColorsTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('product_colors')->delete();

    \DB::table('product_colors')->insert(array(
      0 =>
      array(
        'name' => 'midnight green',
        'created_at' => '2020-03-20 16:59:01',
        'updated_at' => '2020-03-29 12:14:41',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'name' => 'blue',
        'created_at' => '2020-03-20 16:59:07',
        'updated_at' => '2020-03-20 16:59:07',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'name' => 'black',
        'created_at' => '2020-03-20 16:59:11',
        'updated_at' => '2020-03-20 16:59:11',
        'deleted_at' => NULL,
      ),
      3 =>
      array(
        'name' => 'ivory',
        'created_at' => '2020-03-21 06:26:37',
        'updated_at' => '2020-03-21 06:26:37',
        'deleted_at' => NULL,
      ),
      4 =>
      array(
        'name' => 'turquoise',
        'created_at' => '2020-03-21 06:26:39',
        'updated_at' => '2020-03-21 06:26:39',
        'deleted_at' => NULL,
      ),
      5 =>
      array(
        'name' => 'indigo',
        'created_at' => '2020-03-21 06:26:40',
        'updated_at' => '2020-03-21 06:26:40',
        'deleted_at' => NULL,
      ),
      6 =>
      array(
        'name' => 'magenta',
        'created_at' => '2020-03-21 06:26:41',
        'updated_at' => '2020-03-21 06:26:41',
        'deleted_at' => NULL,
      ),
      7 =>
      array(
        'name' => 'salmon',
        'created_at' => '2020-03-21 06:26:42',
        'updated_at' => '2020-03-21 06:26:42',
        'deleted_at' => NULL,
      ),
      8 =>
      array(
        'name' => 'violet',
        'created_at' => '2020-03-21 06:30:33',
        'updated_at' => '2020-03-21 06:30:33',
        'deleted_at' => NULL,
      ),
      9 =>
      array(
        'name' => 'orchid',
        'created_at' => '2020-03-21 06:27:04',
        'updated_at' => '2020-03-21 06:27:04',
        'deleted_at' => NULL,
      ),
      10 =>
      array(
        'name' => 'lavender',
        'created_at' => '2020-03-21 06:30:32',
        'updated_at' => '2020-03-21 06:30:32',
        'deleted_at' => NULL,
      ),
      11 =>
      array(
        'name' => 'green',
        'created_at' => '2020-03-21 06:28:48',
        'updated_at' => '2020-03-21 06:28:48',
        'deleted_at' => NULL,
      ),
      12 =>
      array(
        'name' => 'teal',
        'created_at' => '2020-03-21 06:28:50',
        'updated_at' => '2020-03-21 06:28:50',
        'deleted_at' => NULL,
      ),
      13 =>
      array(
        'name' => 'pink',
        'created_at' => '2020-03-21 06:30:28',
        'updated_at' => '2020-03-21 06:30:28',
        'deleted_at' => NULL,
      ),
      14 =>
      array(
        'name' => 'cyan',
        'created_at' => '2020-03-21 06:28:52',
        'updated_at' => '2020-03-21 06:28:52',
        'deleted_at' => NULL,
      ),
      15 =>
      array(
        'name' => 'silver',
        'created_at' => '2020-03-21 06:28:53',
        'updated_at' => '2020-03-21 06:28:53',
        'deleted_at' => NULL,
      ),
      16 =>
      array(
        'name' => 'olive',
        'created_at' => '2020-03-21 06:28:54',
        'updated_at' => '2020-03-21 06:28:54',
        'deleted_at' => NULL,
      ),
      17 =>
      array(
        'name' => 'maroon',
        'created_at' => '2020-03-21 06:30:21',
        'updated_at' => '2020-03-21 06:30:21',
        'deleted_at' => NULL,
      ),
      18 =>
      array(
        'name' => 'purple',
        'created_at' => '2020-03-21 06:30:16',
        'updated_at' => '2020-03-21 06:30:16',
        'deleted_at' => NULL,
      ),
      19 =>
      array(
        'name' => 'white',
        'created_at' => '2020-03-21 06:29:12',
        'updated_at' => '2020-03-21 06:29:12',
        'deleted_at' => NULL,
      ),
      20 =>
      array(
        'name' => 'orange',
        'created_at' => '2020-03-21 06:30:02',
        'updated_at' => '2020-03-21 06:30:02',
        'deleted_at' => NULL,
      ),
      21 =>
      array(
        'name' => 'sky blue',
        'created_at' => '2020-03-21 06:29:38',
        'updated_at' => '2020-03-21 06:29:38',
        'deleted_at' => NULL,
      ),
      22 =>
      array(
        'name' => 'yellow',
        'created_at' => '2020-03-21 06:29:40',
        'updated_at' => '2020-03-21 06:29:40',
        'deleted_at' => NULL,
      ),
      23 =>
      array(
        'name' => 'grey',
        'created_at' => '2020-03-21 06:29:42',
        'updated_at' => '2020-03-21 06:29:42',
        'deleted_at' => NULL,
      ),
      24 =>
      array(
        'name' => 'lime',
        'created_at' => '2020-03-21 06:30:01',
        'updated_at' => '2020-03-21 06:30:01',
        'deleted_at' => NULL,
      ),
      25 =>
      array(
        'name' => 'gold',
        'created_at' => '2020-03-21 06:29:59',
        'updated_at' => '2020-03-21 06:29:59',
        'deleted_at' => NULL,
      ),
      26 =>
      array(
        'name' => 'azure',
        'created_at' => '2020-03-21 06:29:58',
        'updated_at' => '2020-03-21 06:29:58',
        'deleted_at' => NULL,
      ),
      27 =>
      array(
        'name' => 'mint green',
        'created_at' => '2020-03-21 06:29:52',
        'updated_at' => '2020-03-21 06:29:52',
        'deleted_at' => NULL,
      ),
      28 =>
      array(
        'name' => 'fuchsia',
        'created_at' => '2020-03-21 06:29:53',
        'updated_at' => '2020-03-21 06:29:53',
        'deleted_at' => NULL,
      ),
      29 =>
      array(
        'name' => 'plum',
        'created_at' => '2020-03-21 06:29:54',
        'updated_at' => '2020-03-21 06:29:54',
        'deleted_at' => NULL,
      ),
      30 =>
      array(
        'name' => 'red',
        'created_at' => '2020-03-29 12:08:33',
        'updated_at' => '2020-03-29 12:08:33',
        'deleted_at' => NULL,
      ),
      31 =>
      array(
        'name' => 'tan',
        'created_at' => '2020-03-29 12:14:06',
        'updated_at' => '2020-03-29 12:14:06',
        'deleted_at' => NULL,
      ),
    ));
  }
}
