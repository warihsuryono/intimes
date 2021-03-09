<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTirePositions extends Migration
{
	public function up()
	{
		$this->forge->addColumn('tire_positions', ["code varchar(10) not null AFTER name, ADD INDEX (code);"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('tire_positions', 'code');
	}
}
