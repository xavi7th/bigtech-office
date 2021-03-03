<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class StorageTypesTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('storage_types')->delete();

    \DB::table('storage_types')->insert(array(
      0 =>
      array(
        'type' => 'SSD',
        'created_at' => '2020-03-20 12:51:04',
        'updated_at' => '2020-03-20 12:52:39',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'type' => 'HDD',
        'created_at' => '2020-03-20 12:51:11',
        'updated_at' => '2020-03-20 12:51:11',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'type' => 'skip',
        'created_at' => '2020-03-20 12:51:11',
        'updated_at' => '2020-03-20 12:51:11',
        'deleted_at' => NULL,
      ),
    ));
  }
}
