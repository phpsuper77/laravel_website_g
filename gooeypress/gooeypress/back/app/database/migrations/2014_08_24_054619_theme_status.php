<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ThemeStatus extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('themes', function($table){
            $table->enum('status',
                array('draft', 'pending', 'published', 'rejected', 'accepted'));
            $table->enum('completed', array('no', 'yes'));
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('themes', function($table){
            $table->dropColumn('status');
            $table->dropColumn('completed');
        });
	}

}
