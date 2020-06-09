<?php

namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class ProcessorSpeedsTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('processor_speeds')->delete();

    \DB::table('processor_speeds')->insert(array(
      0 =>
      array(
        'speed' => 'Core i7',
        'created_at' => '2020-03-20 11:15:22',
        'updated_at' => '2020-03-20 11:15:22',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'speed' => 'Core i5',
        'created_at' => '2020-03-21 07:45:45',
        'updated_at' => '2020-03-21 07:45:45',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'speed' => 'Core i3',
        'created_at' => '2020-03-21 07:45:48',
        'updated_at' => '2020-03-21 07:45:48',
        'deleted_at' => NULL,
      ),
      3 =>
      array(
        'speed' => 'Quad core',
        'created_at' => '2020-03-21 07:45:59',
        'updated_at' => '2020-03-21 07:45:59',
        'deleted_at' => NULL,
      ),
      4 =>
      array(
        'speed' => 'Dual core',
        'created_at' => '2020-03-21 12:15:03',
        'updated_at' => '2020-03-21 12:15:03',
        'deleted_at' => NULL,
      ),
      5 =>
      array(
        'speed' => 'Core i5 3rd gen',
        'created_at' => '2020-03-21 12:15:33',
        'updated_at' => '2020-03-21 12:15:33',
        'deleted_at' => NULL,
      ),
      6 =>
      array(
        'speed' => 'Core i5 5th gen',
        'created_at' => '2020-03-21 12:15:39',
        'updated_at' => '2020-03-21 12:15:39',
        'deleted_at' => NULL,
      ),
      7 =>
      array(
        'speed' => 'Core i5 7th gen',
        'created_at' => '2020-03-21 12:15:47',
        'updated_at' => '2020-03-21 12:15:47',
        'deleted_at' => NULL,
      ),
      8 =>
      array(
        'speed' => 'Core i5 8th gen',
        'created_at' => '2020-03-21 12:15:52',
        'updated_at' => '2020-03-21 12:15:52',
        'deleted_at' => NULL,
      ),
      9 =>
      array(
        'speed' => 'Core i5 9th gen',
        'created_at' => '2020-03-21 12:15:56',
        'updated_at' => '2020-03-21 12:15:56',
        'deleted_at' => NULL,
      ),
    ));
  }
}
