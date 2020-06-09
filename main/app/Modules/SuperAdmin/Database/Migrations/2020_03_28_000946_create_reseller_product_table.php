<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResellerProductTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reseller_product', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('reseller_id');
			$table->foreign('reseller_id')->references('id')->on('resellers')->onDelete('cascade');
			$table->unsignedBigInteger('product_id');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->enum('status', ['sold', 'returned', 'tenured'])->default('tenured');
			$table->unique(['product_id', 'reseller_id'], 'unique_reseller_product');

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
		Schema::dropIfExists('reseller_product');
	}
}
