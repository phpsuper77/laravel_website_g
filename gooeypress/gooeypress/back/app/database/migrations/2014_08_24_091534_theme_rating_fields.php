<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ThemeRatingFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('themes', function($table){
            $table->double('rating');
            $table->integer('rating_count');
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
            $table->dropColumn('rating_count');
            $table->dropColumn('rating');
        });
	}
}
