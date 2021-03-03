<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class ResellersTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('resellers')->delete();

    \DB::table('resellers')->insert(array(
      0 =>
      array(
        'business_name' => 'Saheed',
        'ceo_name' => 'Tia71',
        'address' => '834 Gleichner Camp',
        'phone' => '814-618-6635',
        'img_url' => 'https://s3.amazonaws.com/uifaces/faces/twitter/hugomano/128.jpg',
        'created_at' => '2020-03-20 14:20:14',
        'updated_at' => '2020-03-20 15:15:42',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'business_name' => 'Gizmo',
        'ceo_name' => 'Franz_Quitzon73',
        'address' => '1273 Lesch Parkway',
        'phone' => '187-180-6603',
        'img_url' => 'https://s3.amazonaws.com/uifaces/faces/twitter/pixage/128.jpg',
        'created_at' => '2020-03-20 14:21:07',
        'updated_at' => '2020-03-20 14:21:07',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'business_name' => 'The Elects',
        'ceo_name' => 'Harrison_Konopelski95',
        'address' => '200 Bashirian Pine',
        'phone' => '846-773-5061',
        'img_url' => 'https://s3.amazonaws.com/uifaces/faces/twitter/chrisstumph/128.jpg',
        'created_at' => '2020-03-20 14:21:08',
        'updated_at' => '2020-03-20 14:21:08',
        'deleted_at' => NULL,
      ),
    ));
  }
}
