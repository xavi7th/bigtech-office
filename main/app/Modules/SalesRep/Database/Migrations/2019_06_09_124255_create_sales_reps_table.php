<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesRepsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('sales_reps', function (Blueprint $table) {
      $table->id();
      $table->string('full_name');
      $table->string('email')->unique();
      $table->string('password');
      $table->string('phone')->unique()->nullable();
      $table->string('avatar')->nullable();
      $table->string('address')->nullable();
      $table->string('unit')->default('sys-default'); // walk-in,social-media,call-center
      $table->string('gender')->enum(['male', 'female'])->nullable();
      $table->foreignId('office_branch_id')->default(1)->constrained()->onDelete('cascade');
      $table->boolean('is_active')->nullable();


      $table->rememberToken();
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
    Schema::dropIfExists('sales_reps');
  }
}
