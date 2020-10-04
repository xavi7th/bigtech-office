<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Modules\QualityControl\Models\QualityControl;

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


$factory->define(QualityControl::class, function (Faker $faker) {
  dump('quality-control' . strtolower(str_replace("-", "", config('app.name'))));
  return [
    'full_name' => 'SysDef Quality Control',
    'email' => 'qualitycontrol@' . strtolower(str_replace(" ", "", config('app.name'))) . '.com',
    'password' => 'quality-control' . strtolower(str_replace("-", "", config('app.name'))),
  ];
});
