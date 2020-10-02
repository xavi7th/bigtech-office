<?php

namespace App\Modules\Accountant\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Accountant\Models\Accountant;

class AccountantDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    factory(Accountant::class, 1)->create();
  }
}
