<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\SuperAdmin\Models\ProcessorSpeed;
use Faker\Generator as Faker;

$factory->define(ProcessorSpeed::class, function (Faker $faker) {
  return [
    'speed' => $faker->unique()->macProcessor
  ];
});
