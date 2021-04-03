<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterDemountingDetails extends Migration
{
	public function up()
	{
		$this->forge->addColumn('mounting_details', ["tire_id INT not null default '0' AFTER mounting_id, ADD INDEX (tire_id);"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('mounting_details', 'tire_id');
	}
}
