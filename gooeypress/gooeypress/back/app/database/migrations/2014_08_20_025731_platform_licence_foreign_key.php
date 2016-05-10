<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlatformLicenceForeignKey extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::table('themes', function($table){
            $table->foreign('licence_id')->references('id')->on('licences')->onDelete('cascade');
            $table->foreign('platform_id')->references('id')->on('platforms')->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
        Schema::table('themes', function($table){
            $table->dropForeign('themes_licence_id_foreign');
            $table->dropForeign('themes_platform_id_foreign');
        });
	}

}
