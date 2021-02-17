<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\SuperAdmin\Models\ProductBatch;
use Faker\Generator as Faker;

$factory->define(ProductBatch::class, function (Faker $faker) {
  return [
    'order_date' => $faker->dateTimeThisDecade,
    'batch_number' => Str::random(7),
  ];
});
