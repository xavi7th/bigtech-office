<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPricesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_prices', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('product_batch_id');
			$table->foreign('product_batch_id')->references('id')->on('product_batches')->onDelete('cascade');
			$table->unsignedBigInteger('product_brand_id');
			$table->foreign('product_brand_id')->references('id')->on('product_brands')->onDelete('cascade');
			$table->unsignedBigInteger('product_model_id');
			$table->foreign('product_model_id')->references('id')->on('product_models')->onDelete('cascade');
			$table->unsignedBigInteger('product_color_id');
			$table->foreign('product_color_id')->references('id')->on('product_colors')->onDelete('cascade');
			$table->unsignedBigInteger('storage_size_id');
			$table->foreign('storage_size_id')->references('id')->on('storage_sizes')->onDelete('cascade');
			$table->unsignedBigInteger('product_grade_id');
			$table->foreign('product_grade_id')->references('id')->on('product_grades')->onDelete('cascade');
			$table->unsignedBigInteger('product_supplier_id');
			$table->foreign('product_supplier_id')->references('id')->on('product_suppliers')->onDelete('cascade');
			$table->double('cost_price');
			$table->double('proposed_selling_price')->nullable();
			$table->unique(['product_batch_id', 'product_brand_id', 'product_model_id', 'product_color_id', 'storage_size_id', 'product_grade_id', 'product_supplier_id'], 'unique_product_price');

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
		Schema::dropIfExists('product_prices');
	}
}
