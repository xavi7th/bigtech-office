<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductModelsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_models', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('product_brand_id');
			$table->foreign('product_brand_id')->references('id')->on('product_brands')->onDelete('cascade');
			$table->unsignedBigInteger('product_category_id');
			$table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
			$table->string('name')->unique();
			$table->string('img_url')->nullable();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('product_models');
	}
}
