<?php

namespace App\Controllers;

use App\Models\m_tire_brand;

class Tire_brand extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $tire_brands;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "tire_brands";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->tire_brands =  new m_tire_brand();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Tire Brands";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($tire_brands = $this->tire_brands->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->tire_brands->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["tire_brands"] = $tire_brands;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tire_brands/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $tire_brand = [
                "name"          => @$_POST["name"],
            ];
            $tire_brand = $tire_brand + $this->created_values() + $this->updated_values();
            if ($this->tire_brands->save($tire_brand))
                $this->session->setFlashdata("flash_message", ["success", "Success adding Tire brand"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding Tire brand"]);
            return redirect()->to(base_url() . '/tire_brands');
        }

        $data["__modulename"] = "Add Tire Brand";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tire_brands/v_edit');
        echo view('v_footer');
        echo view('tire_brands/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $tire_brand = [
                "name"          => @$_POST["name"],
            ];
            $tire_brand = $tire_brand + $this->updated_values();
            if ($this->tire_brands->update($id, $tire_brand))
                $this->session->setFlashdata("flash_message", ["success", "Success editing tire brand"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing tire brand"]);
            return redirect()->to(base_url() . '/tire_brands');
        }

        $data["__modulename"] = "Edit Tire Brand";
        $data["tire_brand"] = $this->tire_brands->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tire_brands/v_edit');
        echo view('v_footer');
        echo view('tire_brands/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->tire_brands->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting tire brand"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting tire brand"]);
        return redirect()->to(base_url() . '/tire_brands');
    }
}
