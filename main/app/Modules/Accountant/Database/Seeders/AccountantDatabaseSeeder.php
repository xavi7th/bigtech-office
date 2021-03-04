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

    Accountant::create([
      'full_name' => 'SysDef Sales Rep',
      'email' => 'salesrep@' . strtolower(str_replace(" ", "", config('app.name'))) . '.com',
      'password' => 'sales-reps',
    ]);
    app()->environment('local') && factory(Accountant::class, 2)->create();
  }
}
