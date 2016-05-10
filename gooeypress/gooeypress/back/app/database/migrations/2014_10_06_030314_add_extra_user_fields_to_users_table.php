<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraUserFieldsToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('users', function(Blueprint $table){
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->string('location', 128);
            $table->string('website', 128);
            $table->text('bio');

            $table->unique('username');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn('bio');
            $table->dropColumn('website');
            $table->dropColumn('location');
            $table->dropColumn('last_name');
            $table->dropColumn('first_name');

            $table->dropUnique('users_username_unique');
        });
	}

}
