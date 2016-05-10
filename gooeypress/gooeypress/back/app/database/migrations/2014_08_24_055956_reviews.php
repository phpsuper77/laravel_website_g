<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Reviews extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('reviews', function($table){
            $table->increments('id');
            $table->integer('theme_id')->unsigned();;
            $table->integer('user_id')->unsigned();;

            $table->timestamps();
            $table->text('comment');
            $table->integer('rating');
            $table->enum('purchased', array('no', 'yes'));

            $table->foreign('theme_id')->references('id')->on('themes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('reviews');
	}

}
