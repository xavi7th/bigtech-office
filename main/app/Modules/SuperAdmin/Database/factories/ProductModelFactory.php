<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\SuperAdmin\Models\ProductBrand;
use App\Modules\SuperAdmin\Models\ProductCategory;
use Faker\Generator as Faker;
use App\Modules\SuperAdmin\Models\ProductModel;

$factory->define(ProductModel::class, function (Faker $faker) {
  return [
    'name' => $faker->unique()->word,
    'product_brand_id' => ProductBrand::inRandomOrder()->first()->id,
    'product_category_id' => ProductCategory::inRandomOrder()->first()->id,
    'img_url' => $faker->imageUrl()
  ];
});
