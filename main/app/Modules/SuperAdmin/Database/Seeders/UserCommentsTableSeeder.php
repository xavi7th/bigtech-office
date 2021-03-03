<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class UserCommentsTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('user_comments')->delete();

    \DB::table('user_comments')->insert(array(
      0 =>
      array(
        'user_id' => 2,
        'user_type' => 'App\\Modules\\Auditor\\Models\\Auditor',
        'subject_id' => 1,
        'subject_type' => 'App\\Modules\\SuperAdmin\\Models\\Product',
        'comment' => 'This is a very great software. Make sure to use it to the max',
        'created_at' => '2020-03-22 13:33:52',
        'updated_at' => '2020-03-22 13:33:52',
        'deleted_at' => NULL,
      ),
    ));
  }
}
