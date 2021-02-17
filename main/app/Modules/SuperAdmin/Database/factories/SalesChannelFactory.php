<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\SuperAdmin\Models\SalesChannel;
use Faker\Generator as Faker;

$factory->define(SalesChannel::class, function (Faker $faker) {
  return [
    'channel_name' => $faker->randomElement(['Instagram', 'WhatsApp', 'Walk In'])
  ];
});
