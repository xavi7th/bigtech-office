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
      $table->id();
      $table->foreignId('product_brand_id')->constrained();
      $table->foreignId('product_category_id')->constrained();
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
