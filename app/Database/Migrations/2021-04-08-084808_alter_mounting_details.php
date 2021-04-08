<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterMountingDetails084808 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('mounting_details', ["tire_pattern_id int not null default '0' AFTER tire_position_id;"]);
		$this->forge->addColumn('mounting_details', ["tire_brand_id int not null default '0' AFTER tire_position_id;"]);
		$this->forge->addColumn('mounting_details', ["tire_size_id int not null default '0' AFTER tire_position_id;"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('mounting_details', 'tire_pattern_id');
		$this->forge->dropColumn('mounting_details', 'tire_brand_id');
		$this->forge->dropColumn('mounting_details', 'tire_size_id');
	}
}
