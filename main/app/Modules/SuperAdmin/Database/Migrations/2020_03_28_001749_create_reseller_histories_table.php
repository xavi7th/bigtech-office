<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResellerHistoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reseller_histories', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('reseller_id');
			$table->foreign('reseller_id')->references('id')->on('resellers')->onDelete('cascade');
			$table->unsignedBigInteger('product_id');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->enum('product_status', ['returned', 'sold', 'tenured'])->default('tenured');
			$table->bigInteger('handled_by');
			$table->string('handler_type');
			$table->unique(['reseller_id', 'product_id', 'product_status'], 'reseller_histories_unique');

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
		Schema::dropIfExists('reseller_histories');
	}
}
