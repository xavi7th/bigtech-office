<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductHistoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_histories', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('product_id');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->unsignedBigInteger('product_status_id');
			$table->foreign('product_status_id')->references('id')->on('product_statuses')->onDelete('cascade');
			$table->bigInteger('user_id');
			$table->string('user_type');


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
		Schema::dropIfExists('product_histories');
	}
}
