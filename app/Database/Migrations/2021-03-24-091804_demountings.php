<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Demountings extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'							=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'mounting_id'					=> ['type' => 'INT', 'default' => '0'],
			'spk_id'						=> ['type' => 'INT', 'default' => '0'],
			'spk_no'						=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'spk_at'						=> ['type' => 'date', 'null' => true],
			'demounting_at'					=> ['type' => 'date', 'null' => true],
			'vehicle_id'					=> ['type' => 'INT', 'default' => '0'],
			'vehicle_registration_plate'	=> ['type' => 'VARCHAR', 'constraint' => 10, 'default' => ''],
			'notes'							=> ['type' => 'TEXT', 'default' => ''],
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
		$this->forge->addKey('mounting_id');
		$this->forge->addKey('spk_id');
		$this->forge->addKey('spk_no');
		$this->forge->addKey('spk_at');
		$this->forge->addKey('demounting_at');
		$this->forge->addKey('vehicle_id');
		$this->forge->addKey('vehicle_registration_plate');
		$this->forge->createTable('demountings', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('demountings');
	}
}
