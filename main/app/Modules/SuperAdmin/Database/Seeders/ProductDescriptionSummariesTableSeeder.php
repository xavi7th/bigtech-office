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
        'description_summary' => "Barely larger than the Galaxy S10 and appreciably more compact than the S10+, the Galaxy Note10 has die-hard Note loyalists reaching for their pitchforks - Notes need to be bigger than the S-series, that's the norm. But if such reasoning stems from a time with one device in each of Samsung's high-end lineups, what's wrong with a double-Note double-S state of affairs (let's pretend for a minute the S10e doesn't exist for the sake of this argument)? The Note10 features a 6.3-inch display - that's 0.2 inches more than the S10, which you could count as a modern loophole in the laws of the Galaxy universe allowing it to carry the Note badge even if it's smaller than the S10+. The 1080p resolution is what's a bit more troubling - the S10's smaller screen is QHD, and so is the Note10+'s 6.8-incher - that's one in favor of the 'this isn't a Note' team, which also proclaim that Notes need to be equipped with the best available hardware. And this one isn't quite there. But it's got plenty nonetheless.",
        'created_at' => '2020-03-20 18:49:10',
        'updated_at' => '2020-03-20 18:59:18',
        'deleted_at' => NULL,
      ),
    ));
  }
}
