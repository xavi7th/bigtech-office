<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Modules\QualityControl\Models\QualityControl;

$factory->define(QualityControl::class, function (Faker $faker) {
  return [
    'full_name' => $faker->name,
    'email' => $faker->email,
    'password' => 'quality-controls',
  ];
});
