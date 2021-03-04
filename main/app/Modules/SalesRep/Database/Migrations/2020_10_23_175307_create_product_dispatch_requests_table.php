<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDispatchRequestsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('product_dispatch_requests', function (Blueprint $table) {
      $table->id();
      $table->foreignId('sales_channel_id')->nullable()->constrained();
      $table->foreignId('online_rep_id')->constrained('sales_reps');
      $table->longText('product_description');
      $table->unsignedBigInteger('product_id')->nullable();
      $table->string('product_type')->nullable();
      $table->double('proposed_selling_price');
      $table->string('customer_first_name');
      $table->string('customer_last_name')->nullable();
      $table->string('customer_phone');
      $table->string('customer_email')->nullable();
      $table->string('customer_address');
      $table->string('customer_city');
      $table->string('customer_ig_handle')->nullable();
      $table->timestamp('scheduled_at')->nullable();
      $table->timestamp('sold_at')->nullable();

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
    Schema::dropIfExists('product_dispatch_requests');
  }
}
