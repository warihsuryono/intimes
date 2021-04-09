<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCheckingDetails2021040901 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('checking_details', ["decision varchar(10) not null default '' AFTER tire_position_changed;"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('checking_details', 'decision');
	}
}
