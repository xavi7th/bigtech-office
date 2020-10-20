<?php

namespace App\Modules\DispatchAdmin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Modules\DispatchAdmin\Models\DispatchAdmin;

class DispatchAdminDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    DispatchAdmin::create([
      'full_name' => 'SysDef Dispatch Admin',
      'email' => 'dispatchadmin@' . strtolower(str_replace(" ", "", config('app.name'))) . '.com',
      'password' => 'dispatch-admins',
    ]);
    factory(DispatchAdmin::class, 5)->create();

    // $this->call("OthersTableSeeder");
  }
}
