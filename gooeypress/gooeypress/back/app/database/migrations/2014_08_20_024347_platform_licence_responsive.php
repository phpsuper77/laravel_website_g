<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlatformLicenceResponsive extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('licences', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->text('url');
            $table->timestamps();
        });
        Schema::create('platforms', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->text('url');
            $table->timestamps();
        });
        Schema::table('themes', function(Blueprint $table){
            $table->enum('responsive', array('yes', 'no'));
            $table->integer('licence_id')->unsigned()->nullable();
            $table->integer('platform_id')->unsigned()->nullable();

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
            $table->dropColumn('responsive');
            $table->dropColumn('licence_id');
            $table->dropColumn('platform_id');
        });

        Schema::dropIfExists('platforms');
        Schema::dropIfExists('licences');
	}

}
