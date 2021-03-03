<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Modules\Accountant\Models\Accountant;

$factory->define(Accountant::class, function (Faker $faker) {
  return [
    'full_name' => $faker->randomElement(['Ola', 'John', 'Sammy', 'Eddie']),
    'email' => $faker->email,
    'password' => 'accountants',
    'is_active' =>true,
  ];
});
