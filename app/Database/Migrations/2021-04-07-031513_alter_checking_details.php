<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCheckingDetails031513 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('checking_details', ["tire_position_changed smallint not null default '0' AFTER old_tire_position_id;"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('checking_details', 'tire_position_changed');
	}
}
