<?php

namespace App\Database\Seeds;

class s_20210401_vehicle_types extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->db->query("TRUNCATE vehicle_types");
        $data = [
            ['name' => 'CDE', 'tire_position_ids' => '1,2,4,5'],
            ['name' => 'CDD', 'tire_position_ids' => '1,2,3,4,5,6'],
            ['name' => 'FUSO ENGKEL', 'tire_position_ids' => '1,2,3,4,5,6'],
            ['name' => 'FUSO TRONTON', 'tire_position_ids' => '1,2,3,4,5,6,7,8,9,10'],
            ['name' => 'HEAD TRACTOR ENGKEL', 'tire_position_ids' => '1,2,3,4,5,6'],
            ['name' => 'HEAD TRACTOR TRONTON', 'tire_position_ids' => '1,2,3,4,5,6,7,8,9,10'],
            ['name' => 'HEAD TRACTOR ENGKEL - TRAILER 20ft', 'tire_position_ids' => '1,2,3,4,5,6,11,12,13,14,15,16,17,18'],
            ['name' => 'HEAD TRACTOR ENGKEL - TRAILER 40ft', 'tire_position_ids' => '1,2,3,4,5,6,11,12,13,14,15,16,17,18,19,20,21,22'],
            ['name' => 'HEAD TRACTOR TRONTON - TRAILER 20ft', 'tire_position_ids' => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18'],
            ['name' => 'HEAD TRACTOR TRONTON - TRAILER 40ft', 'tire_position_ids' => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22'],
        ];
        $this->db->table('vehicle_types')->insertBatch($data);
    }
}
