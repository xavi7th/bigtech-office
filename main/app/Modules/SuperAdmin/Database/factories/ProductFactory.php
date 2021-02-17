<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\StorageSize;
use App\Modules\StockKeeper\Models\StockKeeper;
use App\Modules\SuperAdmin\Models\OfficeBranch;
use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Models\ProductBrand;
use App\Modules\SuperAdmin\Models\ProductColor;
use App\Modules\SuperAdmin\Models\ProductGrade;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\ProcessorSpeed;
use App\Modules\SuperAdmin\Models\ProductCategory;
use App\Modules\SuperAdmin\Models\ProductSupplier;
use App\Modules\SuperAdmin\Models\StorageType;

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
    'stocked_by' => StockKeeper::inRandomOrder()->first()->id,
    'stocker_type' => StocKeeper::class,
    'office_branch_id' => OfficeBranch::inRandomOrder()->first()->id,
    'product_status_id' => ProductStatus::inRandomOrder()->first()->id,
    'is_local' => $faker->randomElement([true, false]),
    'is_paid' => $faker->randomElement([true, false])
  ];
});
