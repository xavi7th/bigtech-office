<?php

namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\SuperAdmin\Models\OtherExpense;
use App\Modules\SuperAdmin\Database\Seeders\QaTestsTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductsTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ResellersTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\StorageSizesTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\StorageTypesTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\UserCommentsTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductBrandsTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductColorsTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductGradesTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductModelsTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\SalesChannelsTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductBatchesTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProcessorSpeedsTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductExpensesTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductStatusesTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductSuppliersTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductCategoriesTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductModelImagesTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductModelQaTestTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductQaTestResultsTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductDescriptionSummariesTableSeeder;

class SuperAdminDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    SuperAdmin::create([
      'full_name' => 'SysDef SuperAdmin',
      'email' => 'biggie@' . strtolower(str_replace(" ", "", config('app.name'))) . '.website',
      'password' => 'theboss',
    ]);

    factory(SuperAdmin::class)->create([
      'full_name' => 'Biggie Boss',
      'email' => 'bigtech@bigtech.website',
      'password' => 'bigtechboss'
    ]);
    app()->environment('local') && factory(OtherExpense::class, 1)->create();
    $this->call(ProductStatusesTableSeeder::class);
    $this->call(QaTestsTableSeeder::class);
    $this->call(SalesChannelsTableSeeder::class);
    $this->call(ProductBatchesTableSeeder::class);
    $this->call(ProductBrandsTableSeeder::class);
    $this->call(ProductCategoriesTableSeeder::class);
    $this->call(ProductColorsTableSeeder::class);
    $this->call(ProductGradesTableSeeder::class);
    $this->call(ProductModelsTableSeeder::class);
    app()->environment('local') && $this->call(ProductSuppliersTableSeeder::class);
    app()->environment('local') && $this->call(ResellersTableSeeder::class);
    $this->call(StorageSizesTableSeeder::class);
    $this->call(StorageTypesTableSeeder::class);
    $this->call(ProcessorSpeedsTableSeeder::class);
    $this->call(ProductDescriptionSummariesTableSeeder::class);
    app()->environment('local') && $this->call(ProductsTableSeeder::class);
    app()->environment('local') && $this->call(UserCommentsTableSeeder::class);
    app()->environment('local') && $this->call(ProductModelQaTestTableSeeder::class);
    app()->environment('local') && $this->call(ProductQaTestResultsTableSeeder::class);
    app()->environment('local') && $this->call(ProductModelImagesTableSeeder::class);
    app()->environment('local') && $this->call(ProductExpensesTableSeeder::class);
    // $this->call(ProductSaleRecordsTableSeeder::class);
  }
}
