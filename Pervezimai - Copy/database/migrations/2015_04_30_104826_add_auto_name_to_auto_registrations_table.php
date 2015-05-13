<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAutoNameToAutoRegistrationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('auto_registrations', function(Blueprint $table)
		{
			$table->string('auto_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('auto_registrations', function(Blueprint $table)
		{
			$table->dropColumn('auto_name');
		});
	}

}
