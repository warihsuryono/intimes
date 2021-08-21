<?php

namespace App\Controllers;

use App\Models\m_customer;
use App\Models\m_mounting;
use App\Models\m_demounting;
use App\Models\m_mounting_detail;
use App\Models\m_demounting_detail;
use App\Models\m_vehicle;
use App\Models\m_vehicle_brand;
use App\Models\m_vehicle_type;


class Report extends BaseController
{
    protected $menu_ids;
    protected $mountings;
    protected $demountings;
    protected $mounting_details;
    protected $demounting_details;
    protected $vehicles;
    protected $vehicle_types;
    protected $vehicle_brands;
    protected $customers;

    public function __construct()
    {
        parent::__construct();
        $this->mountings =  new m_mounting();
        $this->demountings =  new m_demounting();
        $this->mounting_details =  new m_mounting_detail();
        $this->demounting_details =  new m_demounting_detail();
        $this->vehicles =  new m_vehicle();
        $this->vehicle_types =  new m_vehicle_type();
        $this->vehicle_brands =  new m_vehicle_brand();
        $this->customers =  new m_customer();
    }

    public function Mounting_demounting()
    {
        $data["__modulename"] = "Mountings";
        $this->privilege_check($this->get_menu_ids("mounting_demounting"));
        $data += $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        // echo view('reports/mounting_demounting');
        echo view('v_footer');
    }
}
