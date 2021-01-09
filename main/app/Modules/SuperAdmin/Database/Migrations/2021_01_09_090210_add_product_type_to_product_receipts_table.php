<?php

use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductTypeToProductReceiptsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('product_receipts', function (Blueprint $table) {
      $table->dropForeign(['product_id']);
      $table->index(['product_id', 'product_type']);
      $table->string('product_type')->after('product_id')->default(str_replace("\\", "\\\\", Product::class));
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('product_receipts', function (Blueprint $table) {
      $table->foreignId('product_id')->constrained();
      $table->dropIndex(['product_id', 'product_type']);
      $table->dropColumn('product_type');
    });
  }
}
