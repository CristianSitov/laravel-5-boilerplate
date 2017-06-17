<?php

use Sgpatil\Orientdb\Schema\Blueprint;
use Sgpatil\Orientdb\Migrations\Migration;

class CreateResource extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('orientdb')->create('heritage_resources', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection('orientdb')->drop('heritage_resources');
	}

}
