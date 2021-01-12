<?php

namespace App\Controllers;

use App\Models\m_tire_type;

class Tire_type extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $tire_types;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "tire_types";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->tire_types =  new m_tire_type();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Tire Types";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($tire_types = $this->tire_types->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->tire_types->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["tire_types"] = $tire_types;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tire_types/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $tire_type = [
                "name"          => @$_POST["name"],
            ];
            $tire_type = $tire_type + $this->created_values() + $this->updated_values();
            if ($this->tire_types->save($tire_type))
                $this->session->setFlashdata("flash_message", ["success", "Success adding Tire type"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding Tire type"]);
            return redirect()->to(base_url() . '/tire_types');
        }

        $data["__modulename"] = "Add Tire Type";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tire_types/v_edit');
        echo view('v_footer');
        echo view('tire_types/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $tire_type = [
                "name"          => @$_POST["name"],
            ];
            $tire_type = $tire_type + $this->updated_values();
            if ($this->tire_types->update($id, $tire_type))
                $this->session->setFlashdata("flash_message", ["success", "Success editing tire type"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing tire type"]);
            return redirect()->to(base_url() . '/tire_types');
        }

        $data["__modulename"] = "Edit Tire Type";
        $data["tire_type"] = $this->tire_types->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tire_types/v_edit');
        echo view('v_footer');
        echo view('tire_types/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->tire_types->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting tire type"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting tire type"]);
        return redirect()->to(base_url() . '/tire_types');
    }
}
