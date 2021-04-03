<?php

namespace App\Database\Seeds;

class s_20210218_menu extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->db->query("DELETE FROM a_menu WHERE id IN (22,23,24,25,26,27,28,29,30)");
        $data = [
            ['id' => '22', 'seqno' => '1', 'parent_id' => '4', 'name' => 'Big Data', 'url' => 'bigdata', 'icon' => 'fas fa-database'],
            ['id' => '23', 'seqno' => '11', 'parent_id' => '2', 'name' => 'Tube Brands', 'url' => 'tube_brands', 'icon' => 'fa fa-copyright'],
            ['id' => '24', 'seqno' => '12', 'parent_id' => '2', 'name' => 'Flap Brands', 'url' => 'flap_brands', 'icon' => 'fa fa-copyright'],

            ['id' => '25', 'seqno' => '6', 'parent_id' => '0', 'name' => 'Mounting', 'url' => '#', 'icon' => 'fa fa-download'],
            ['id' => '26', 'seqno' => '1', 'parent_id' => '25', 'name' => 'Tire', 'url' => 'mountings', 'icon' => 'far fa-life-ring'],
            ['id' => '27', 'seqno' => '2', 'parent_id' => '25', 'name' => 'Sparepart', 'url' => '#', 'icon' => 'far fa-circle'],
            ['id' => '28', 'seqno' => '3', 'parent_id' => '25', 'name' => 'Vehicle', 'url' => '#', 'icon' => 'far fa-circle'],
            ['id' => '29', 'seqno' => '4', 'parent_id' => '25', 'name' => 'Customer Order', 'url' => '#', 'icon' => 'far fa-circle'],
            ['id' => '30', 'seqno' => '5', 'parent_id' => '25', 'name' => 'Service', 'url' => '#', 'icon' => 'far fa-circle'],
        ];
        $this->db->table('a_menu')->insertBatch($data);
    }
}
