<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\SwapDeal;
use App\Modules\Accountant\Models\Accountant;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Models\CompanyBankAccount;

$factory->define(ProductSaleRecord::class, function (Faker $faker) {
  return [
    'product_id' => factory(Product::class),
    'product_type' => fn (array $productSaleRecord) => get_class(Product::find($productSaleRecord['product_id'])),
    'selling_price' => $faker->randomFloat(2, 20000),
    'online_rep_bonus' => $faker->randomNumber(3),
    'walk_in_rep_bonus' => $faker->randomNumber(3),
    'sales_channel_id' => 1,
    'online_rep_id' => factory(SalesRep::class)->state('socialMedia'),
    'sales_rep_id' => factory(SalesRep::class)->state('walkIn'),
    'sales_rep_type' => fn (array $productSaleRecord) => get_class(SalesRep::find($productSaleRecord['sales_rep_id'])),
    'sale_confirmed_by' => null,
    'sale_confirmer_type' => null,
    'is_swap_transaction' => false,
  ];
});

$factory->state(
  ProductSaleRecord::class,
  'sold',
  function ($faker) {
    return [
      'product_id' => factory(Product::class)->state('sold'),
    ];
  }
);

$factory->state(
  ProductSaleRecord::class,
  'confirmed',
  function ($faker) {
    return [
      // 'product_id' => factory(Product::class)->state('confirmed'), #commented out because we are seeding from the product side. This will prevent a cyclical redundancy error
      'sale_confirmed_by' => factory(Accountant::class),
      'sale_confirmer_type' => fn (array $productSaleRecord) => get_class(Accountant::find($productSaleRecord['sale_confirmed_by'])),
    ];
  }
);

$factory->afterCreatingState(ProductSaleRecord::class, 'confirmed', function ($productSaleRecord, Faker $faker) {
  $productSaleRecord->bank_account_payments()->save(factory(CompanyBankAccount::class)->create(), ['amount' => $faker->randomFloat(2, 50000)]);
});

$factory->state(ProductSaleRecord::class, 'swap_transaction', [
  'is_swap_transaction' => true,
]);

$factory->afterCreatingState(ProductSaleRecord::class, 'swap_transaction', function ($productSaleRecord, Faker $faker) {
  $productSaleRecord->product->swapped_deal_device()->save(factory(SwapDeal::class)->make());
});
