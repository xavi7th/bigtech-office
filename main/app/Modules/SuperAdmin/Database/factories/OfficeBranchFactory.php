<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\SuperAdmin\Models\OfficeBranch;
use Faker\Generator as Faker;

$factory->define(OfficeBranch::class, function (Faker $faker) {
  return [
    'city' => $faker->city,
    'country' => $faker->country,
  ];
});
