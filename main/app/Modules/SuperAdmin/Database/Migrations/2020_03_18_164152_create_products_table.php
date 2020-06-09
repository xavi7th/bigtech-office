<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('app_user_id')->nullable();
			$table->foreign('app_user_id')->references('id')->on('app_users')->onDelete('cascade');
			$table->unsignedBigInteger('product_category_id');
			$table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
			$table->unsignedBigInteger('product_model_id');
			$table->foreign('product_model_id')->references('id')->on('product_models')->onDelete('cascade');
			$table->unsignedBigInteger('product_brand_id');
			$table->foreign('product_brand_id')->references('id')->on('product_brands')->onDelete('cascade');
			$table->unsignedBigInteger('product_batch_id');
			$table->foreign('product_batch_id')->references('id')->on('product_batches')->onDelete('cascade');
			$table->unsignedBigInteger('product_color_id');
			$table->foreign('product_color_id')->references('id')->on('product_colors')->onDelete('cascade');
			$table->unsignedBigInteger('product_grade_id');
			$table->foreign('product_grade_id')->references('id')->on('product_grades')->onDelete('cascade');
			$table->unsignedBigInteger('product_supplier_id');
			$table->foreign('product_supplier_id')->references('id')->on('product_suppliers')->onDelete('cascade');
			$table->unsignedBigInteger('storage_size_id');
			$table->foreign('storage_size_id')->references('id')->on('storage_sizes');
			$table->unsignedBigInteger('ram_size_id')->nullable();
			$table->foreign('ram_size_id')->references('id')->on('storage_sizes');
			$table->unsignedBigInteger('storage_type_id')->nullable();
			$table->foreign('storage_type_id')->references('id')->on('storage_types')->onDelete('cascade');
			$table->unsignedBigInteger('processor_speed_id')->nullable();
			$table->foreign('processor_speed_id')->references('id')->on('processor_speeds')->onDelete('cascade');
			$table->string('imei')->unique()->nullable();
			$table->string('serial_no')->unique()->nullable();
			$table->string('model_no')->unique()->nullable();
			$table->unsignedBigInteger('product_status_id')->default(1);
			$table->foreign('product_status_id')->references('id')->on('product_statuses')->onDelete('cascade');
			$table->uuid('product_uuid');
			$table->unsignedBigInteger('stocked_by');
			$table->string('stocker_type');
			$table->unsignedBigInteger('office_branch_id')->default(1);
			$table->foreign('office_branch_id')->references('id')->on('office_branches')->onDelete('cascade');

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
		Schema::dropIfExists('products');
	}
}
