<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class QaTestsTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('qa_tests')->delete();

    \DB::table('qa_tests')->insert(array(
      0 =>
      array(
        'name' => 'Battery',
        'created_at' => '2020-03-22 17:20:43',
        'updated_at' => '2020-03-22 17:20:43',
      ),
      1 =>
      array(
        'name' => 'Charging',
        'created_at' => '2020-03-22 17:21:29',
        'updated_at' => '2020-03-22 17:21:29',
      ),
      2 =>
      array(
        'name' => 'Activation',
        'created_at' => '2020-03-22 17:21:38',
        'updated_at' => '2020-03-22 17:21:38',
      ),
      4 =>
      array(
        'name' => 'Fast charging',
        'created_at' => '2020-03-22 17:21:55',
        'updated_at' => '2020-03-22 17:21:55',
      ),
      5 =>
      array(
        'name' => 'SIM',
        'created_at' => '2020-03-22 17:22:05',
        'updated_at' => '2020-03-22 17:22:05',
      ),
      6 =>
      array(
        'name' => 'Phone call',
        'created_at' => '2020-03-22 17:22:15',
        'updated_at' => '2020-03-22 17:22:15',
      ),
      7 =>
      array(
        'name' => 'Mouth Piece',
        'created_at' => '2020-03-22 17:22:34',
        'updated_at' => '2020-03-22 17:22:34',
      ),
      8 =>
      array(
        'name' => 'Speaker',
        'created_at' => '2020-03-22 17:23:02',
        'updated_at' => '2020-03-22 17:23:02',
      ),
      9 =>
      array(
        'name' => 'Earpiece',
        'created_at' => '2020-03-22 17:27:36',
        'updated_at' => '2020-03-22 17:45:09',
      ),
      10 =>
      array(
        'name' => 'Volume Buttons',
        'created_at' => '2020-03-22 17:28:52',
        'updated_at' => '2020-03-22 17:28:52',
      ),
      11 =>
      array(
        'name' => 'Flash light',
        'created_at' => '2020-03-22 17:29:06',
        'updated_at' => '2020-03-22 17:29:06',
      ),
      12 =>
      array(
        'name' => 'Camera',
        'created_at' => '2020-03-22 17:29:17',
        'updated_at' => '2020-03-22 17:29:17',
      ),
      13 =>
      array(
        'name' => 'Sound Recorder',
        'created_at' => '2020-03-22 17:29:33',
        'updated_at' => '2020-03-22 17:29:33',
      ),
      14 =>
      array(
        'name' => 'Wifi',
        'created_at' => '2020-03-22 17:29:40',
        'updated_at' => '2020-03-22 17:29:40',
      ),
      15 =>
      array(
        'name' => 'Bluetooth',
        'created_at' => '2020-03-22 17:29:47',
        'updated_at' => '2020-03-22 17:29:47',
      ),
      16 =>
      array(
        'name' => '3g Network',
        'created_at' => '2020-03-22 17:30:00',
        'updated_at' => '2020-03-22 17:30:00',
      ),
      17 =>
      array(
        'name' => '4g Network',
        'created_at' => '2020-03-22 17:30:03',
        'updated_at' => '2020-03-22 17:30:03',
      ),
      18 =>
      array(
        'name' => '2g Network',
        'created_at' => '2020-03-22 17:30:11',
        'updated_at' => '2020-03-22 17:30:11',
      ),
      19 =>
      array(
        'name' => 'Fingerprint',
        'created_at' => '2020-03-22 17:30:30',
        'updated_at' => '2020-03-22 17:30:30',
      ),
      20 =>
      array(
        'name' => 'Face ID',
        'created_at' => '2020-03-22 17:30:39',
        'updated_at' => '2020-03-22 17:30:39',
      ),
      21 =>
      array(
        'name' => 'Vibrator',
        'created_at' => '2020-03-22 17:30:46',
        'updated_at' => '2020-03-22 17:30:46',
      ),
      22 =>
      array(
        'name' => 'Earphone',
        'created_at' => '2020-03-22 17:30:57',
        'updated_at' => '2020-03-22 17:30:57',
      ),
      23 =>
      array(
        'name' => 'Screen',
        'created_at' => '2020-03-22 17:31:08',
        'updated_at' => '2020-03-22 17:31:08',
      ),
      24 =>
      array(
        'name' => 'Power button',
        'created_at' => '2020-03-22 17:31:14',
        'updated_at' => '2020-03-22 17:31:14',
      ),
      25 =>
      array(
        'name' => 'S-Pen',
        'created_at' => '2020-03-22 17:36:37',
        'updated_at' => '2020-03-22 17:36:37',
      ),
      26 =>
      array(
        'name' => 'Sensor',
        'created_at' => '2020-03-22 17:36:47',
        'updated_at' => '2020-03-22 17:36:47',
      ),
    ));
  }
}
