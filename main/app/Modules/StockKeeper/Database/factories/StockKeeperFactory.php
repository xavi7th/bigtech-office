<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Modules\StockKeeper\Models\StockKeeper;

$factory->define(StockKeeper::class, function (Faker $faker) {
  return [
    'full_name' => $faker->name,
    'email' => $faker->email,
    'password' => 'stock-keepers',
  ];
});
