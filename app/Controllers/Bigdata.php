<?php

namespace App\Controllers;

use App\Models\m_checking;
use App\Models\m_customer;
use App\Models\m_installation;
use App\Models\m_tire;
use App\Models\m_tire_brand;
use App\Models\m_tire_pattern;
use App\Models\m_tire_position;
use App\Models\m_tire_size;
use App\Models\m_tire_type;
use App\Models\m_vehicle;
use App\Models\m_vehicle_brand;
use App\Models\m_vehicle_type;

class Bigdata extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $customers;
    protected $tire_brands;
    protected $tire_patterns;
    protected $tire_positions;
    protected $tire_sizes;
    protected $tire_types;
    protected $tires;
    protected $vehicle_brands;
    protected $vehicle_types;
    protected $vehicles;
    protected $installations;
    protected $checkings;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "customers";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->customers =  new m_customer();
        $this->tire_brands =  new m_tire_brand();
        $this->tire_patterns =  new m_tire_pattern();
        $this->tire_positions =  new m_tire_position();
        $this->tire_sizes =  new m_tire_size();
        $this->tire_types =  new m_tire_type();
        $this->tires =  new m_tire();
        $this->vehicle_brands =  new m_vehicle_brand();
        $this->vehicle_types =  new m_vehicle_type();
        $this->vehicles =  new m_vehicle();
        $this->installations =  new m_installation();
        $this->checkings =  new m_checking();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);
        $data["__modulename"] = "Big Data";

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["company_name"]) && $_GET["company_name"] != "")
            $wherclause .= " AND company_name LIKE '%" . $_GET["company_name"] . "%'";

        $vehicles = [];
        $installations = [];
        $checkings = [];
        if ($customers = $this->customers->where($wherclause)->findAll()) {
            foreach ($customers as $customer) {
                $vehicles[$customer->id] = $this->vehicles->where(["is_deleted" => 0, "customer_id" => $customer->id])->findAll();
                foreach ($vehicles[$customer->id] as $vehicle) {
                    $vehicle_details[$vehicle->id]["vehicle_type"] = $this->vehicle_types->where(["is_deleted" => 0, "id" => $vehicle->vehicle_type_id])->findAll()[0];
                    $vehicle_details[$vehicle->id]["vehicle_brand"] = $this->vehicle_brands->where(["is_deleted" => 0, "id" => $vehicle->vehicle_brand_id])->findAll()[0];
                    $installations[$customer->id][$vehicle->id] = $this->installations->where(["is_deleted" => 0, "vehicle_id" => $vehicle->id])->findAll();
                    foreach ($installations[$customer->id][$vehicle->id] as $installation) {
                        $tire =  $this->tires->where(["is_deleted" => 0, "id" => $installation->tire_id])->findAll()[0];
                        $installation_details[$installation->id]["tire_position"] = $this->tire_positions->where(["is_deleted" => 0, "id" => $installation->tire_position_id])->findAll()[0];
                        $installation_details[$installation->id]["tire_type"] = $this->tire_types->where(["is_deleted" => 0, "id" => $installation->tire_type_id])->findAll()[0];
                        $installation_details[$installation->id]["tire_size"] = $this->tire_sizes->where(["is_deleted" => 0, "id" => $tire->tire_size_id])->findAll()[0];
                        $installation_details[$installation->id]["tire_brand"] = $this->tire_brands->where(["is_deleted" => 0, "id" => $tire->tire_brand_id])->findAll()[0];
                        $installation_details[$installation->id]["tire_pattern"] = $this->tire_patterns->where(["is_deleted" => 0, "id" => $tire->tire_pattern_id])->findAll()[0];
                        $checkings[$customer->id][$vehicle->id][$installation->id] = $this->checkings->where(["is_deleted" => 0, "installation_id" => $installation->id])->findAll();
                        foreach ($checkings[$customer->id][$vehicle->id][$installation->id] as $checking) {
                            $checking_details[$installation->id]["last_check_km"] = $checking->check_km;
                            $checking_details[$installation->id]["last_check_at"] = $checking->check_at;
                            $checking_details[$installation->id]["last_remain_tread_depth"] = $checking->remain_tread_depth;
                        }
                        $checking_details[$installation->id]["used_ages"] = @$checking_details[$installation->id]["last_check_km"] - $installation->km_install;
                        if (($installation->original_tread_depth - @$checking_details[$installation->id]["last_remain_tread_depth"]) > 0)
                            $checking_details[$installation->id]["estimation_used_ages"] = ($checking_details[$installation->id]["used_ages"] / ($installation->original_tread_depth - @$checking_details[$installation->id]["last_remain_tread_depth"])) * ($installation->original_tread_depth - 2);
                    }
                }
            }
        }

        $data["_this"] =  $this;
        $data["customers"] =  $customers;
        $data["vehicles"] =  $vehicles;
        $data["vehicle_details"] =  $vehicle_details;
        $data["installations"] =  $installations;
        $data["installation_details"] =  $installation_details;
        $data["checkings"] =  $checkings;
        $data["checking_details"] =  $checking_details;
        $data   = $data + $this->common();

        echo view('v_header', $data);
        echo view('v_menu');
        echo view('bigdata/v_list');
        echo view('v_footer');
    }
}
