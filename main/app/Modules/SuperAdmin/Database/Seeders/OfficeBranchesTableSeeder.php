<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use App\Modules\SuperAdmin\Models\OfficeBranch;
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
    app()->environment('local') && factory(OfficeBranch::class, 2)->create();
    !app()->environment('local') && factory(OfficeBranch::class)->create(['city' => 'Lagos']);
  }
}
