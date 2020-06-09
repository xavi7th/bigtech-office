<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class SalesChannelsTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('sales_channels')->delete();

    \DB::table('sales_channels')->insert(array(
      0 =>
      array(
        'channel_name' => 'Instagram',
        'created_at' => '2020-03-27 14:10:10',
        'updated_at' => '2020-03-27 14:13:03',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'channel_name' => 'Facebook',
        'created_at' => '2020-03-27 14:10:16',
        'updated_at' => '2020-03-27 14:10:16',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'channel_name' => 'WhatsApp',
        'created_at' => '2020-03-27 14:10:22',
        'updated_at' => '2020-03-27 14:10:22',
        'deleted_at' => NULL,
      ),
      3 =>
      array(
        'channel_name' => 'Phone Call',
        'created_at' => '2020-03-27 14:10:32',
        'updated_at' => '2020-03-27 14:10:32',
        'deleted_at' => NULL,
      ),
      4 =>
      array(
        'channel_name' => 'Walk In',
        'created_at' => '2020-03-27 14:10:38',
        'updated_at' => '2020-03-27 14:10:38',
        'deleted_at' => NULL,
      ),
      5 =>
      array(
        'channel_name' => 'Website',
        'created_at' => '2020-03-27 14:10:49',
        'updated_at' => '2020-03-27 14:10:49',
        'deleted_at' => NULL,
      ),
      6 =>
      array(
        'channel_name' => 'Direct Referral',
        'created_at' => '2020-03-27 14:10:56',
        'updated_at' => '2020-03-27 14:10:56',
        'deleted_at' => NULL,
      ),
      7 =>
      array(
        'channel_name' => 'Reseller',
        'created_at' => '2020-03-27 14:13:18',
        'updated_at' => '2020-03-27 14:13:18',
        'deleted_at' => NULL,
      ),
    ));
  }
}
