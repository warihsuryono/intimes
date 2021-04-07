<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCheckingDetails004816 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('checking_details', ["psi_before double not null default '0' AFTER rtd4;"]);
		$this->forge->addColumn('checking_details', ["psi double not null default '0' AFTER psi_before;"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('checking_details', 'psi_before');
		$this->forge->dropColumn('checking_details', 'psi');
	}
}
