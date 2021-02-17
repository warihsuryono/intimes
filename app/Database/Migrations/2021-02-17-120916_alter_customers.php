<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCustomers extends Migration
{
	public function up()
	{
		$this->forge->addColumn('customers', ["pool VARCHAR(100) default '' AFTER company_name"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
