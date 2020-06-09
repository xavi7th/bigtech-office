<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductModelImagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_model_images', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('product_model_id');
			$table->foreign('product_model_id')->references('id')->on('product_models')->onDelete('cascade');
			$table->string('img_url');

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
		Schema::dropIfExists('product_model_images');
	}
}
