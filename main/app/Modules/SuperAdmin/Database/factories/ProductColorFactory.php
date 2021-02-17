<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\SuperAdmin\Models\ProductColor;
use Faker\Generator as Faker;

$factory->define(ProductColor::class, function (Faker $faker) {
  return [
    'name' => $faker->unique()->colorName
  ];
});
