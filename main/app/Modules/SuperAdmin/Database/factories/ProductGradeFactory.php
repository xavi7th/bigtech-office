<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\SuperAdmin\Models\ProductGrade;
use Faker\Generator as Faker;

$factory->define(ProductGrade::class, function (Faker $faker) {
  return [
    'grade' => $faker->randomElement(['A', 'A+', 'B', 'KLFB', 'Brand New', 'Open Box', 'C', 'C+'])
  ];
});
