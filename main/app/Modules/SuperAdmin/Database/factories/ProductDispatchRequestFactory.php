<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\SalesRep\Models\ProductDispatchRequest;
use App\Modules\SuperAdmin\Models\SalesChannel;
use Faker\Generator as Faker;

$factory->define(ProductDispatchRequest::class, function (Faker $faker) {
  return [
    'product_description' => $faker->sentence, //'required|string|max:500',
    'proposed_selling_price' => $faker->randomFloat(2, 50000), //'required|numeric',
    'customer_first_name' => $faker->firstName, //'required|string|max:30',
    'customer_last_name' => $faker->lastName, //'nullable|string|max:30',
    'customer_phone' => $faker->phoneNumber, //'required|regex:/^[\+]?[0-9\Q()\E\s-]+$/i',
    'customer_email' => $faker->email, //'required|email',
    'customer_address' => $faker->address, //'required|string|max:100',
    'customer_city' => $faker->city, //'required|string|max:16',
    'sales_channel_id' => factory(SalesChannel::class), //'required|exists:sales_channels,id',
    'customer_ig_handle' => '@' . $faker->word, //'nullable|string|max:50',
  ];
});
