<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Installations extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'			=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'seqno'			=> ['type' => 'INT', 'default' => '0'],
			'parent_id'		=> ['type' => 'INT', 'default' => '0'],
			'name'			=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'url'			=> ['type' => 'VARCHAR', 'constraint' => 255, 'default' => ''],
			'icon'			=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
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
		$this->forge->addKey('parent_id');
		$this->forge->createTable('installations', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('installations');
	}
}
