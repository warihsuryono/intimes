<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Customers extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'					=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'industry_category_id'	=> ['type' => 'INT', 'default' => '0'],
			'company_name'			=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => '0'],
			'pic'					=> ['type' => 'VARCHAR', 'constraint' => 50, 'default' => ''],
			'pic_phone'				=> ['type' => 'VARCHAR', 'constraint' => 30, 'default' => ''],
			'email'					=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'address'				=> ['type' => 'VARCHAR', 'constraint' => 255, 'default' => ''],
			'city'					=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'province'				=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'country'				=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'zipcode'				=> ['type' => 'VARCHAR', 'constraint' => 10, 'default' => ''],
			'phone'					=> ['type' => 'VARCHAR', 'constraint' => 30, 'default' => ''],
			'fax'					=> ['type' => 'VARCHAR', 'constraint' => 30, 'default' => ''],
			'nationality'			=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
			'remarks'				=> ['type' => 'VARCHAR', 'constraint' => 255, 'default' => ''],
			'npwp'					=> ['type' => 'VARCHAR', 'constraint' => 50, 'default' => ''],
			'nppkp'					=> ['type' => 'VARCHAR', 'constraint' => 50, 'default' => ''],
			'tax_invoice_no'		=> ['type' => 'VARCHAR', 'constraint' => 50, 'default' => ''],
			'bank_id'				=> ['type' => 'INT', 'default' => '0'],
			'bank_account'			=> ['type' => 'VARCHAR', 'constraint' => 50, 'default' => ''],
			'reg_code'				=> ['type' => 'VARCHAR', 'constraint' => 50, 'default' => ''],
			'reg_at'				=> ['type' => 'DATE'],
			'join_at'				=> ['type' => 'DATE'],
			'customer_level_id'		=> ['type' => 'INT', 'default' => '0'],
			'customer_prospect_id'	=> ['type' => 'INT', 'default' => '0'],
			'description'			=> ['type' => 'TEXT', 'default' => ''],
			'am_by'					=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
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
		$this->forge->addKey('company_name');
		$this->forge->addKey('pic');
		$this->forge->addKey('pic_phone');
		$this->forge->addKey('email');
		$this->forge->addKey('city');
		$this->forge->addKey('bank_id');
		$this->forge->addKey('reg_code');
		$this->forge->addKey('industry_category_id');
		$this->forge->addKey('customer_prospect_id');
		$this->forge->addKey('am_by');
		$this->forge->createTable('customers', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('customers');
	}
}
