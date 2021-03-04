<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCommentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_comments', function (Blueprint $table) {
      $table->id();
			$table->bigInteger('user_id');
			$table->string('user_type');
			$table->bigInteger('subject_id');
			$table->string('subject_type');
			$table->text('comment');

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
		Schema::dropIfExists('user_comments');
	}
}
