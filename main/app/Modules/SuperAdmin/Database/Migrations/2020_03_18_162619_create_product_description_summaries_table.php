<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDescriptionSummariesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_description_summaries', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('product_model_id')->unique();
			$table->foreign('product_model_id')->references('id')->on('product_models')->onDelete('cascade');
			$table->longText('description_summary');

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
		Schema::dropIfExists('product_description_summaries');
	}
}
