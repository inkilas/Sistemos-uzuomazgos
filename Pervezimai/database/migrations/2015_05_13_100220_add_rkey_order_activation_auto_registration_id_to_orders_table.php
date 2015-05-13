<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRkeyOrderActivationAutoRegistrationIdToOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function(Blueprint $table)
		{
            $table->string('order_key');
            $table->boolean('order_activation')->default(0);
            $table->integer('auto_registration_id')->unsigned()->index();
            $table->foreign('auto_registration_id')->references('id')->on('auto_registrations')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orders', function(Blueprint $table)
		{
            $table->dropColumn('order_key');
            $table->dropColumn('order_activation');
            $table->dropColumn('auto_registration_id');
		});
	}

}
