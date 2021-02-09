<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterInstallations extends Migration
{
	public function up()
	{
		$this->forge->dropColumn('installations', 'price');
		$this->forge->dropColumn('installations', 'disassembled_tire');
		$this->forge->dropColumn('installations', 'km');
		$this->forge->dropColumn('installations', 'tread_depth');
		$this->forge->dropColumn('installations', 'photo');
		$this->forge->addColumn('installations', ["po_price DOUBLE default '0' AFTER spk_at"]);
		$this->forge->modifyColumn('installations', ["tire_is_retread" => ["name" => "tire_type_id", "type" => "INT", "default" => "0"]]);
		$this->forge->addColumn('installations', ["km_install DOUBLE default 0 AFTER tire_type_id"]);
		$this->forge->addColumn('installations', ["original_tread_depth DOUBLE default 0 AFTER km_install"]);
		$this->forge->modifyColumn('installations', ["flap_installation" => ["name" => "is_flap", "type" => "SMALLINT", "default" => "0"]]);
		$this->forge->addColumn('installations', ["is_tube SMALLINT default 0 AFTER flap_price"]);
		$this->forge->addColumn('installations', ["tube_price DOUBLE default 0 AFTER is_tube"]);
	}

	//--------------------------------------------------------

	public function down()
	{
	}
}
