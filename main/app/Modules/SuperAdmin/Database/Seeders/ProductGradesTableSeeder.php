<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class ProductGradesTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('product_grades')->delete();

    \DB::table('product_grades')->insert(array(
      0 =>
      array(
        'grade' => 'A1',
      ),
      1 =>
      array(
        'grade' => 'B-',
      ),
      2 =>
      array(
        'grade' => 'B+',
      ),
      3 =>
      array(
        'grade' => 'B1',
      ),
      4 =>
      array(
        'grade' => 'C1',
      ),
      5 =>
      array(
        'grade' => 'C2',
      ),
      6 =>
      array(
        'grade' => 'C3',
      ),
      7 =>
      array(
        'grade' => 'KFLB',
      ),
      8 =>
      array(
        'grade' => 'Brand New',
      ),
      9 =>
      array(
        'grade' => 'Open Box',
      ),
      10 =>
      array(
        'grade' => 'PGL',
      ),
    ));
  }
}
