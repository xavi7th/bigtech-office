<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Modules\SuperAdmin\Models\Reseller;

$factory->define(Reseller::class, function (Faker $faker) {
  return [
    'business_name' => $faker->company,
    'ceo_name' => $faker->name,
    'phone' => $faker->phoneNumber,
    'address' => $faker->address,
    'email' => $faker->email,
    'img_url' => $faker->imageUrl()
  ];
});
