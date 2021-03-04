<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOfficeBrandIdToSwapDealsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('swap_deals', function (Blueprint $table) {
      $table->foreignId('office_branch_id')->after('product_status_id')->nullable()->constrained();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('swap_deals', function (Blueprint $table) {
      $table->dropForeign(['office_branch_id']);
      $table->dropColumn('office_branch_id');
    });
  }
}
