<?php

namespace App\Database\Seeds;

class TireSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            ['qrcode'  => 'QR12345',    'serialno'  =>  'SN12345',    'tire_size_id'  =>  '1',    'tire_brand_id'  =>  '1',   'tire_type_id'  =>  '2', 'tire_pattern_id'  =>  '4',    'tread_depth'  =>  '12',  "psi" => '100'],
            ['qrcode'  => 'QR23456',    'serialno'  =>  'SN23456',    'tire_size_id'  =>  '2',    'tire_brand_id'  =>  '2',   'tire_type_id'  =>  '2', 'tire_pattern_id'  =>  '5',    'tread_depth'  =>  '10',  "psi" => '90'],
            ['qrcode'  => 'QR34567',    'serialno'  =>  'SN34567',    'tire_size_id'  =>  '3',    'tire_brand_id'  =>  '3',   'tire_type_id'  =>  '1', 'tire_pattern_id'  =>  '6',    'tread_depth'  =>  '9',   "psi" => '80'],
            ['qrcode'  => 'QR45678',    'serialno'  =>  'SN45678',    'tire_size_id'  =>  '4',    'tire_brand_id'  =>  '4',   'tire_type_id'  =>  '1', 'tire_pattern_id'  =>  '7',    'tread_depth'  =>  '11',  "psi" => '95'],
            ['qrcode'  => 'QR56789',    'serialno'  =>  'SN56789',    'tire_size_id'  =>  '5',    'tire_brand_id'  =>  '5',   'tire_type_id'  =>  '2', 'tire_pattern_id'  =>  '8',    'tread_depth'  =>  '8',   "psi" => '110'],
        ];
        $this->db->table('tires')->insertBatch($data);
    }
}
