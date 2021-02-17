<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\SuperAdmin\Models\ProductBrand;
use Faker\Generator as Faker;

$factory->define(ProductBrand::class, function (Faker $faker) {
  return [
    'name' => $faker->unique()->word,
    'logo_url' => $faker->imageUrl()
  ];
});
