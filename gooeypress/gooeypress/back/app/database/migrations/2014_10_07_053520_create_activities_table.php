<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('activities', function(Blueprint $table){
            $table->increments('id');
            $table->timestamps();
            $table->integer('owner_id')->unsigned();
            $table->integer('theme_id')->unsigned();
            $table->enum('activity', array('like', 'rate', 'save'));
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('activities');
	}

}
