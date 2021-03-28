<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DemountingDetails extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'				=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'demounting_id'		=> ['type' => 'INT', 'default' => '0'],
			'code'				=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'tire_type_id'		=> ['type' => 'INT', 'default' => '0'],
			'tire_position_id'	=> ['type' => 'INT', 'default' => '0'],
			'km'				=> ['type' => 'DOUBLE', 'default' => '0'],
			'rtd1'				=> ['type' => 'DOUBLE', 'default' => '0'],
			'rtd2'				=> ['type' => 'DOUBLE', 'default' => '0'],
			'rtd3'				=> ['type' => 'DOUBLE', 'default' => '0'],
			'rtd4'				=> ['type' => 'DOUBLE', 'default' => '0'],
			'remark'				=> ['type' => 'VARCHAR', 'constraint' => 255, 'default' => ''],
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
		$this->forge->addKey('demounting_id');
		$this->forge->addKey('code');
		$this->forge->addKey('tire_type_id');
		$this->forge->addKey('tire_position_id');
		$this->forge->createTable('demounting_details', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('demounting_details');
	}
}
