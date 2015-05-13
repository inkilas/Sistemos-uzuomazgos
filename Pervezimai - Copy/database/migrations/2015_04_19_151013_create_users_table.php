<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->string('company');
            $table->string('email');
            $table->string('phone');
            $table->string('password',70);
            $table->string('company_code');
            $table->string('PVM');
            $table->string('city');
            $table->string('address');
            $table->text('comment');
            $table->boolean('type')->default(0);
            $table->boolean('activation')->default(0);
            $table->rememberToken();
            $table->timestamps();

            //$table->integer('country_id')->unsigned();
            //$table->foreign('country_id')->references('id')->on('countries');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
