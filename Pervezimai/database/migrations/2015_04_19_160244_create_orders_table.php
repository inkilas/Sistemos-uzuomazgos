<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
            $table->increments('id');
            $table->date('order_date');
            $table->integer('client_id')->unsigned();
            $table->integer('provider_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->boolean('extra_services')->default(0);
            $table->string('pickup_address');
            $table->string('deliver_address');
            $table->string('extra_address');
            $table->text('order_comment');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}

}
