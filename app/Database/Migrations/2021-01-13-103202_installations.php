<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Installations extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'							=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'spk_no'						=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'spk_at'						=> ['type' => 'date'],
			'installed_at'					=> ['type' => 'date'],
			'vehicle_id'					=> ['type' => 'INT', 'default' => '0'],
			'vehicle_registration_plate'	=> ['type' => 'VARCHAR', 'constraint' => 10, 'default' => ''],
			'tire_id'						=> ['type' => 'INT', 'default' => '0'],
			'tire_qr_code'					=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'tire_position_id'				=> ['type' => 'INT', 'default' => '0'],
			'tire_is_retread'				=> ['type' => 'SMALLINT', 'default' => '0'],
			'price'							=> ['type' => 'DOUBLE', 'default' => '0'],
			'flap_installation'				=> ['type' => 'VARCHAR', 'constraint' => 50, 'default' => ''],
			'flap_price'					=> ['type' => 'DOUBLE', 'default' => '0'],
			'disassembled_tire'				=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'km'							=> ['type' => 'DOUBLE', 'default' => '0'],
			'tread_depth'					=> ['type' => 'DOUBLE', 'default' => '0'],
			'photo'							=> ['type' => 'VARCHAR', 'constraint' => 255, 'default' => ''],
			'created_at'					=> ['type' => 'datetime', 'null' => true],
			'created_by'					=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'created_ip'					=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'updated_at'					=> ['type' => 'datetime', 'null' => true],
			'updated_by'					=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'updated_ip'					=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'is_deleted'					=> ['type' => 'smallint', 'default' => '0'],
			'deleted_at'					=> ['type' => 'datetime', 'null' => true],
			'deleted_by'					=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'deleted_ip'					=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'xtimestamp timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()'
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addKey('is_deleted');
		$this->forge->addKey('spk_no');
		$this->forge->addKey('spk_at');
		$this->forge->addKey('installed_at');
		$this->forge->addKey('vehicle_id');
		$this->forge->addKey('vehicle_registration_plate');
		$this->forge->addKey('tire_id');
		$this->forge->addKey('tire_qr_code');
		$this->forge->addKey('tire_position_id');
		$this->forge->addKey('tire_is_retread');
		$this->forge->createTable('installations', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('installations');
	}
}
