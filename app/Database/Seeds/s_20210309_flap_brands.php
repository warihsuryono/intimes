<?php

namespace App\Database\Seeds;

class s_20210309_flap_brands extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->db->query("TRUNCATE flap_brands");
        $data = [
            ['name' => 'NAYABANA'],
            ['name' => 'INDOTUBE'],
            ['name' => 'GAJAH TUNGGAL'],
            ['name' => 'BRIDGESTONE'],
            ['name' => 'GOODYEAR'],
            ['name' => 'TIRON'],
            ['name' => 'HUNG A'],
            ['name' => 'IBK'],
            ['name' => 'DGK'],
            ['name' => 'CLEON'],
        ];
        $this->db->table('flap_brands')->insertBatch($data);
    }
}
