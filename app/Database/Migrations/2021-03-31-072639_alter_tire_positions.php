<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTirePositions extends Migration
{
	public function up()
	{
		$this->forge->addColumn('tire_positions', ["styles varchar(255) not null AFTER inner_outter;"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('tire_positions', 'styles');
	}
}
