<?php

use Faker\Generator as Faker;
use App\Modules\SalesRep\Models\SalesRep;

$factory->define(SalesRep::class, function (Faker $faker) {
  return [
    'full_name' => $faker->name,
    'email' => $faker->email,
    'password' => 'sales-reps',
    'unit' => $faker->randomElement(['walk-in', 'social-media', 'call-center']),
    'is_active' =>true
  ];
});

$factory->state(SalesRep::class, 'socialMedia', [
  'unit' => 'social-media',
]);

$factory->state(SalesRep::class, 'walkIn', [
  'unit' => 'walk-in',
]);

$factory->state(SalesRep::class, 'callCenter', [
  'unit' => 'call-center',
]);

$factory->state(SalesRep::class, 'inactive', [
  'is_active' => false,
]);

$factory->state(SalesRep::class, 'verified', [
  'verified_at' => now()->subDays(3),
]);
