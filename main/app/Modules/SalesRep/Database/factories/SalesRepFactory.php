<?php

use Faker\Generator as Faker;
use App\Modules\SalesRep\Models\SalesRep;

$factory->define(SalesRep::class, function (Faker $faker) {
  return [
    'full_name' => $faker->name,
    'email' => $faker->email,
    'password' => 'sales-reps',
    'unit' => $faker->randomElement(['walk-in', 'social-media', 'call-center']),
    'is_active' =>true
  ];
});
