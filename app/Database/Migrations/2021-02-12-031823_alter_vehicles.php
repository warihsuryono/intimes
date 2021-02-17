<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterVehicles extends Migration
{
	public function up()
	{
		$this->forge->addColumn('vehicles', ["customer_id INT default '0' AFTER id, ADD INDEX (customer_id)"]);
		$this->forge->addColumn('vehicles', ["customer_name VARCHAR(100) default '' AFTER customer_id"]);
	}

	//--------------------------------------------------------

	public function down()
	{
	}
}
