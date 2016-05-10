<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterThemesTableToChangeStateRepresentation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('themes', function(Blueprint $table){
            $table->dropColumn('status');
            $table->dropColumn('completed');

            $table->enum('state', ['draft', 'completed', 'ready']);
            $table->enum('publication_status', ['pending', 'published']);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('themes', function(Blueprint $table){
            $table->dropColumn('publication_status');
            $table->dropColumn('state');
            $table->enum('status', ['draft','pending','published','rejected','accepted']);
            $table->enum('completed', ['no', 'yes']);
        });
	}

}
