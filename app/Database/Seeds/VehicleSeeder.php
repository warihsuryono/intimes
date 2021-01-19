<?php

namespace App\Database\Seeds;

class VehicleSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            ['registration_plate' => 'B 9001 EEH',   'vehicle_type_id'  => '5',    'vehicle_brand_id'  =>  '2',    'model'  =>  'DC013',    'body_no'  =>  'D71'],
            ['registration_plate' => 'B 9054 YET',   'vehicle_type_id'  => '2',    'vehicle_brand_id'  =>  '2',    'model'  =>  'DUTRO',    'body_no'  =>  'D254'],
        ];
        $this->db->table('vehicles')->insertBatch($data);
    }
}
