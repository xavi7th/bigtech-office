<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class ProductDescriptionSummariesTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('product_description_summaries')->delete();

    \DB::table('product_description_summaries')->insert(array(
      0 =>
      array(
        'product_model_id' => 1,
        'description_summary' => 'Fuga necessitatibus consequatur nobis accusantium quas dolorem repellat aut. Debitis magnam quaerat nostrum tempore.',
        'created_at' => '2020-03-20 18:49:10',
        'updated_at' => '2020-03-20 18:59:18',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'product_model_id' => 2,
        'description_summary' => 'Provident sint doloribus error sunt est dignissimos. Eius consectetur unde officiis veniam qui molestias odit nihil. Est est autem non eum aperiam earum.',
        'created_at' => '2020-03-20 18:53:50',
        'updated_at' => '2020-03-20 18:53:50',
        'deleted_at' => NULL,
      ),
    ));
  }
}
