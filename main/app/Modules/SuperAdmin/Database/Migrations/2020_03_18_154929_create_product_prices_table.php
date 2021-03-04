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
      $table->id();
      $table->foreignId('product_batch_id')->constrained();
      $table->foreignId('product_brand_id')->constrained();
      $table->foreignId('product_model_id')->constrained();
      $table->foreignId('product_color_id')->constrained();
      $table->foreignId('storage_size_id')->constrained();
      $table->foreignId('product_grade_id')->constrained();
      $table->foreignId('product_supplier_id')->constrained();
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
