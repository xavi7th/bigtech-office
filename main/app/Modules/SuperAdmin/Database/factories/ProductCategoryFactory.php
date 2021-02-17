<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\SuperAdmin\Models\ProductCategory;
use Faker\Generator as Faker;

$factory->define(ProductCategory::class, function (Faker $faker) {
  return [
    'name' => $faker->unique()->word,
  ];
});
