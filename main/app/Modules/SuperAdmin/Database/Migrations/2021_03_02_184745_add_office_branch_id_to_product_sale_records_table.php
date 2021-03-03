<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOfficeBranchIdToProductSaleRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_sale_records', function (Blueprint $table) {
          $table->foreignId('office_branch_id')->nullable()->after('is_swap_transaction')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_sale_records', function (Blueprint $table) {
          $table->dropForeign(['office_branch_id']);
          $table->dropColumn('office_branch_id');
        });
    }
}
