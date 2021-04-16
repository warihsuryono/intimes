<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCheckings20210416 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('checkings', ["km double not null default '0' AFTER vehicle_registration_plate;"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('checkings', 'km');
	}
}
