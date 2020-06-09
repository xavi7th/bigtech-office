<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class ProductQaTestResultsTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('product_qa_test_results')->delete();

    \DB::table('product_qa_test_results')->insert(array(
      0 =>
      array(
        'product_id' => 1,
        'qa_test_id' => 1,
        'is_qa_certified' => 1,
        'created_at' => '2020-03-23 15:59:49',
        'updated_at' => '2020-03-23 16:32:33',
      ),
      1 =>
      array(
        'product_id' => 1,
        'qa_test_id' => 2,
        'is_qa_certified' => 0,
        'created_at' => '2020-03-23 16:29:31',
        'updated_at' => '2020-03-23 16:32:33',
      ),
      2 =>
      array(
        'product_id' => 1,
        'qa_test_id' => 4,
        'is_qa_certified' => 1,
        'created_at' => '2020-03-23 16:29:31',
        'updated_at' => '2020-03-23 16:32:33',
      ),
      3 =>
      array(
        'product_id' => 1,
        'qa_test_id' => 7,
        'is_qa_certified' => 1,
        'created_at' => '2020-03-23 16:32:33',
        'updated_at' => '2020-03-23 16:32:33',
      ),
    ));
  }
}
