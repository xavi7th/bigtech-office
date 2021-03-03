<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class OfficeBranchesTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('office_branches')->delete();

    \DB::table('office_branches')->insert(array(
      0 =>
      array(
        'id' => 1,
        'city' => 'Lagos',
        'country' => 'Nigeria',
        'created_at' => NULL,
        'updated_at' => NULL,
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'id' => 2,
        'city' => 'Abuja',
        'country' => 'Nigeria',
        'created_at' => '2020-04-06 00:46:12',
        'updated_at' => '2020-04-06 00:46:12',
        'deleted_at' => NULL,
      ),
    ));
  }
}
