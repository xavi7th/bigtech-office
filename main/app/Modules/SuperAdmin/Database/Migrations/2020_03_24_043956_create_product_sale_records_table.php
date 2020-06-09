<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSaleRecordsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_sale_records', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('product_id')->unique();
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->double('selling_price');
			$table->unsignedBigInteger('sales_channel_id')->nullable();
			$table->foreign('sales_channel_id')->references('id')->on('sales_channels')->onDelete('cascade');
			$table->unsignedBigInteger('online_rep_id')->nullable();
			$table->foreign('online_rep_id')->references('id')->on('sales_reps')->onDelete('cascade');
			$table->unsignedBigInteger('sales_rep_id')->nullable();
			$table->foreign('sales_rep_id')->references('id')->on('sales_reps')->onDelete('cascade');
			$table->unsignedBigInteger('sale_confirmed_by')->nullable();
			$table->string('sale_confirmer_type')->nullable();
			$table->boolean('is_swap_deal')->default(false);


			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('product_sale_records');
	}
}
