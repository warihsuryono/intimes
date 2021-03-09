<?php

namespace App\Database\Seeds;

class s_20210309_tire_sizes extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->db->query("TRUNCATE tire_sizes");
        $data = [
            ['name'  => '185R14'],
            ['name'  => '195R15'],
            ['name'  => '7.50-15'],
            ['name'  => '7.50R15'],
            ['name'  => '7.00-16'],
            ['name'  => '7.50-16'],
            ['name'  => '7.50R16'],
            ['name'  => '8.25-16'],
            ['name'  => '8.25R16'],
            ['name'  => '9.00-20'],
            ['name'  => '9.00R20'],
            ['name'  => '10.00-20'],
            ['name'  => '10.00R20'],
            ['name'  => '11.00-20'],
            ['name'  => '11.00R20'],
            ['name'  => '12.00-20'],
            ['name'  => '12.00R20'],
            ['name'  => '12.00-24'],
            ['name'  => '12.00R24'],
            ['name'  => '13.00-24'],
            ['name'  => '13.00R24'],
            ['name'  => '11R22.5'],
            ['name'  => '295/80R22.5'],
            ['name'  => '315/80R22.5'],
            ['name'  => '275/80R17.5'],
        ];
        $this->db->table('tire_sizes')->insertBatch($data);
    }
}
