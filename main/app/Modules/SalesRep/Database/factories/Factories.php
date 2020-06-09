<?php

use Faker\Generator as Faker;
use App\Modules\SalesRep\Models\SalesRep;

$factory->define(SalesRep::class, function (Faker $faker) {
  if (!File::isDirectory(storage_path('app/public/admins/'))) {
    File::makeDirectory(storage_path('app/public/admins/'), 0755);
  }

  return [
    'full_name' => 'SalesRep',
    'email' => 'grant@itsefintech.com',
    'password' => 'pass',
    'phone' => '08034444444444',
    'user_passport' => '/storage/' . $faker->file(public_path('img/'), storage_path('app/public/admins/'), false),
    'gender' => 'male',
    'address' => '211 56789ygfhbffgh876545c 97564y',
    'verified_at' => now()->subDays(45),
  ];
});
