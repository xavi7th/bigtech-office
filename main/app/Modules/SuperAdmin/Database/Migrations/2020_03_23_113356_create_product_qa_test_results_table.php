<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductQATestResultsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_qa_test_results', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('product_id');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->unsignedBigInteger('qa_test_id');
			$table->foreign('qa_test_id')->references('id')->on('qa_tests')->onDelete('cascade');
			$table->boolean('is_qa_certified')->default(false);
			$table->unique(['product_id', 'qa_test_id']);

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
		Schema::dropIfExists('product_qa_test_results');
	}
}
