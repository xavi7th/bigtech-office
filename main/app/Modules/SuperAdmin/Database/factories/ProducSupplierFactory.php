<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\SuperAdmin\Models\ProductSupplier;
use Faker\Generator as Faker;

$factory->define(ProductSupplier::class, function (Faker $faker) {
  return [
    'name' => $faker->unique()->company,
    'is_local' => $faker->randomElement([true, false])
  ];
});
