<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCheckingDetails extends Migration
{
	public function up()
	{
		$this->forge->addColumn('checking_details', ["old_tire_position_id INT not null default '0' AFTER tire_position_id, ADD INDEX (old_tire_position_id);"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('checking_details', 'old_tire_position_id');
	}
}
