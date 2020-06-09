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
        'city' => 'North Joelle',
        'country' => 'Norway',
        'created_at' => '2020-04-06 00:46:12',
        'updated_at' => '2020-04-06 00:46:12',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'id' => 3,
        'city' => 'Zboncakhaven',
        'country' => 'Timor-Leste',
        'created_at' => '2020-04-06 00:46:14',
        'updated_at' => '2020-04-06 00:46:14',
        'deleted_at' => NULL,
      ),
      3 =>
      array(
        'id' => 4,
        'city' => 'Port Isomland',
        'country' => 'Serbia',
        'created_at' => '2020-04-06 00:46:15',
        'updated_at' => '2020-04-06 00:46:15',
        'deleted_at' => NULL,
      ),
      4 =>
      array(
        'id' => 5,
        'city' => 'Port Brant',
        'country' => 'Tokelau',
        'created_at' => '2020-04-06 00:46:16',
        'updated_at' => '2020-04-06 00:46:16',
        'deleted_at' => NULL,
      ),
      5 =>
      array(
        'id' => 6,
        'city' => 'New Irwin',
        'country' => 'Iceland',
        'created_at' => '2020-04-06 00:46:17',
        'updated_at' => '2020-04-06 00:46:17',
        'deleted_at' => NULL,
      ),
      6 =>
      array(
        'id' => 7,
        'city' => 'Edbury',
        'country' => 'Macao',
        'created_at' => '2020-04-06 00:46:18',
        'updated_at' => '2020-04-06 00:46:18',
        'deleted_at' => NULL,
      ),
      7 =>
      array(
        'id' => 8,
        'city' => 'North Orinchester',
        'country' => 'Romania',
        'created_at' => '2020-04-06 00:46:19',
        'updated_at' => '2020-04-06 00:46:19',
        'deleted_at' => NULL,
      ),
      8 =>
      array(
        'id' => 9,
        'city' => 'Ratkeberg',
        'country' => 'Slovenia',
        'created_at' => '2020-04-06 00:46:19',
        'updated_at' => '2020-04-06 00:46:19',
        'deleted_at' => NULL,
      ),
    ));
  }
}
