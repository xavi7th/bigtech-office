<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Modules\AppUser\Models\AppUser;

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


$factory->define(AppUser::class, function (Faker $faker) {
  return [
    'first_name' => $faker->firstName,
    'last_name' => $faker->lastName,
    'email' => $faker->unique()->safeEmail,
    'address' => $faker->address,
    'city' => $faker->city,
    'ig_handle' => '@' . $faker->unique()->userName,
    // 'app_user_category_id' => 1,
    // 'otp_verified_at' => now(),
    'password' => 'pass',
    'phone' => $faker->unique()->phoneNumber,
    // 'user_passport' => '/storage/id_cards/' . $faker->file(public_path('img/'), public_path('storage/app_users/'), false),
    'remember_token' => Str::random(10),
  ];
});
