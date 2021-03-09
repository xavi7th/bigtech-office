<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressAndAvatarToQualityControlsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('quality_controls', function (Blueprint $table) {
      $table->string('phone')->nullable()->after('gender');
      $table->string('address')->nullable()->after('phone');
      $table->string('avatar')->nullable()->after('address');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('quality_controls', function (Blueprint $table) {
      $table->dropColumn('address');
      $table->dropColumn('avatar');
      $table->dropColumn('phone');
    });
  }
}
