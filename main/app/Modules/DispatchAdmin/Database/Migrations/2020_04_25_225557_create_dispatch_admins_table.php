<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDispatchAdminsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // Schema::create('dispatch_admins', function (Blueprint $table) {
    //   $table->id();
    //   $table->string('full_name');
    //   $table->string('email')->unique();
    //   $table->string('password');
    //   $table->string('gender')->enum(['male', 'female'])->nullable();
    //   $table->foreignId('office_branch_id')->default(1)->constrained();
    //   $table->boolean('is_active')->nullable();
    //   $table->timestamp('verified_at')->nullable();

    //   $table->rememberToken();
    //   $table->timestamps();
    //   $table->softDeletes();
    // });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    // Schema::dropIfExists('dispatch_admins');
  }
}
