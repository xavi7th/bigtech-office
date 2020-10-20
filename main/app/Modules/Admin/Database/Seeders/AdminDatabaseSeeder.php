<?php

namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Admin\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Database\Seeders\OfficeBranchesTableSeeder;

class AdminDatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

    $this->call(OfficeBranchesTableSeeder::class);

    Admin::create([
      'full_name' => 'SysDef Admin',
      'email' => 'admin@' . strtolower(str_replace(" ", "", config('app.name'))) . '.com',
      'password' => 'admin@elects',
    ]);


    factory(Admin::class, 5)->create();

		// $this->call("OthersTableSeeder");
	}
}
