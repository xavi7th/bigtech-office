<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\Accountant\Models\Accountant;
use App\Modules\SuperAdmin\Models\StorageSize;
use App\Modules\SuperAdmin\Models\StorageType;
use App\Modules\SuperAdmin\Models\OfficeBranch;
use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Models\ProductBrand;
use App\Modules\SuperAdmin\Models\ProductColor;
use App\Modules\SuperAdmin\Models\ProductGrade;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\ProcessorSpeed;
use App\Modules\SuperAdmin\Models\ProductCategory;
use App\Modules\SuperAdmin\Models\ProductExpense;
use App\Modules\SuperAdmin\Models\ProductSupplier;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;

$factory->define(Product::class, function (Faker $faker) {
  return [
    'product_category_id' => ProductCategory::inRandomOrder()->first()->id,
    'product_model_id' => ProductModel::inRandomOrder()->first()->id,
    'product_brand_id' => ProductBrand::inRandomOrder()->first()->id,
    'product_batch_id' => ProductBatch::inRandomOrder()->first()->id,
    'product_color_id' => ProductColor::inRandomOrder()->first()->id,
    'product_grade_id' => ProductGrade::inRandomOrder()->first()->id,
    'product_supplier_id' => ProductSupplier::inRandomOrder()->first()->id,
    'storage_size_id' => StorageSize::inRandomOrder()->first()->id,
    'imei' => $imei = $faker->randomElement([true, false]) ? Str::random(16) : null,
    'serial_no' => $serial_no = $imei == null ? ($faker->randomElement([true, false]) ? Str::random(16) : null) : null,
    'model_no' => $serial_no == null && $imei == null ? Str::random(16) : null,
    'product_uuid' => Str::uuid(),
    'processor_speed_id' => ProcessorSpeed::inRandomOrder()->first()->id,
    'ram_size_id' => StorageSize::inRandomOrder()->first()->id,
    'storage_type_id' => StorageType::inRandomOrder()->first()->id,
    'stocked_by' => Accountant::inRandomOrder()->first()->id,
    'stocker_type' => Accountant::class,
    'office_branch_id' => OfficeBranch::inRandomOrder()->first()->id,
    'product_status_id' => ProductStatus::justArrivedId(),
    'is_local' => false,
    'is_paid' => false,
  ];
});

$factory->state(Product::class, 'local', fn () => [
  'is_local' => true,
  'product_batch_id' => ProductBatch::local_supplied_id(),
]);


$factory->afterCreating(Product::class, function ($product, $faker) {
  $product->is_local
    ?  $product->localProductPrice()->create([
      'cost_price' => $faker->randomFloat(2, 200000, 250000),
      'proposed_selling_price' => $faker->randomFloat(2, 260000),
    ])
    : $product->product_price()->create([
      'cost_price' => $faker->randomFloat(2, 200000, 250000),
      'proposed_selling_price' => $faker->randomFloat(2, 260000),
      'product_batch_id' => $product->product_batch_id,
      'product_color_id' => $product->product_color_id,
      'product_grade_id' => $product->product_grade_id,
      'product_supplier_id' => $product->product_supplier_id,
      'storage_size_id' => $product->storage_size_id,
      'product_brand_id' => $product->product_brand_id,
      'product_model_id' => $product->product_model_id,
    ]);
});

$factory->state(Product::class, 'paid', [
  'is_paid' => true,
]);

$factory->state(Product::class, 'in_stock', fn () => [
  'product_status_id' => ProductStatus::inStockId(),
]);

$factory->state(Product::class, 'sold', fn () => [
  'product_status_id' => ProductStatus::soldId(),
]);

$factory->afterCreatingState(Product::class, 'sold', function ($product, Faker $faker) {
  $product->product_sales_record()->save(factory(ProductSaleRecord::class)->make());
});

$factory->state(Product::class, 'confirmed', fn () => [
  'product_status_id' => ProductStatus::saleConfirmedId(),
]);

$factory->afterCreatingState(Product::class, 'confirmed', function ($product, $faker) {
  $product->product_sales_record()->save(factory(ProductSaleRecord::class)->state('confirmed')->make());
});

$factory->state(Product::class, 'confirmedSwapTransactions', fn () => [
  'product_status_id' => ProductStatus::saleConfirmedId(),
]);

$factory->afterCreatingState(Product::class, 'confirmedSwapTransactions', function ($product, $faker) {
  $product->product_sales_record()->save(factory(ProductSaleRecord::class)->states('confirmed', 'swap_transaction')->create());
});

$factory->state(Product::class, 'inStockWithExpenses', fn () => [
  'product_status_id' => ProductStatus::inStockId(),
]);

$factory->afterCreatingState(Product::class, 'inStockWithExpenses', function ($product, $faker) {
  $product->product_expenses()->create(factory(ProductExpense::class)->make()->toArray());
});
