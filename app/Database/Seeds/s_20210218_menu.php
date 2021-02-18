<?php

namespace App\Database\Seeds;

class s_20210218_menu extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->db->query("DELETE FROM a_menu WHERE id=22");
        $data = [
            ['id' => '22', 'seqno' => '1', 'parent_id' => '4', 'name' => 'Big Data', 'url' => 'bigdata', 'icon' => 'fas fa-database'],
        ];
        $this->db->table('a_menu')->insertBatch($data);
    }
}
