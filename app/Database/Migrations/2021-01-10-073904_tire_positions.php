<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TirePositions extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'			=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'name'			=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'left_right'	=> ['type' => 'VARCHAR', 'constraint' => 5, 'default' => ''],
			'front_rear'	=> ['type' => 'VARCHAR', 'constraint' => 5, 'default' => ''],
			'inner_outter'	=> ['type' => 'VARCHAR', 'constraint' => 6, 'default' => ''],
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
		$this->forge->addKey('name');
		$this->forge->addKey('left_right');
		$this->forge->addKey('front_rear');
		$this->forge->addKey('inner_outter');
		$this->forge->createTable('tire_positions', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('tire_positions');
	}
}
