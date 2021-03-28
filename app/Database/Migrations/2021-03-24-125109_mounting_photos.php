<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MountingPhotos extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'				=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'mounting_id'		=> ['type' => 'INT', 'default' => '0'],
			'mounting_detail_id'=> ['type' => 'INT', 'default' => '0'],
			'tire_type_id'		=> ['type' => 'INT', 'default' => '0'],
			'filename'			=> ['type' => 'VARCHAR', 'constraint' => 255, 'default' => ''],
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
		$this->forge->addKey('mounting_id');
		$this->forge->addKey('mounting_detail_id');
		$this->forge->createTable('mounting_photos', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('mounting_photos');
	}
}
