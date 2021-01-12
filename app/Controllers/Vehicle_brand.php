<?php

namespace App\Controllers;

use App\Models\m_vehicle_brand;

class Vehicle_brand extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $vehicle_brands;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "vehicle_brands";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->vehicle_brands =  new m_vehicle_brand();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Vehicle Brands";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($vehicle_brands = $this->vehicle_brands->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->vehicle_brands->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["vehicle_brands"] = $vehicle_brands;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('vehicle_brands/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $vehicle_brand = [
                "name"          => @$_POST["name"],
            ];
            $vehicle_brand = $vehicle_brand + $this->created_values() + $this->updated_values();
            if ($this->vehicle_brands->save($vehicle_brand))
                $this->session->setFlashdata("flash_message", ["success", "Success adding Vehicle brand"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding Vehicle brand"]);
            return redirect()->to(base_url() . '/vehicle_brands');
        }

        $data["__modulename"] = "Add Vehicle Brand";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('vehicle_brands/v_edit');
        echo view('v_footer');
        echo view('vehicle_brands/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $vehicle_brand = [
                "name"          => @$_POST["name"],
            ];
            $vehicle_brand = $vehicle_brand + $this->updated_values();
            if ($this->vehicle_brands->update($id, $vehicle_brand))
                $this->session->setFlashdata("flash_message", ["success", "Success editing vehicle brand"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing vehicle brand"]);
            return redirect()->to(base_url() . '/vehicle_brands');
        }

        $data["__modulename"] = "Edit Vehicle Brand";
        $data["vehicle_brand"] = $this->vehicle_brands->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('vehicle_brands/v_edit');
        echo view('v_footer');
        echo view('vehicle_brands/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->vehicle_brands->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting vehicle brand"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting vehicle brand"]);
        return redirect()->to(base_url() . '/vehicle_brands');
    }
}
