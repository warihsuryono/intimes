<?php

namespace App\Controllers;

use App\Models\m_flap_brand;

class Flap_brand extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $flap_brands;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "flap_brands";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->flap_brands =  new m_flap_brand();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Flap brands";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($flap_brands = $this->flap_brands->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->flap_brands->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["flap_brands"] = $flap_brands;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('flap_brands/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $flap_brand = [
                "name" => @$_POST["name"],
            ];
            $flap_brand = $flap_brand + $this->created_values() + $this->updated_values();
            if ($this->flap_brands->save($flap_brand))
                $this->session->setFlashdata("flash_message", ["success", "Success adding flap brand"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding flap brand"]);
            return redirect()->to(base_url() . '/flap_brands');
        }

        $data["__modulename"] = "Add Flap brand";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('flap_brands/v_edit');
        echo view('v_footer');
        echo view('flap_brands/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $flap_brand = [
                "name" => @$_POST["name"],
            ];
            $flap_brand = $flap_brand + $this->updated_values();
            if ($this->flap_brands->update($id, $flap_brand))
                $this->session->setFlashdata("flash_message", ["success", "Success editing flap brand"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing flap brand"]);
            return redirect()->to(base_url() . '/flap_brands');
        }

        $data["__modulename"] = "Edit Flap brand";
        $data["flap_brand"] = $this->flap_brands->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('flap_brands/v_edit');
        echo view('v_footer');
        echo view('flap_brands/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->flap_brands->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting flap brand"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting flap brand"]);
        return redirect()->to(base_url() . '/flap_brands');
    }
}
