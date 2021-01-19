<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Vehicles extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'					=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'registration_plate'	=> ['type' => 'VARCHAR', 'constraint' => 10, 'default' => ''],
			'vehicle_type_id'		=> ['type' => 'INT', 'default' => '0'],
			'vehicle_brand_id'		=> ['type' => 'INT', 'default' => '0'],
			'model'					=> ['type' => 'VARCHAR', 'constraint' => 50, 'default' => ''],
			'body_no'				=> ['type' => 'VARCHAR', 'constraint' => 50, 'default' => ''],
			'created_at'			=> ['type' => 'datetime', 'null' => true],
			'created_by'			=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'created_ip'			=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'updated_at'			=> ['type' => 'datetime', 'null' => true],
			'updated_by'			=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'updated_ip'			=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'is_deleted'			=> ['type' => 'smallint', 'default' => '0'],
			'deleted_at'			=> ['type' => 'datetime', 'null' => true],
			'deleted_by'			=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'deleted_ip'			=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
			'xtimestamp timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()'
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addKey('is_deleted');
		$this->forge->addKey('registration_plate');
		$this->forge->addKey('vehicle_type_id');
		$this->forge->addKey('vehicle_brand_id');
		$this->forge->addKey('model');
		$this->forge->createTable('vehicles', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('vehicles');
	}
}
