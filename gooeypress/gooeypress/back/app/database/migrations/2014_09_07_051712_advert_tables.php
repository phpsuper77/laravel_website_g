<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdvertTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('adverts', function($table){
            $table->increments('id');
            $table->timestamps();
            $table->enum('type', ['theme', 'product']);


            $table->integer('owner_id')->unsigned();
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('theme_id')->unsigned()->nullable();
            $table->foreign('theme_id')->references('id')->on('themes')->onDelete('cascade');

            $table->integer('impression_budget');
            $table->integer('click_budget');

            $table->integer('impressions');
            $table->integer('clicks');

            $table->string('txn_id', '128')->unique()->nullable();
            $table->double('price'); // per unit
            $table->double('qty');   // how many units
            $table->double('gross');
            $table->double('payed_amount');
            $table->enum('status', ['placed', 'payed', 'cancelled', 'published', 'suspended']);

            $table->string('name');
            $table->text('advert_image_url')->nullable();
        });

        Schema::create('impressions', function($table){
            $table->integer('advert_id')->unsigned();
            $table->foreign('advert_id')->references('id')->on('adverts')->onDelete('cascade');
            $table->timestamps();
            $table->string('ip', 15);
        });
        Schema::create('clicks', function($table){
            $table->integer('advert_id')->unsigned();
            $table->foreign('advert_id')->references('id')->on('adverts')->onDelete('cascade');
            $table->timestamps();
            $table->string('ip', 15);
        });

        Schema::table('themes', function($table){
            $table->enum('is_active_advert', ['no', 'yes']);
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
            $table->dropColumn('is_active_advert');
        });
        Schema::drop('clicks');
        Schema::drop('impressions');
        Schema::drop('adverts');
	}

}
