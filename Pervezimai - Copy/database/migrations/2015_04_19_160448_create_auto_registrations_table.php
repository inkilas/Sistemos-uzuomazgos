<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoRegistrationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('auto_registrations', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('auto_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('auto_city');
            $table->boolean('extra_services')->default(0);
            $table->float('price_h');
            $table->float('price_km');
            $table->text('auto_comment');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('auto_id')->references('id')->on('auto_types');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('auto_registrations');
	}

}
