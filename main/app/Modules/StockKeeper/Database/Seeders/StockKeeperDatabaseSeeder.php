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

    StockKeeper::create([
      'full_name' => 'SysDef Sales Rep',
      'email' => 'stockkeeper@' . strtolower(str_replace(" ", "", config('app.name'))) . '.com',
      'password' => 'stock-keepers',
    ]);
    factory(StockKeeper::class, 5)->create();
  }
}
