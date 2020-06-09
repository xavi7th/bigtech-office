<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class ProductModelQaTestTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('product_model_qa_test')->delete();

    \DB::table('product_model_qa_test')->insert(array(
      0 =>
      array(
        'product_model_id' => 1,
        'qa_test_id' => 1,
      ),
      1 =>
      array(
        'product_model_id' => 1,
        'qa_test_id' => 2,
      ),
      2 =>
      array(
        'product_model_id' => 1,
        'qa_test_id' => 6,
      ),
      3 =>
      array(
        'product_model_id' => 1,
        'qa_test_id' => 7,
      ),
      4 =>
      array(
        'product_model_id' => 1,
        'qa_test_id' => 8,
      ),
      5 =>
      array(
        'product_model_id' => 1,
        'qa_test_id' => 11,
      ),
      6 =>
      array(
        'product_model_id' => 1,
        'qa_test_id' => 14,
      ),
      7 =>
      array(
        'product_model_id' => 1,
        'qa_test_id' => 24,
      ),
    ));
  }
}
