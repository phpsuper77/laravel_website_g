<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPerformanceFieldsToThemesTable extends Migration {

    private $fields = ['performance', 'performance_http_requests', 'performance_page_weight',
        'performance_code_quality', 'performance_render_speed',
        'performance_code_placement', 'performance_compression'];
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('themes', function(Blueprint $table)
		{
            foreach($this->fields as $field){
                $table->integer($field);
            }
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
            foreach($this->fields as $field){
                $table->dropColumn($field);
            }
		});
	}

}
