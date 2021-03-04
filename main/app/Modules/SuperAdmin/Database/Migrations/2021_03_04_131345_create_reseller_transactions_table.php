<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResellerTransactionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('reseller_transactions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('reseller_id');
      $table->double('amount');
      $table->enum('trans_type', ['debit', 'credit']);
      $table->string('purpose');
      $table->unsignedBigInteger('recorder_id');
      $table->string('recorder_type');

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
    Schema::dropIfExists('reseller_transactions');
  }
}
