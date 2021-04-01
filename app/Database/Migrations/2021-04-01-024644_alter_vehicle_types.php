<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterVehicleTypes extends Migration
{
	public function up()
	{
		$this->forge->addColumn('vehicle_types', ["tire_position_ids varchar(255) not null default '' AFTER name;"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('vehicle_types', 'tire_position_ids');
	}
}
