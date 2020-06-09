<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelQATestTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_model_qa_test', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('product_model_id');
			$table->foreign('product_model_id')->references('id')->on('product_models')->onDelete('cascade');
			$table->unsignedBigInteger('qa_test_id');
			$table->foreign('qa_test_id')->references('id')->on('qa_tests')->onDelete('cascade');

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
		Schema::dropIfExists('product_model_qa_test');
	}
}
