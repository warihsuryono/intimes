<?php

namespace App\Controllers;

use App\Models\m_tire_position;
use App\Models\m_vehicle_type;

class Vehicle_type extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $vehicle_types;
    protected $tire_positions;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "vehicle_types";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->vehicle_types =  new m_vehicle_type();
        $this->tire_positions =  new m_tire_position();
    }

    public function get_reference_data()
    {
        $data["tire_positions"] = $this->tire_positions->where(["is_deleted" => 0])->findAll();
        return $data;
    }

    public function get_saved_data($id)
    {
        $data["vehicle_type"] = $this->vehicle_types->where("is_deleted", 0)->find([$id])[0];
        $data["tire_position_ids"] = explode(",", $data["vehicle_type"]->tire_position_ids);
        return $data;
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Vehicle Types";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        $numrow = 0;
        if ($vehicle_types = $this->vehicle_types->where($wherclause)->findAll(MAX_ROW, $startrow))
            $numrow = count($this->vehicle_types->where($wherclause)->findAll());


        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["vehicle_types"] = $vehicle_types;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('vehicle_types/v_list');
        echo view('v_footer');
    }



    public function saving_data()
    {
        $tire_position_ids = "";
        foreach ($_POST["tire_position_id"] as $tire_position_id => $value) {
            $tire_position_ids .= $tire_position_id . ",";
        }

        if ($tire_position_ids != "")
            $tire_position_ids = substr($tire_position_ids, 0, -1);

        return [
            "name"              => @$_POST["name"],
            "tire_position_ids" => $tire_position_ids,
        ];
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $vehicle_type = $this->saving_data() + $this->created_values() + $this->updated_values();
            if ($this->vehicle_types->save($vehicle_type))
                $this->session->setFlashdata("flash_message", ["success", "Success adding Vehicle type"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding Vehicle type"]);
            return redirect()->to(base_url() . '/vehicle_types');
        }

        $data["__modulename"] = "Add Vehicle Type";
        $data["tire_position_ids"] = [];
        $data = $data + $this->get_reference_data() + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('vehicle_types/v_edit');
        echo view('v_footer');
        echo view('vehicle_types/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $vehicle_type = $this->saving_data() + $this->updated_values();
            if ($this->vehicle_types->update($id, $vehicle_type))
                $this->session->setFlashdata("flash_message", ["success", "Success editing vehicle type"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing vehicle type"]);
            return redirect()->to(base_url() . '/vehicle_types');
        }

        $data["__modulename"] = "Edit Vehicle Type";
        $data = $data + $this->get_saved_data($id) + $this->get_reference_data() + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('vehicle_types/v_edit');
        echo view('v_footer');
        echo view('vehicle_types/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->vehicle_types->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting vehicle type"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting vehicle type"]);
        return redirect()->to(base_url() . '/vehicle_types');
    }

    public function get_vehicle_type($id)
    {
        return json_encode($this->vehicle_types->where(["is_deleted" => 0, "id" => $id])->findAll()[0]);
    }
}
