<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressAndAvatarToAuditorsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('auditors', function (Blueprint $table) {
      $table->string('phone')->after('gender');
      $table->string('address')->after('phone');
      $table->string('avatar')->after('address');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('auditors', function (Blueprint $table) {
      $table->dropColumn('address');
      $table->dropColumn('avatar');
    });
  }
}
