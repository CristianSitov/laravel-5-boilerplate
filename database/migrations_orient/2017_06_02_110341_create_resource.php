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
		Schema::connection('orientdb')->create('HeritageResources', function(Blueprint $table)
		{
            $table->string('uuid');
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
		Schema::connection('orientdb')->drop('HeritageResources');
	}

}
