<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Auditor\Models\Auditor;
use Faker\Generator as Faker;

$factory->define(Auditor::class, function (Faker $faker) {
    return [
      'full_name' => $faker->name,
      'email' => $faker->companyEmail,
      'password' => 'auditors',
      'is_active' =>true,
    ];
});
