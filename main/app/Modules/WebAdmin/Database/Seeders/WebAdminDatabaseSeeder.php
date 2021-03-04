<?php

namespace App\Modules\WebAdmin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Modules\WebAdmin\Models\WebAdmin;

class WebAdminDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    WebAdmin::create([
      'full_name' => 'SysDef Web Admin',
      'email' => 'webadmins@' . strtolower(str_replace(" ", "", config('app.name'))) . '.com',
      'password' => 'web-admins',
    ]);
    app()->environment('local') && factory(WebAdmin::class, 1)->create();
  }
}
