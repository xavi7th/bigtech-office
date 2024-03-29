<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Accountant\Models\Accountant;
use App\Modules\SuperAdmin\Models\OtherExpense;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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


$factory->define(OtherExpense::class, function (Faker $faker) {
  return [
    'amount' => $faker->randomNumber,
    'purpose' => 'Change phone casing',
    'recorder_id' => 2,
    'recorder_type' => Accountant::class,
  ];
});
