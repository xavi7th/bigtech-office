<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserNameColumnToProductReceiptsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('product_receipts', function (Blueprint $table) {
      $table->string('user_name')->after('user_email');
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
      $table->dropColumn('user_name');
    });
  }
}
