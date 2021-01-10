<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TireTypes extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'			=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'name'			=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'created_at'	=> ['type' => 'datetime', 'null' => true],
			'created_by'	=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'created_ip'	=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'updated_at'	=> ['type' => 'datetime', 'null' => true],
			'updated_by'	=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'updated_ip'	=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'is_deleted'	=> ['type' => 'smallint', 'default' => '0'],
			'deleted_at'	=> ['type' => 'datetime', 'null' => true],
			'deleted_by'	=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'deleted_ip'	=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'xtimestamp timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()'
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addKey('is_deleted');
		$this->forge->createTable('tire_types', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('tire_types');
	}
}
