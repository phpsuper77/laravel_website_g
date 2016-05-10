<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DefaultValues extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::statement("ALTER TABLE themes MODIFY COLUMN price double NOT NULL DEFAULT '-1'");
        DB::statement("ALTER TABLE themes MODIFY COLUMN price_type ENUM('none', 'free', 'fixed', 'membership') NOT NULL DEFAULT 'none'");
        DB::statement("ALTER TABLE themes MODIFY COLUMN level ENUM('none', 'A', 'B', 'C', 'D') NOT NULL DEFAULT 'none'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        DB::statement("ALTER TABLE themes MODIFY COLUMN price double NOT NULL DEFAULT '0'");
        DB::statement("ALTER TABLE themes MODIFY COLUMN price_type ENUM('free', 'fixed', 'membership') NOT NULL DEFAULT 'free'");
        DB::statement("ALTER TABLE themes MODIFY COLUMN level ENUM('A', 'B', 'C', 'D')");
	}

}
