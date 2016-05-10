<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('users', function($table){
            $table->string('email', 128);
            $table->string('nicename', 128);

            $table->unique('email');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('users', function($table){
            $table->dropIndex('users_email_unique');

            $table->dropColumn('nicename');
            $table->dropColumn('email');
        });
	}

}
