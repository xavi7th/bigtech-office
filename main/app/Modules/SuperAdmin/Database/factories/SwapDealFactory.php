<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\SuperAdmin\Models\SwapDeal;
use Faker\Generator as Faker;

$factory->define(SwapDeal::class, function (Faker $faker) {
  return [
    'description' => $faker->sentence,
    'owner_details' => $faker->name,
    'id_url' => $faker->imageUrl(),
    'receipt_url' => $faker->imageUrl(),
    'imei' => $faker->unique()->bankAccountNumber,
    'swap_value' => $faker->randomNumber(5),
    'selling_price' => $faker->randomNumber(6),
  ];
});
