<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUniqueConstraintsFromResellerHistoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('reseller_histories', function (Blueprint $table) {
      $table->index('reseller_id', 'reseller_id_foreign');
      $table->dropUnique('reseller_histories_unique');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('reseller_histories', function (Blueprint $table) {
      $table->unique(['reseller_id', 'product_id', 'product_status'], 'reseller_histories_unique');
      $table->dropIndex('reseller_id_foreign');
    });
  }
}
