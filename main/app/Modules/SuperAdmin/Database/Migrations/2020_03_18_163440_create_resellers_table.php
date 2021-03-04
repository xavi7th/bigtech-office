<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResellersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('resellers', function (Blueprint $table) {
      $table->id();
      $table->string('business_name')->unique();
      $table->string('ceo_name');
      $table->string('address');
      $table->string('phone');
      $table->string('img_url')->default('https://via.placeholder.com/150x150.jpg?text=Image+not+found');

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
    Schema::dropIfExists('resellers');
  }
}
