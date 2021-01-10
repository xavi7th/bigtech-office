<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveDefaultFromProductTypeFieldInProductPricesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('product_receipts', function (Blueprint $table) {
      $table->string('product_type')->default(NULL)->change();
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
      $table->string('product_type')->default(str_replace("\\", "\\\\", Product::class))->change();
    });
  }
}
