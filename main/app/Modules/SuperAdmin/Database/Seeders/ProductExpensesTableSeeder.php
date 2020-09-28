<?php

namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\SuperAdmin\Models\Product;

class ProductExpensesTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('product_expenses')->delete();

    \DB::table('product_expenses')->insert(array(
      0 =>
      array(
        'product_id' => 8,
        'product_type' => Product::class,
        'amount' => 5000.0,
        'reason' => 'Explicabo cupiditate illum inventore et.',
      ),
      1 =>
      array(
        'product_id' => 28,
        'product_type' => Product::class,
        'amount' => 5000.0,
        'reason' => 'Camera and battery replacement.',
      ),
      2 =>
      array(
        'product_id' => 2,
        'product_type' => Product::class,
        'amount' => 5000.0,
        'reason' => 'Back glass',
      ),
      3 =>
      array(
        'product_id' => 7,
        'product_type' => Product::class,
        'amount' => 336.0,
        'reason' => 'Eum velit sit explicabo vero harum ut placeat et.',
      ),
      4 =>
      array(
        'product_id' => 21,
        'product_type' => Product::class,
        'amount' => 308.0,
        'reason' => 'Charging port',
      ),
      5 =>
      array(
        'product_id' => 5,
        'product_type' => Product::class,
        'amount' => 847.0,
        'reason' => 'A voluptatem id eius.',
      ),
      6 =>
      array(
        'product_id' => 3,
        'product_type' => Product::class,
        'amount' => 933.0,
        'reason' => 'Charging port',
      ),
      7 =>
      array(
        'product_id' => 22,
        'product_type' => Product::class,
        'amount' => 739.0,
        'reason' => 'Back camera not snapping',
      ),
      8 =>
      array(
        'product_id' => 28,
        'product_type' => Product::class,
        'amount' => 451.0,
        'reason' => 'Back camera not snapping',
      ),
      9 =>
      array(
        'product_id' => 21,
        'product_type' => Product::class,
        'amount' => 440.0,
        'reason' => 'Back camera not snapping',
      ),
      10 =>
      array(
        'product_id' => 17,
        'product_type' => Product::class,
        'amount' => 608.0,
        'reason' => 'Back camera not snapping',
      ),
      11 =>
      array(
        'product_id' => 5,
        'product_type' => Product::class,
        'amount' => 993.0,
        'reason' => 'Back camera not snapping',
      ),
      12 =>
      array(
        'product_id' => 7,
        'product_type' => Product::class,
        'amount' => 2356264.0,
        'reason' => 'Back camera not snapping',
      ),
      13 =>
      array(
        'product_id' => 6,
        'product_type' => Product::class,
        'amount' => 1508080.0,
        'reason' => 'Back camera not snapping',
      ),
      14 =>
      array(
        'product_id' => 12,
        'product_type' => Product::class,
        'amount' => 2496218.0,
        'reason' => 'Back camera not snapping',
      ),
      15 =>
      array(
        'product_id' => 19,
        'product_type' => Product::class,
        'amount' => 2280724.0,
        'reason' => 'Aut porro in sit sapiente explicabo pariatur ipsa.',
      ),
      16 =>
      array(
        'product_id' => 13,
        'product_type' => Product::class,
        'amount' => 5900736.0,
        'reason' => 'Qui porro dicta tempora inventore sequi ipsa optio quae vel.',
      ),
      17 =>
      array(
        'product_id' => 28,
        'product_type' => Product::class,
        'amount' => 57563.0,
        'reason' => 'Asperiores sed non eligendi accusamus accusamus perferendis.',
      ),
      18 =>
      array(
        'product_id' => 30,
        'product_type' => Product::class,
        'amount' => 15695.0,
        'reason' => 'Nemo dolorem sint laboriosam ipsum esse est.',
      ),
      19 =>
      array(
        'product_id' => 7,
        'product_type' => Product::class,
        'amount' => 56523.0,
        'reason' => 'Dolorem vitae molestiae.',
      ),
      20 =>
      array(
        'product_id' => 15,
        'product_type' => Product::class,
        'amount' => 25068.0,
        'reason' => 'Neque fugiat repellendus ab eum non nesciunt eos.',
      ),
      21 =>
      array(
        'product_id' => 1,
        'product_type' => Product::class,
        'amount' => 3063.0,
        'reason' => 'Hic harum vitae.',
      ),
      22 =>
      array(
        'product_id' => 22,
        'product_type' => Product::class,
        'amount' => 6937.0,
        'reason' => 'Ex sit doloremque aliquam suscipit alias et modi ipsam.',
      ),
      23 =>
      array(
        'product_id' => 14,
        'product_type' => Product::class,
        'amount' => 60931.0,
        'reason' => 'Facilis beatae quaerat corrupti aut est accusantium deleniti voluptatem.',
      ),
      24 =>
      array(
        'product_id' => 19,
        'product_type' => Product::class,
        'amount' => 17198.0,
        'reason' => 'Et accusantium quod necessitatibus laboriosam sunt.',
      ),
      25 =>
      array(
        'product_id' => 28,
        'product_type' => Product::class,
        'amount' => 31154.0,
        'reason' => 'Voluptatem et porro explicabo nam.',
      ),
    ));
  }
}
