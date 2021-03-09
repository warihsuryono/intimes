<?php

namespace App\Database\Seeds;

class s_20210309_tire_positions extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->db->query("TRUNCATE tire_positions");
        $data = [
            ['name' => 'FRONT LEFT', 'code' => 'FL', 'left_right' => 'left', 'front_rear' => 'front', 'inner_outter ' => ''],
            ['name' => 'FRONT RIGHT', 'code' => 'FR', 'left_right' => 'right', 'front_rear' => 'front', 'inner_outter ' => ''],
            ['name' => 'REAR LEFT OUT 1', 'code' => 'RLO1', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'outter'],
            ['name' => 'REAR LEFT IN 1', 'code' => 'RLI1', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'inner'],
            ['name' => 'REAR RIGHT IN 1', 'code' => 'RRI1', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'inner'],
            ['name' => 'REAR RIGHT OUT 1', 'code' => 'RRO1', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'outter'],
            ['name' => 'REAR LEFT OUT 2', 'code' => 'RLO2', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'outter'],
            ['name' => 'REAR LEFT IN 2', 'code' => 'RLI2', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'inner'],
            ['name' => 'REAR RIGHT IN 2', 'code' => 'RRI2', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'inner'],
            ['name' => 'REAR RIGHT OUT 2', 'code' => 'RRO2', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'outter'],
            ['name' => 'REAR LEFT OUT 1', 'code' => 'TLO1', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'outter'],
            ['name' => 'REAR LEFT IN 1', 'code' => 'TLI1', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'inner'],
            ['name' => 'REAR RIGHT IN 1', 'code' => 'TRI1', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'inner'],
            ['name' => 'REAR RIGHT OUT 2', 'code' => 'TRO1', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'outter'],
            ['name' => 'REAR LEFT OUT 2', 'code' => 'TLO2', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'outter'],
            ['name' => 'REAR LEFT IN 2', 'code' => 'TLI2', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'inner'],
            ['name' => 'REAR RIGHT IN 2', 'code' => 'TRI2', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'inner'],
            ['name' => 'REAR RIGHT OUT 2', 'code' => 'TRO2', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'outter'],
            ['name' => 'REAR LEFT OUT 3', 'code' => 'TLO3', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'outter'],
            ['name' => 'REAR LEFT IN 3', 'code' => 'TLI3', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'inner'],
            ['name' => 'REAR RIGHT IN 3', 'code' => 'TRI3', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'inner'],
            ['name' => 'REAR RIGHT OUT 3', 'code' => 'TRO3', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'outter'],
        ];
        $this->db->table('tire_positions')->insertBatch($data);
    }
}
