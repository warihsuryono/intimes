<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class seedall extends Seeder
{
    public function run()
    {
        $this->call('s_20210218_menu');
        $this->call('s_20210309_tire_brands');
        $this->call('s_20210309_flap_brands');
        $this->call('s_20210309_tube_brands');
        $this->call('s_20210309_tire_sizes');
        $this->call('s_20210309_tire_positions');
    }
}
