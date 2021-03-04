<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\ProductExpense;
use App\Modules\SuperAdmin\Models\SwapDeal;

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


$factory->define(ProductExpense::class, function (Faker $faker) {
  return [
    'amount' => $faker->randomNumber,
    'reason' => $faker->randomElement(['Change phone casing', 'Fix screen burn', 'change battery', 'replace camera', 'fix speaker']),
    'product_id' => factory(Product::class),
    'product_type' => fn (array $productExpense) => get_class(Product::find($productExpense['product_id'])),
  ];
});


$factory->state(ProductExpense::class, 'swapDeal', fn () => [
  'product_id' => factory(SwapDeal::class),
  'product_type' => fn (array $productExpense) => get_class(SwapDeal::find($productExpense['product_id'])),
]);
