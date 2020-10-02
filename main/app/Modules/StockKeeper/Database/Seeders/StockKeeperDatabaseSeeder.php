<?php

namespace App\Modules\StockKeeper\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Modules\StockKeeper\Models\StockKeeper;

class StockKeeperDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    factory(StockKeeper::class, 1)->create();
  }
}
