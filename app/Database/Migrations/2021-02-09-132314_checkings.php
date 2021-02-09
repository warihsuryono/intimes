<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Checkings extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'							=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'installation_id'				=> ['type' => 'INT', 'default' => '0'],
			'tire_id'						=> ['type' => 'INT', 'default' => '0'],
			'tire_qr_code'					=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'old_tire_position_id'			=> ['type' => 'INT', 'default' => '0'],
			'tire_position_id'				=> ['type' => 'INT', 'default' => '0'],
			'tire_position_changed'			=> ['type' => 'SMALLINT', 'default' => '0'],
			'tire_position_remark'			=> ['type' => 'VARCHAR', 'constraint' => 255, 'default' => ''],
			'check_km'						=> ['type' => 'DOUBLE', 'default' => '0'],
			'check_at'						=> ['type' => 'DATE'],
			'remain_tread_depth'			=> ['type' => 'DOUBLE', 'default' => '0'],
			'psi'							=> ['type' => 'DOUBLE', 'default' => '0'],
			'notes'							=> ['type' => 'VARCHAR', 'constraint' => 255, 'default' => ''],
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
		$this->forge->addKey('installation_id');
		$this->forge->addKey('tire_id');
		$this->forge->addKey('tire_qr_code');
		$this->forge->addKey('old_tire_position_id');
		$this->forge->addKey('tire_position_id');
		$this->forge->addKey('tire_position_changed');
		$this->forge->createTable('checkings', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('checkings');
	}
}
