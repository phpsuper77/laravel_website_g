<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPerformanceLevelsToThemesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('themes', function(Blueprint $table)
		{
            $table->integer('level_overall');
            $table->integer('level_http_requests');
            $table->integer('level_page_weight');
            $table->integer('level_code_quality');
            $table->integer('level_render_speed');
            $table->integer('level_code_placement');
            $table->integer('level_compression');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('themes', function(Blueprint $table)
		{
            $table->dropColumn('level_overall');
            $table->dropColumn('level_http_requests');
            $table->dropColumn('level_page_weight');
            $table->dropColumn('level_code_quality');
            $table->dropColumn('level_render_speed');
            $table->dropColumn('level_code_placement');
            $table->dropColumn('level_compression');
		});
	}

}
