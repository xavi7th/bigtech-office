<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Modules\SuperAdmin\Models\ProductBatch;

$factory->define(ProductBatch::class, function (Faker $faker) {
  return [
    'order_date' => $faker->dateTimeThisDecade,
    'batch_number' => Str::random(7),
  ];
});
