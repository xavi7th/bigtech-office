<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class StorageSizesTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('storage_sizes')->delete();

    \DB::table('storage_sizes')->insert(array(
      0 =>
      array(
        'size' => '1000',
        'created_at' => '2020-03-20 12:43:11',
        'updated_at' => '2020-03-20 12:45:01',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'size' => '250',
        'created_at' => '2020-03-20 12:43:17',
        'updated_at' => '2020-03-20 12:43:17',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'size' => '256',
        'created_at' => '2020-03-20 12:43:20',
        'updated_at' => '2020-03-20 12:43:20',
        'deleted_at' => NULL,
      ),
      3 =>
      array(
        'size' => '128',
        'created_at' => '2020-03-21 08:18:46',
        'updated_at' => '2020-03-21 08:18:46',
        'deleted_at' => NULL,
      ),
      4 =>
      array(
        'size' => '32',
        'created_at' => '2020-03-21 08:18:04',
        'updated_at' => '2020-03-21 08:18:04',
        'deleted_at' => NULL,
      ),
      5 =>
      array(
        'size' => '16',
        'created_at' => '2020-03-21 08:18:11',
        'updated_at' => '2020-03-21 08:18:11',
        'deleted_at' => NULL,
      ),
      6 =>
      array(
        'size' => '8',
        'created_at' => '2020-03-21 08:18:14',
        'updated_at' => '2020-03-21 08:18:14',
        'deleted_at' => NULL,
      ),
      7 =>
      array(
        'size' => '4',
        'created_at' => '2020-03-21 08:18:20',
        'updated_at' => '2020-03-21 08:18:20',
        'deleted_at' => NULL,
      ),
      8 =>
      array(
        'size' => '2',
        'created_at' => '2020-03-21 08:18:23',
        'updated_at' => '2020-03-21 08:18:23',
        'deleted_at' => NULL,
      ),
      9 =>
      array(
        'size' => '64',
        'created_at' => '2020-03-21 08:18:27',
        'updated_at' => '2020-03-21 08:18:27',
        'deleted_at' => NULL,
      ),
      10 =>
      array(
        'size' => '12',
        'created_at' => '2020-03-21 08:18:32',
        'updated_at' => '2020-03-21 08:18:32',
        'deleted_at' => NULL,
      ),
    ));
  }
}
