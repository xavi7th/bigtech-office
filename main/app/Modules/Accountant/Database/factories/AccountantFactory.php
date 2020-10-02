<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Modules\Accountant\Models\Accountant;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
| factory('App\User', 5)->create();
|
*/


$factory->define(Accountant::class, function (Faker $faker) {
  return [
    'full_name' => $faker->name('female'),
    'email' => $faker->unique()->safeEmail,
    'password' => 'password',
    'remember_token' => Str::random(10),
  ];
});
