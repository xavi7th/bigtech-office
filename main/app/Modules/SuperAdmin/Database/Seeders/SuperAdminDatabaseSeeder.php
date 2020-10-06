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
use App\Modules\SuperAdmin\Database\Seeders\ProductPricesTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\SalesChannelsTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductBatchesTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProcessorSpeedsTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductExpensesTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductStatusesTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductSuppliersTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductCategoriesTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductModelImagesTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductModelQaTestTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\ProductSaleRecordsTableSeeder;
use App\Modules\SuperAdmin\Database\Seeders\CompanyBankAccountsTableSeeder;
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

    $this->call(OfficeBranchesTableSeeder::class);

    factory(SuperAdmin::class, 1)->create();

    // factory(OtherExpense::class, 50)->create();
    $this->call(ProductBatchesTableSeeder::class);
    $this->call(ProductBrandsTableSeeder::class);
    $this->call(ProductCategoriesTableSeeder::class);
    $this->call(ProductColorsTableSeeder::class);
    $this->call(ProductGradesTableSeeder::class);
    $this->call(ProductModelsTableSeeder::class);
    $this->call(ProductSuppliersTableSeeder::class);
    $this->call(ResellersTableSeeder::class);
    $this->call(StorageSizesTableSeeder::class);
    $this->call(StorageTypesTableSeeder::class);
    $this->call(ProcessorSpeedsTableSeeder::class);
    // $this->call(ProductPricesTableSeeder::class);
    // $this->call(ProductDescriptionSummariesTableSeeder::class);
    $this->call(ProductStatusesTableSeeder::class);
    // $this->call(ProductsTableSeeder::class);
    // $this->call(UserCommentsTableSeeder::class);
    $this->call(QaTestsTableSeeder::class);
    // $this->call(ProductModelQaTestTableSeeder::class);
    // $this->call(ProductQaTestResultsTableSeeder::class);
    // $this->call(ProductModelImagesTableSeeder::class);
    // $this->call(ProductExpensesTableSeeder::class);
    $this->call(SalesChannelsTableSeeder::class);
    // $this->call(ProductSaleRecordsTableSeeder::class);
    $this->call(CompanyBankAccountsTableSeeder::class);
  }
}
