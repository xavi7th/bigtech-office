<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Modules\Admin\Models\Admin;

$factory->define(Admin::class, function (Faker $faker) {
  return [
    'full_name' => $faker->name,
    'email' => $faker->companyEmail,
    'password' => 'admins',
    'is_active' =>true,
  ];
});
