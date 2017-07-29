<?php

use Sgpatil\Orientdb\Schema\Blueprint;
use Sgpatil\Orientdb\Migrations\Migration;

class CreateResourceDescription extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('orientdb')->create('Description', function(Blueprint $table)
		{
            $table->string('uuid');
            $table->string('description');
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
		Schema::connection('orientdb')->drop('Description');
	}

}
