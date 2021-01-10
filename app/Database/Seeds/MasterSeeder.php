<?php

namespace App\Database\Seeds;

class MasterSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            ['name'  => 'Front Left', 'left_right'  =>  'left', 'front_rear '  =>  'front', 'inner_outter'  =>  ''],
            ['name'  => 'Front Right', 'left_right'  =>  'right', 'front_rear '  =>  'front', 'inner_outter'  =>  ''],
            ['name'  => 'Rear Left', 'left_right'  =>  'left', 'front_rear '  =>  'rear', 'inner_outter'  =>  ''],
            ['name'  => 'Rear Right', 'left_right'  =>  'right', 'front_rear '  =>  'rear', 'inner_outter'  =>  ''],
            ['name'  => 'Rear Left Inner', 'left_right'  =>  'left', 'front_rear '  =>  'rear', 'inner_outter'  =>  'inner'],
            ['name'  => 'Rear Right Inner', 'left_right'  =>  'right', 'front_rear '  =>  'rear', 'inner_outter'  =>  'inner'],
            ['name'  => 'Rear Left Outter', 'left_right'  =>  'left', 'front_rear '  =>  'rear', 'inner_outter'  =>  'outter'],
            ['name'  => 'Rear Right Outter', 'left_right'  =>  'right', 'front_rear '  =>  'rear', 'inner_outter'  =>  'outter'],
        ];
        $this->db->table('tire_positions')->insertBatch($data);

        $data = [
            ['name'  => 'CDD'],
            ['name'  => 'CDE'],
        ];
        $this->db->table('vehicle_types')->insertBatch($data);

        $data = [
            ['name'  => 'MITSUBISHI'],
            ['name'  => 'HINO'],
            ['name'  => 'TATA'],
            ['name'  => 'VOLVO'],
            ['name'  => 'UD'],
            ['name'  => 'TOYOTA'],
            ['name'  => 'ISUZU'],
            ['name'  => 'SCANIA'],
            ['name'  => 'MERCEDES BENZ'],
            ['name'  => 'RENAULT']
        ];
        $this->db->table('vehicle_brands')->insertBatch($data);

        $data = [
            ['name'  => '185/60R13',    'diameter'  =>  '21.7',    'width '  =>  '7.3',    'wheel'  =>  '13',   'sidewall'  =>  '4.4', 'circumference'  =>  '68.3',    'revs_mile'  =>  '928'],
            ['name'  => '215/50R13',    'diameter'  =>  '21.5',    'width '  =>  '8.5',    'wheel'  =>  '13',   'sidewall'  =>  '4.2', 'circumference'  =>  '67.4',    'revs_mile'  =>  '940'],
            ['name'  => '225/45R13',    'diameter'  =>  '21.0',    'width '  =>  '8.9',    'wheel'  =>  '13',   'sidewall'  =>  '4.0', 'circumference'  =>  '65.9',    'revs_mile'  =>  '962'],
            ['name'  => '225/50R13',    'diameter'  =>  '21.9',    'width '  =>  '8.9',    'wheel'  =>  '13',   'sidewall'  =>  '4.4', 'circumference'  =>  '68.6',    'revs_mile'  =>  '923'],
            ['name'  => '255/40R13',    'diameter'  =>  '21.0',    'width '  =>  '10.0',   'wheel'  =>  '13',   'sidewall'  =>  '4.0', 'circumference'  =>  '66.0',    'revs_mile'  =>  '959'],
        ];
        $this->db->table('tire_sizes')->insertBatch($data);
    }
}
