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
    QualityControl::create([
      'full_name' => 'SysDef Quality Control',
      'email' => 'qualitycontrol@' . strtolower(str_replace(" ", "", config('app.name'))) . '.com',
      'password' => 'quality-controls',
    ]);
    factory(QualityControl::class, 10)->create();
  }
}
