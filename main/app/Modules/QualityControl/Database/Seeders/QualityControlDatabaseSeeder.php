<?php

namespace App\Modules\QualityControl\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Modules\QualityControl\Models\QualityControl;

class QualityControlDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    factory(QualityControl::class, 1)->create();
  }
}
