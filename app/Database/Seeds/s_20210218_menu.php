<?php

namespace App\Database\Seeds;

class s_20210218_menu extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->db->query("DELETE FROM a_menu WHERE id BETWEEN 22 AND 40");
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

            ['id' => '31', 'seqno' => '7', 'parent_id' => '0', 'name' => 'Checking', 'url' => '#', 'icon' => 'fa fa-check'],
            ['id' => '32', 'seqno' => '1', 'parent_id' => '31', 'name' => 'Tire', 'url' => 'checkings', 'icon' => 'far fa-life-ring'],

            ['id' => '33', 'seqno' => '8', 'parent_id' => '0', 'name' => 'Reporting', 'url' => '#', 'icon' => 'fas fa-chart-line'],
            ['id' => '34', 'seqno' => '1', 'parent_id' => '33', 'name' => 'Tire', 'url' => '#', 'icon' => 'far fa-life-ring'],
            ['id' => '35', 'seqno' => '2', 'parent_id' => '33', 'name' => 'History', 'url' => '#', 'icon' => 'fa fa-history'],
            ['id' => '36', 'seqno' => '3', 'parent_id' => '33', 'name' => 'Checking', 'url' => '#', 'icon' => 'fa fa-check'],
            ['id' => '37', 'seqno' => '4', 'parent_id' => '33', 'name' => 'Vehicle Tire Cost', 'url' => '#', 'icon' => 'fas fa-wallet'],

            ['id' => '38', 'seqno' => '8', 'parent_id' => '0', 'name' => 'Administration', 'url' => '#', 'icon' => 'fas fa-folder-open'],
            ['id' => '39', 'seqno' => '1', 'parent_id' => '38', 'name' => 'Create SPK/PO', 'url' => '#', 'icon' => 'fas fa-file'],
            ['id' => '40', 'seqno' => '2', 'parent_id' => '38', 'name' => 'Outstanding Payment', 'url' => '#', 'icon' => 'fas fa-cash-register'],
        ];
        $this->db->table('a_menu')->insertBatch($data);
    }
}
