<?php

namespace App\Controllers;

use App\Models\m_tube_brand;

class Tube_brand extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $tube_brands;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "tube_brands";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->tube_brands =  new m_tube_brand();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Tube brands";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($tube_brands = $this->tube_brands->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->tube_brands->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["tube_brands"] = $tube_brands;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tube_brands/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $tube_brand = [
                "name" => @$_POST["name"],
            ];
            $tube_brand = $tube_brand + $this->created_values() + $this->updated_values();
            if ($this->tube_brands->save($tube_brand))
                $this->session->setFlashdata("flash_message", ["success", "Success adding tube brand"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding tube brand"]);
            return redirect()->to(base_url() . '/tube_brands');
        }

        $data["__modulename"] = "Add Tube brand";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tube_brands/v_edit');
        echo view('v_footer');
        echo view('tube_brands/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $tube_brand = [
                "name" => @$_POST["name"],
            ];
            $tube_brand = $tube_brand + $this->updated_values();
            if ($this->tube_brands->update($id, $tube_brand))
                $this->session->setFlashdata("flash_message", ["success", "Success editing tube brand"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing tube brand"]);
            return redirect()->to(base_url() . '/tube_brands');
        }

        $data["__modulename"] = "Edit Tube brand";
        $data["tube_brand"] = $this->tube_brands->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tube_brands/v_edit');
        echo view('v_footer');
        echo view('tube_brands/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->tube_brands->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting tube brand"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting tube brand"]);
        return redirect()->to(base_url() . '/tube_brands');
    }
}
