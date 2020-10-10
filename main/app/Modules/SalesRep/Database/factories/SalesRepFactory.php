<?php

use Faker\Generator as Faker;
use App\Modules\SalesRep\Models\SalesRep;

$factory->define(SalesRep::class, function (Faker $faker) {
  return [
    'full_name' => 'SysDef Sales Rep',
    'email' => 'salesrep@' . strtolower(str_replace(" ", "", config('app.name'))) . '.com',
    'password' => 'sales-reps',
  ];
});
