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

    factory(WebAdmin::class, 1)->create();

    // $this->call("OthersTableSeeder");
  }
}
