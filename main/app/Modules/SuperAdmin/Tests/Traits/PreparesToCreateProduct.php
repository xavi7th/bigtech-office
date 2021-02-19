<?php

namespace App\Modules\SuperAdmin\Tests\Traits;

use App\Modules\AppUser\Models\AppUser;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\AppUser\Models\ProductReceipt;
use App\Modules\SuperAdmin\Models\StorageSize;
use App\Modules\SuperAdmin\Models\StorageType;
use App\Modules\StockKeeper\Models\StockKeeper;
use App\Modules\SuperAdmin\Models\OfficeBranch;
use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Models\ProductBrand;
use App\Modules\SuperAdmin\Models\ProductColor;
use App\Modules\SuperAdmin\Models\ProductGrade;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Models\SalesChannel;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\ProcessorSpeed;
use App\Modules\SuperAdmin\Models\ProductCategory;
use App\Modules\SuperAdmin\Models\ProductSupplier;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Models\CompanyBankAccount;
use App\Modules\SuperAdmin\Models\SalesRecordBankAccount;

/**
 * Does the necessary steps to enable the smooth gerenration of products
 */
trait PreparesToCreateProduct
{

  private function create_product_in_stock()
  {
    $this->prepare_to_create_product();
    $product = factory(Product::class)->create(['product_status_id' => ProductStatus::inStockId()]);

    $this->assertEquals(ProductStatus::inStockId(), $product->product_status_id);

    return $product;
  }

  private function create_product_on_delivery()
  {
    $this->prepare_to_create_product();


    $product = factory(Product::class)->create(['product_status_id' => ProductStatus::scheduledDeliveryId()]);
    $user = factory(SalesRep::class)->create(['unit' => 'social-media']);

    $user->product_dispatch_requests()->create([
      'product_description' => $this->faker->sentence,
      'proposed_selling_price' => $this->faker->randomFloat(2, 40000),
      'customer_first_name' => $this->faker->firstName,
      'customer_last_name' => $this->faker->lastName,
      'customer_phone' => $this->faker->phoneNumber,
      'customer_email' => $this->faker->email,
      'customer_address' => $this->faker->address,
      'customer_city' => $this->faker->city,
      'sales_channel_id' => SalesChannel::inRandomOrder()->first()->id,
      'customer_ig_handle' => $this->faker->word,
      'product_id' => $product->id,
      'product_type' => get_class($product),
      'scheduled_at' => now(),
    ]);


    $this->assertEquals(ProductStatus::scheduledDeliveryId(), $product->product_status_id);
    $this->assertEquals(true, $product->dispatch_request()->exists());

    return $product;
  }

  private function create_sold_product(): Product
  {
    $this->prepare_to_create_product();

    $appUser = factory(AppUser::class)->create();
    $product = factory(Product::class)->create(['product_status_id' => ProductStatus::soldId(), 'app_user_id' => $appUser->id]);
    factory(SalesRep::class)->create(['unit' => 'walk-in']);
    factory(SalesRep::class)->create(['unit' => 'social-media']);

    $product->product_sales_record()->create([
      'selling_price' => $this->faker->randomFloat(2, 40000),
      'online_rep_id' => SalesRep::socialMedia()->inRandomOrder()->first()->id,
      'sales_rep_id' => ($salesRep = SalesRep::walkIn()->inRandomOrder()->first())->id,
      'sales_rep_type' => get_class($salesRep),
      'sales_channel_id' => SalesChannel::first()->id,
      'is_swap_transaction' => false
    ]);

    $this->assertCount(1, ProductSaleRecord::all());
    $this->assertCount(1, AppUser::all());
    $this->assertEquals(true, $product->product_sales_record()->exists());
    $this->assertEquals($appUser->id, $product->app_user_id);

    return $product;
  }

  private function create_sale_confirmed_product(): Product
  {
    $this->prepare_to_create_product();

    $appUser = factory(AppUser::class)->create();
    $product = factory(Product::class)->create(['product_status_id' => ProductStatus::soldId(), 'app_user_id' => $appUser->id]);
    factory(SalesRep::class)->create(['unit' => 'walk-in']);
    factory(SalesRep::class)->create(['unit' => 'social-media']);
    $companyBankAccount = factory(CompanyBankAccount::class)->create();

    $product->product_sales_record()->create([
      'selling_price' => $this->faker->randomFloat(2, 40000),
      'online_rep_id' => SalesRep::socialMedia()->inRandomOrder()->first()->id,
      'sales_rep_id' => ($salesRep = SalesRep::walkIn()->inRandomOrder()->first())->id,
      'sales_rep_type' => get_class($salesRep),
      'sales_channel_id' => SalesChannel::first()->id,
      'is_swap_transaction' => false
    ]);

    $product->product_sales_record()->latest('id')->first()->bank_account_payments()->save($companyBankAccount, [
      'amount' => 600000
    ]);

    $product->generateReceipt(600000);

    $this->assertCount(1, ProductSaleRecord::all());
    $this->assertCount(1, CompanyBankAccount::all());
    $this->assertCount(1, SalesRecordBankAccount::all());
    $this->assertCount(1, AppUser::all());
    $this->assertCount(1, ProductReceipt::all());
    $this->assertEquals(true, $product->product_sales_record()->exists());
    $this->assertEquals($appUser->id, $product->app_user_id);

    return $product;
  }

  private function create_local_product(bool $unpaid): Product
  {
    $this->prepare_to_create_product();

    $product = factory(Product::class)->create(['is_local' => true, 'is_paid' => $unpaid]);

    $this->assertCount(1, Product::all());

    return $product;
  }

  private function prepare_to_create_product()
  {
    factory(OfficeBranch::class)->create();
    factory(ProductCategory::class)->create();
    factory(ProductBrand::class)->create();
    factory(ProductModel::class)->create();
    factory(ProductBatch::class)->create();
    factory(ProductColor::class)->create();
    factory(ProductGrade::class)->create();
    factory(ProductSupplier::class)->create();
    factory(ProductStatus::class)->create(['status' => 'in stock']);
    factory(ProductStatus::class)->create(['status' => 'out for delivery']);
    factory(ProductStatus::class)->create(['status' => 'sold']);
    factory(ProductStatus::class)->create(['status' => 'sale confirmed']);
    factory(ProductStatus::class)->create(['status' => 'sold by reseller']);
    factory(ProductStatus::class)->create(['status' => 'undergoing qa']);
    factory(ProductStatus::class)->create(['status' => 'with reseller']);
    factory(StorageSize::class)->create();
    factory(ProcessorSpeed::class)->create();
    factory(StorageType::class)->create();
    factory(StockKeeper::class, 2)->create();
    factory(SalesChannel::class)->create(['channel_name' => 'Instagram']);
    factory(SalesRep::class, 2)->create();
  }

}
