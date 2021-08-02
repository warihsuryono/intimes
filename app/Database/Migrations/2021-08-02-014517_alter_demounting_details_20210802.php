<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterDemountingDetails20210802 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('demounting_details', ["tire_size_id INT not null default '0' AFTER tire_position_id;"]);
		$this->forge->addColumn('demounting_details', ["tire_brand_id INT not null default '0' AFTER tire_size_id;"]);
		$this->forge->addColumn('demounting_details', ["tire_pattern_id INT not null default '0' AFTER tire_brand_id;"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('demounting_details', 'tire_size_id');
		$this->forge->dropColumn('demounting_details', 'tire_brand_id');
		$this->forge->dropColumn('demounting_details', 'tire_pattern_id');
	}
}
