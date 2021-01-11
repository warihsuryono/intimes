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

        $data = [
            ['id' => '1',   'seqno'  => '1',    'parent_id'  =>  '0',    'name'  =>  'Home',    'url'  =>  '',   'icon'  =>  'fas fa-home'],
            ['id' => '2',   'seqno'  => '2',    'parent_id'  =>  '0',    'name'  =>  'Master',    'url'  =>  '#',   'icon'  =>  'fa fa-database'],
            ['id' => '3',   'seqno'  => '3',    'parent_id'  =>  '0',    'name'  =>  'Process',    'url'  =>  '#',   'icon'  =>  'fas fa-project-diagram'],
            ['id' => '4',   'seqno'  => '4',    'parent_id'  =>  '0',    'name'  =>  'Reports',    'url'  =>  '#',   'icon'  =>  'fas fa-chart-line'],
            ['id' => '5',   'seqno'  => '5',    'parent_id'  =>  '0',    'name'  =>  'General',    'url'  =>  '#',   'icon'  =>  'fas fa-bookmark'],
        ];
        $this->db->table('a_menu')->insertBatch($data);

        $data = [
            ['seqno'  => '1',    'parent_id'  =>  '2',    'name'  =>  'Customer',    'url'  =>  'customers',   'icon'  =>  'far fa-address-book'],
            ['seqno'  => '2',    'parent_id'  =>  '2',    'name'  =>  'Tire Size',    'url'  =>  'tire_sizes',   'icon'  =>  'fas fa-ruler-horizontal'],
            ['seqno'  => '3',    'parent_id'  =>  '2',    'name'  =>  'Tire Brand',    'url'  =>  'tire_brands',   'icon'  =>  'fa fa-copyright'],
            ['seqno'  => '4',    'parent_id'  =>  '2',    'name'  =>  'Tire Type',    'url'  =>  'tire_types',   'icon'  =>  'fa fa-list-alt'],
            ['seqno'  => '5',    'parent_id'  =>  '2',    'name'  =>  'Tires',    'url'  =>  'tires',   'icon'  =>  'far fa-life-ring'],
            ['seqno'  => '6',    'parent_id'  =>  '2',    'name'  =>  'Vehicle Brand',    'url'  =>  'vehicle_brands',   'icon'  =>  'fas fa-car'],
            ['seqno'  => '7',    'parent_id'  =>  '2',    'name'  =>  'Vehicle Type',    'url'  =>  'vehicle_types',   'icon'  =>  'fas fa-shuttle-van'],
            ['seqno'  => '8',    'parent_id'  =>  '2',    'name'  =>  'Vehicles',    'url'  =>  'vehicles',   'icon'  =>  'fas fa-truck'],
            ['seqno'  => '1',    'parent_id'  =>  '3',    'name'  =>  'QR Code',    'url'  =>  'qrcode',   'icon'  =>  'fa fa-barcode'],
            ['seqno'  => '2',    'parent_id'  =>  '3',    'name'  =>  'Pemasangan',    'url'  =>  'installations',   'icon'  =>  'fa fa-download'],
            ['seqno'  => '3',    'parent_id'  =>  '3',    'name'  =>  'Pengecekan',    'url'  =>  'checkings',   'icon'  =>  'fa fa-check'],
            ['seqno'  => '4',    'parent_id'  =>  '3',    'name'  =>  'Klaim',    'url'  =>  'claims',   'icon'  =>  'fas fa-sync'],
            ['seqno'  => '1',    'parent_id'  =>  '5',    'name'  =>  'Change Password',    'url'  =>  'changepassword',   'icon'  =>  'fas fa-key'],
            ['seqno'  => '2',    'parent_id'  =>  '5',    'name'  =>  'Profile',    'url'  =>  'user/profile',   'icon'  =>  'far fa-user-circle'],
        ];
        $this->db->table('a_menu')->insertBatch($data);
    }
}
