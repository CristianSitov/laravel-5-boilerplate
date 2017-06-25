<?php

use Sgpatil\Orientdb\Schema\Blueprint;
use Sgpatil\Orientdb\Migrations\Migration;

class CreateResourceClassificationTypes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('orientdb')->create('ResourceClassificationType', function(Blueprint $table)
		{
			$table->string('uuid');
			$table->string('type');
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
		Schema::connection('orientdb')->drop('ResourceClassificationType');
	}

}
