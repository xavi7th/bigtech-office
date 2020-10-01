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
      $table->foreignId('reseller_id')->constrained('resellers')->onDelete('cascade');;
			$table->unsignedBigInteger('product_id');
      $table->string('product_type');
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
