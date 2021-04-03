<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCheckingDetails extends Migration
{
	public function up()
	{
		$this->forge->addColumn('checking_details', ["tire_id INT not null default '0' AFTER checking_id, ADD INDEX (tire_id);"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('checking_details', 'tire_id');
	}
}
