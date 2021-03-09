<?php

namespace App\Database\Seeds;

class s_20210218_menu extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->db->query("DELETE FROM a_menu WHERE id=22");
        $this->db->query("DELETE FROM a_menu WHERE id=23");
        $this->db->query("DELETE FROM a_menu WHERE id=24");
        $data = [
            ['id' => '22', 'seqno' => '1', 'parent_id' => '4', 'name' => 'Big Data', 'url' => 'bigdata', 'icon' => 'fas fa-database'],
            ['id' => '23', 'seqno' => '11', 'parent_id' => '2', 'name' => 'Tube Brands', 'url' => 'tube_brands', 'icon' => 'fa fa-copyright'],
            ['id' => '24', 'seqno' => '12', 'parent_id' => '2', 'name' => 'Flap Brands', 'url' => 'flap_brands', 'icon' => 'fa fa-copyright'],
        ];
        $this->db->table('a_menu')->insertBatch($data);
    }
}
