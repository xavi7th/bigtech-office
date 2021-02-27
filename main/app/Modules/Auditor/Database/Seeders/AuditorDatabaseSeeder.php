<?php

namespace App\Modules\Auditor\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Auditor\Models\Auditor;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Database\Seeders\OfficeBranchesTableSeeder;

class AuditorDatabaseSeeder extends Seeder
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

    Auditor::create([
      'full_name' => 'SysDef Auditor',
      'email' => 'auditor@' . strtolower(str_replace(" ", "", config('app.name'))) . '.com',
      'password' => 'auditor@bigtech',
    ]);


    factory(Auditor::class, 5)->create();

		// $this->call("OthersTableSeeder");
	}
}
