<?php

use Sgpatil\Orientdb\Schema\Blueprint;
use Sgpatil\Orientdb\Migrations\Migration;

class ChangeHeritageResourcesAddExtraFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('orientdb')->table('HeritageResources', function(Blueprint $table)
		{
            $table->string('uuid');
            $table->string('name');
            $table->string('description', 10000);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection('orientdb')->table('HeritageResources', function(Blueprint $table)
		{
            $table->dropColumn('name');
            $table->dropColumn('description');
		});
	}

}
