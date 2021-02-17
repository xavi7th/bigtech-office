<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\SuperAdmin\Models\StorageType;
use Faker\Generator as Faker;

$factory->define(StorageType::class, function (Faker $faker) {
  return [
    'type' => $faker->randomElement(['SSD', 'HDD', 'flash', 'NVMe'])
  ];
});
