<?php

namespace App\Database\Seeds;

class s_20210309_tire_positions extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->db->query("TRUNCATE tire_positions");
        $data = [
            ['id' => 1, 'name' => 'FRONT LEFT', 'code' => 'FL', 'left_right' => 'left', 'front_rear' => 'front', 'inner_outter ' => '', 'styles' => 'top:0px;left:45px'],
            ['id' => 2, 'name' => 'FRONT RIGHT', 'code' => 'FR', 'left_right' => 'right', 'front_rear' => 'front', 'inner_outter ' => '', 'styles' => 'top:0px;left:150px'],
            ['id' => 3, 'name' => 'REAR LEFT OUT 1', 'code' => 'RLO1', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'outter', 'styles' => 'top:100px;left:0px'],
            ['id' => 4, 'name' => 'REAR LEFT IN 1', 'code' => 'RLI1', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'inner', 'styles' => 'top:100px;left:45px'],
            ['id' => 5, 'name' => 'REAR RIGHT IN 1', 'code' => 'RRI1', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'inner', 'styles' => 'top:100px;left:150px'],
            ['id' => 6, 'name' => 'REAR RIGHT OUT 1', 'code' => 'RRO1', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'outter', 'styles' => 'top:100px;left:195px'],
            ['id' => 7, 'name' => 'REAR LEFT OUT 2', 'code' => 'RLO2', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'outter', 'styles' => 'top:200px;left:0px'],
            ['id' => 8, 'name' => 'REAR LEFT IN 2', 'code' => 'RLI2', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'inner', 'styles' => 'top:200px;left:45px'],
            ['id' => 9, 'name' => 'REAR RIGHT IN 2', 'code' => 'RRI2', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'inner', 'styles' => 'top:200px;left:150px'],
            ['id' => 10, 'name' => 'REAR RIGHT OUT 2', 'code' => 'RRO2', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'outter', 'styles' => 'top:200px;left:195px'],
            ['id' => 11, 'name' => 'TRAILER REAR LEFT OUT 1', 'code' => 'TLO1', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'outter', 'styles' => 'top:350px;left:0px'],
            ['id' => 12, 'name' => 'TRAILER REAR LEFT IN 1', 'code' => 'TLI1', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'inner', 'styles' => 'top:350px;left:45px'],
            ['id' => 13, 'name' => 'TRAILER REAR RIGHT IN 1', 'code' => 'TRI1', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'inner', 'styles' => 'top:350px;left:150px'],
            ['id' => 14, 'name' => 'TRAILER REAR RIGHT OUT 1', 'code' => 'TRO1', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'outter', 'styles' => 'top:350px;left:195px'],
            ['id' => 15, 'name' => 'TRAILER REAR LEFT OUT 2', 'code' => 'TLO2', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'outter', 'styles' => 'top:450px;left:0px'],
            ['id' => 16, 'name' => 'TRAILER REAR LEFT IN 2', 'code' => 'TLI2', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'inner', 'styles' => 'top:450px;left:45px'],
            ['id' => 17, 'name' => 'TRAILER REAR RIGHT IN 2', 'code' => 'TRI2', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'inner', 'styles' => 'top:450px;left:150px'],
            ['id' => 18, 'name' => 'TRAILER REAR RIGHT OUT 2', 'code' => 'TRO2', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'outter', 'styles' => 'top:450px;left:195px'],
            ['id' => 19, 'name' => 'TRAILER REAR LEFT OUT 3', 'code' => 'TLO3', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'outter', 'styles' => 'top:550px;left:0px'],
            ['id' => 20, 'name' => 'TRAILER REAR LEFT IN 3', 'code' => 'TLI3', 'left_right' => 'left', 'front_rear' => 'rear', 'inner_outter ' => 'inner', 'styles' => 'top:550px;left:45px'],
            ['id' => 21, 'name' => 'TRAILER REAR RIGHT IN 3', 'code' => 'TRI3', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'inner', 'styles' => 'top:550px;left:150px'],
            ['id' => 22, 'name' => 'TRAILER REAR RIGHT OUT 3', 'code' => 'TRO3', 'left_right' => 'right', 'front_rear' => 'rear', 'inner_outter ' => 'outter', 'styles' => 'top:550px;left:195px'],
        ];
        $this->db->table('tire_positions')->insertBatch($data);
    }
}
