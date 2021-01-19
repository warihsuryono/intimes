<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tires extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'				=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'name'				=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'qrcode'			=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'serialno'			=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'tire_size_id'		=> ['type' => 'INT', 'default' => '0'],
			'tire_brand_id'		=> ['type' => 'INT', 'default' => '0'],
			'tire_type_id'		=> ['type' => 'INT', 'default' => '0'],
			'tire_pattern_id'	=> ['type' => 'INT', 'default' => '0'],
			'tread_depth'		=> ['type' => 'DOUBLE', 'default' => '0'],
			'psi'				=> ['type' => 'DOUBLE', 'default' => '0'],
			'remark'			=> ['type' => 'VARCHAR', 'constraint' => 255, 'default' => ''],
			'created_at'		=> ['type' => 'datetime', 'null' => true],
			'created_by'		=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'created_ip'		=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'updated_at'		=> ['type' => 'datetime', 'null' => true],
			'updated_by'		=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'updated_ip'		=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'is_deleted'		=> ['type' => 'smallint', 'default' => '0'],
			'deleted_at'		=> ['type' => 'datetime', 'null' => true],
			'deleted_by'		=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'deleted_ip'		=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'xtimestamp timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()'
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addKey('is_deleted');
		$this->forge->addKey('qrcode');
		$this->forge->addKey('serialno');
		$this->forge->addKey('name');
		$this->forge->addKey('is_retread');
		$this->forge->addKey('tire_size_id');
		$this->forge->addKey('tire_brand_id');
		$this->forge->addKey('tire_type_id');
		$this->forge->addKey('tire_pattern_id');
		$this->forge->addKey('pattern');
		$this->forge->createTable('tires', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('tires');
	}
}
