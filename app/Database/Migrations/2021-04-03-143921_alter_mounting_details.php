<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterMountingDetails extends Migration
{
	public function up()
	{
		$this->forge->addColumn('demounting_details', ["tire_id INT not null default '0' AFTER demounting_id, ADD INDEX (tire_id);"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('demounting_details', 'tire_id');
	}
}
