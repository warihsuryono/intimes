<?php

namespace App\Database\Seeds;

class specific_privileges extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'installations_office_only', 'denied_message' => ''],
            ['name' => 'checking_office_only', 'denied_message' => ''],
        ];
        $this->db->table('specific_privileges')->insertBatch($data);
    }
}
