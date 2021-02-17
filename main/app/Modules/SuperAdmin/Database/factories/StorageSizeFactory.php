<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\SuperAdmin\Models\StorageSize;
use Faker\Generator as Faker;

$factory->define(StorageSize::class, function (Faker $faker) {
  return [
    'size' => $faker->numberBetween(1000, 20000000)
  ];
});
