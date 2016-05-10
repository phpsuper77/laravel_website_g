<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Screenshot extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	 	//
        Schema::table('layout_theme', function($table){
            $table->text('screenshot');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('layout_theme', function($table){
            $table->dropColumn('screenshot');
        });
	}

}
