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
      $table->id();
      $table->foreignId('app_user_id')->nullable()->constrained('app_users');
      $table->foreignId('product_category_id')->constrained();
      $table->foreignId('product_model_id')->constrained();
      $table->foreignId('product_brand_id')->constrained();
      $table->foreignId('product_batch_id')->constrained();
      $table->foreignId('product_color_id')->constrained();
      $table->foreignId('product_grade_id')->constrained();
      $table->foreignId('product_supplier_id')->constrained();
      $table->foreignId('storage_size_id')->constrained();
      $table->foreignId('ram_size_id')->nullable()->constrained('storage_sizes');
      $table->foreignId('storage_type_id')->nullable()->constrained();
      $table->foreignId('processor_speed_id')->nullable()->constrained();
			$table->string('imei')->unique()->nullable();
			$table->string('serial_no')->unique()->nullable();
			$table->string('model_no')->unique()->nullable();
      $table->foreignId('product_status_id')->default(1)->constrained('product_statuses');
      $table->timestamp('sold_at')->nullable();
			$table->uuid('product_uuid');
			$table->unsignedBigInteger('stocked_by');
			$table->string('stocker_type');
      $table->foreignId('office_branch_id')->default(1)->constrained();

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
