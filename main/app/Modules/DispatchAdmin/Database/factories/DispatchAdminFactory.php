<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Modules\DispatchAdmin\Models\DispatchAdmin;

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


$factory->define(DispatchAdmin::class, function (Faker $faker) {
  dump('dispatch-admin' . strtolower(str_replace(" ", "-", config('app.name'))));
  return [
    'full_name' => 'SysDef Dispatch',
    'email' => 'dispatch_admin@' . strtolower(str_replace(" ", "", config('app.name'))) . '.com',
    'password' => 'dispatch-admin' . strtolower(str_replace(" ", "-", config('app.name'))),
  ];
});
