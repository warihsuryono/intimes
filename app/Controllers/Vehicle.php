<?php

namespace App\Controllers;

use App\Models\m_customer;
use App\Models\m_tire_position;
use App\Models\m_vehicle;
use App\Models\m_vehicle_brand;
use App\Models\m_vehicle_type;

class Vehicle extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $vehicles;
    protected $vehicle_brands;
    protected $vehicle_types;
    protected $tire_positions;
    protected $customers;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "vehicles";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->vehicles =  new m_vehicle();
        $this->vehicle_brands =  new m_vehicle_brand();
        $this->vehicle_types =  new m_vehicle_type();
        $this->tire_positions =  new m_tire_position();
        $this->customers =  new m_customer();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Vehicle";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["registration_plate"]) && $_GET["registration_plate"] != "")
            $wherclause .= "AND registration_plate LIKE '%" . $_GET["registration_plate"] . "%'";

        if (isset($_GET["vehicle_type_id"]) && $_GET["vehicle_type_id"] != "")
            $wherclause .= "AND vehicle_type_id = '" . $_GET["vehicle_type_id"] . "'";

        if (isset($_GET["vehicle_brand_id"]) && $_GET["vehicle_brand_id"] != "")
            $wherclause .= "AND vehicle_brand_id = '" . $_GET["vehicle_brand_id"] . "'";

        if (isset($_GET["model"]) && $_GET["model"] != "")
            $wherclause .= "AND model LIKE '%" . $_GET["model"] . "%'";

        if (isset($_GET["body_no"]) && $_GET["body_no"] != "")
            $wherclause .= "AND body_no LIKE '%" . $_GET["body_no"] . "%'";

        if ($vehicles = $this->vehicles->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->vehicles->where($wherclause)->findAll());
            foreach ($vehicles as $vehicle) {
                $vehicle_detail[$vehicle->id]["vehicle_brand"] = @$this->vehicle_brands->where("id", $vehicle->vehicle_brand_id)->findAll()[0];
                $vehicle_detail[$vehicle->id]["vehicle_type"] = @$this->vehicle_types->where("id", $vehicle->vehicle_type_id)->findAll()[0];
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["vehicle_brands"] = $this->vehicle_brands->where("is_deleted", 0)->findAll();
        $data["vehicle_types"] = $this->vehicle_types->where("is_deleted", 0)->findAll();
        $data["vehicles"] = $vehicles;
        $data["vehicle_detail"] = @$vehicle_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('vehicles/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $vehicle = [
                "customer_id"          => @$_POST["customer_id"],
                "customer_name"        => @$_POST["customer_name"],
                "registration_plate"   => @$_POST["registration_plate"],
                "vehicle_type_id"      => @$_POST["vehicle_type_id"],
                "vehicle_brand_id "    => @$_POST["vehicle_brand_id"],
                "model"                => @$_POST["model"],
                "body_no"              => @$_POST["body_no"],
            ];
            $vehicle = $vehicle + $this->created_values() + $this->updated_values();
            if ($this->vehicles->save($vehicle))
                $this->session->setFlashdata("flash_message", ["success", "Success adding Vehicle Size"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding Vehicle Size"]);
            return redirect()->to(base_url() . '/vehicles');
        }

        $data["__modulename"] = "Add Vehicle";
        $data["__mode"] = "add";
        $data["vehicle_brands"] = $this->vehicle_brands->where("is_deleted", 0)->findAll();
        $data["vehicle_types"] = $this->vehicle_types->where("is_deleted", 0)->findAll();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('vehicles/v_edit');
        echo view('v_footer');
        echo view('vehicles/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $vehicle = [
                "customer_id"          => @$_POST["customer_id"],
                "customer_name"        => @$_POST["customer_name"],
                "registration_plate"   => @$_POST["registration_plate"],
                "vehicle_type_id"      => @$_POST["vehicle_type_id"],
                "vehicle_brand_id "    => @$_POST["vehicle_brand_id"],
                "model"                => @$_POST["model"],
                "body_no"              => @$_POST["body_no"],
            ];
            $vehicle = $vehicle + $this->updated_values();
            if ($this->vehicles->update($id, $vehicle))
                $this->session->setFlashdata("flash_message", ["success", "Success editing vehicle size"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing vehicle size"]);
            return redirect()->to(base_url() . '/vehicles');
        }

        $data["__modulename"] = "Edit Vehicle";
        $data["__mode"] = "edit";
        $data["vehicle_brands"] = $this->vehicle_brands->where("is_deleted", 0)->findAll();
        $data["vehicle_types"] = $this->vehicle_types->where("is_deleted", 0)->findAll();
        $data["vehicle"] = $this->vehicles->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('vehicles/v_edit');
        echo view('v_footer');
        echo view('vehicles/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->vehicles->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting vehicle size"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting vehicle size"]);
        return redirect()->to(base_url() . '/vehicles');
    }

    public function get_item($id)
    {
        return json_encode($this->vehicles->where("is_deleted", 0)->find([$id]));
    }

    public function subwindow()
    {
        $wherclause = "is_deleted = '0'";

        if (isset($_GET["keyword"]) && $_GET["keyword"] != "") {
            $wherclause .= "AND (registration_plate LIKE '%" . $_GET["keyword"] . "%'";
            $wherclause .= "OR model LIKE '%" . $_GET["keyword"] . "%')";
        }

        if ($vehicles = $this->vehicles->where($wherclause)->findAll(LIMIT_SUBWINDOW, 0)) {
            foreach ($vehicles as $vehicle) {
                $vehicle_detail[$vehicle->id]["vehicle_brand"] = @$this->vehicle_brands->where("id", $vehicle->vehicle_brand_id)->findAll()[0];
                $vehicle_detail[$vehicle->id]["vehicle_type"] = @$this->vehicle_types->where("id", $vehicle->vehicle_type_id)->findAll()[0];
            }
        }

        $data["vehicles"]       = $vehicles;
        $data["vehicle_detail"] = @$vehicle_detail;
        $data                   = $data + $this->common();
        echo view('vehicles/v_subwindow', $data);
    }

    public function get_customer($vehicle_id)
    {
        $vehicle = @$this->vehicles->where(["is_deleted" => 0, "id" => $vehicle_id])->findAll()[0];
        return json_encode(@$this->customers->where(["is_deleted" => 0, "id" => $vehicle->customer_id])->findAll()[0]);
    }

    public function get_tires_map($vehicle_id)
    {
        $vehicle = @$this->vehicles->where(["is_deleted" => 0, "id" => $vehicle_id])->findAll()[0];
        $customer = @$this->customers->where(["is_deleted" => 0, "id" => $vehicle->customer_id])->findAll()[0];
        $vehicle_type = @$this->vehicle_types->where(["is_deleted" => 0, "id" => @$vehicle->vehicle_type_id])->findAll()[0];
        if (@$vehicle_type->tire_position_ids != "") {
            $tire_positions = @$this->tire_positions->where("is_deleted", 0)->where("id IN (" . @$vehicle_type->tire_position_ids . ")")->findAll();
            $tires_map = "";
            if (isset($tire_positions)) {
                $tire_position_ids = [];
                $tires_map = "
                    <style>
                        .btn-tire {
                            position: absolute;
                            height: 70px;
                            width: 40px;
                        }
                    </style>";

                foreach ($tire_positions as $tire_position) {
                    $tires_map .= "<div class='btn btn-info btn-tire' id=\"tires_map_" . $tire_position->id . "\" style='" . $tire_position->styles . "' onclick=\"tire_position_clicked('" . $tire_position->id . "');\"></div>";
                    $tire_position_ids[] = $tire_position->id;
                }
                if (in_array(1, $tire_position_ids) || in_array(2, $tire_position_ids)) {
                    $tires_map .= "<div class='btn-info' style='position:absolute;width:65px;height:3px;top:32px;left:85px;'></div>";
                    $tiresrow = 1;
                }
                if (in_array(3, $tire_position_ids) || in_array(4, $tire_position_ids) || in_array(5, $tire_position_ids) || in_array(6, $tire_position_ids)) {
                    $tires_map .= "<div class='btn-info' style='position:absolute;width:65px;height:3px;top:132px;left:85px;'></div>";
                    $tiresrow = 2;
                }
                if (in_array(7, $tire_position_ids) || in_array(8, $tire_position_ids) || in_array(9, $tire_position_ids) || in_array(10, $tire_position_ids)) {
                    $tires_map .= "<div class='btn-info' style='position:absolute;width:65px;height:3px;top:232px;left:85px;'></div>";
                    $tiresrow = 3;
                }
                if (in_array(11, $tire_position_ids) || in_array(12, $tire_position_ids) || in_array(13, $tire_position_ids) || in_array(14, $tire_position_ids)) {
                    $tires_map .= "<div class='btn-info' style='position:absolute;width:65px;height:3px;top:382px;left:85px;'></div>";
                    $tiresrow = 4;
                }
                if (in_array(15, $tire_position_ids) || in_array(16, $tire_position_ids) || in_array(17, $tire_position_ids) || in_array(18, $tire_position_ids)) {
                    $tires_map .= "<div class='btn-info' style='position:absolute;width:65px;height:3px;top:482px;left:85px;'></div>";
                    $tiresrow = 5;
                }
                if (in_array(19, $tire_position_ids) || in_array(20, $tire_position_ids) || in_array(21, $tire_position_ids) || in_array(22, $tire_position_ids)) {
                    $tires_map .= "<div class='btn-info' style='position:absolute;width:65px;height:3px;top:582px;left:85px;'></div>";
                    $tiresrow = 6;
                }
                $tires_map .= "<input type='hidden' id='tiresrow' value='" . $tiresrow . "'>";
                $tires_map .= "<input type='hidden' id='vehicle_type_name' value='" . $vehicle_type->name . "'>";
                $tires_map .= "<input type='hidden' id='customer_company_name' value='" . @$customer->company_name . "'>";
            }
        }
        return $tires_map;
    }
}
