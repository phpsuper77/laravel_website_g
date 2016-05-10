<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Init extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('layouts', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('styles', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('genres', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('vendors', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('authors', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('requirements', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('themes', function(Blueprint $table){
            $table->increments('id');

            $table->timestamps();

            $table->text('title');
            $table->text('notes');
            $table->double('price');
            $table->enum('price_type', array('free', 'fixed', 'membership'));
            $table->text('link_purchase');
            $table->text('link_demo');

            $table->enum('level', array('A', 'B', 'C', 'D'));

            $table->integer('style_id')->unsigned()->nullable();
            $table->integer('genre_id')->unsigned()->nullable();
            $table->integer('vendor_id')->unsigned()->nullable();
            $table->integer('author_id')->unsigned()->nullable();
            $table->integer('requirement_id')->unsigned()->nullable();
            $table->integer('default_layout_id')->unsigned()->nullable();

            $table->foreign('style_id')->references('id')->on('styles')->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
            $table->foreign('requirement_id')->references('id')->on('requirements')->onDelete('cascade');
            $table->foreign('default_layout_id')->references('id')->on('layouts')->onDelete('cascade');
        });

        Schema::create('layout_theme', function(Blueprint $table){
            $table->integer('theme_id')->unsigned();;
            $table->integer('layout_id')->unsigned();;

            $table->text('url');

            $table->foreign('theme_id')->references('id')->on('themes')->onDelete('cascade');
            $table->foreign('layout_id')->references('id')->on('layouts')->onDelete('cascade');
        });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('layout_theme');
        Schema::drop('themes');
        Schema::drop('requirements');
        Schema::drop('authors');
        Schema::drop('vendors');
        Schema::drop('genres');
        Schema::drop('styles');
        Schema::drop('layouts');
	}

}
