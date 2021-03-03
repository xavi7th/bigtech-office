<?php

namespace App\Modules\SalesRep\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\SalesRep\Models\SalesRep;


class SalesRepDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->call(SalesRepTableSeeder::class);
  }
}


class SalesRepTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    SalesRep::create([
      'full_name' => 'SysDef Sales Rep',
      'email' => 'salesrep@' . strtolower(str_replace(" ", "", config('app.name'))) . '.com',
      'password' => 'sales-reps',
    ]);
    factory(SalesRep::class, 1)->create();
    factory(SalesRep::class, 1)->states('verified')->create();
    factory(SalesRep::class, 1)->states('inactive')->create();
    factory(SalesRep::class, 1)->states('callCenter')->create();
    // factory(SalesRep::class, 1)->states('walkIn')->create();
    // factory(SalesRep::class, 1)->states('socialMedia')->create();
  }
}
