<?php

namespace App\Database\Seeds;

class s_20210309_tire_brands extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->db->query("TRUNCATE tire_brands");
        $data = [
            ['name' => 'BRIDGESTONE'],
            ['name' => 'HANKOOK'],
            ['name' => 'GAJAH TUNGGAL'],
            ['name' => 'GOODYEAR'],
            ['name' => 'DUNLOP'],
            ['name' => 'MICHELIN'],
            ['name' => 'ARCHILES'],
            ['name' => 'AEOLUS'],
            ['name' => 'MRF'],
            ['name' => 'CEAT'],
            ['name' => 'KAIZEN'],
            ['name' => 'JK TIRE'],
            ['name' => 'BIRLA'],
            ['name' => 'PIRELLI'],
            ['name' => 'YOKOHAMA'],
            ['name' => 'TOLEDO'],
            ['name' => 'CHAOYANG'],
            ['name' => 'WESTLAKE'],
            ['name' => 'HUNG A'],
            ['name' => 'TIRON'],
            ['name' => 'METRO TIRE'],
            ['name' => 'ALL MAKES TIRE'],
            ['name' => 'ASCENDO'],
            ['name' => 'AULICE'],
            ['name' => 'LINGLONG'],
            ['name' => 'CHANGFENG'],
            ['name' => 'SINO TIRE'],
            ['name' => 'HEUNGLI TIRE'],
            ['name' => 'TVS'],
        ];
        $this->db->table('tire_brands')->insertBatch($data);
    }
}
