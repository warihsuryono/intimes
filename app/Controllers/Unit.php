<?php

namespace App\Controllers;

use App\Models\m_unit;

class Unit extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $units;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "units";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->units =  new m_unit();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "units";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($units = $this->units->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->units->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["units"] = $units;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('units/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $unit = [
                "name" => @$_POST["name"],
            ];
            $unit = $unit + $this->created_values() + $this->updated_values();
            if ($this->units->save($unit))
                $this->session->setFlashdata("flash_message", ["success", "Success adding unit"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding unit"]);
            return redirect()->to(base_url() . '/units');
        }

        $data["__modulename"] = "Add unit";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('units/v_edit');
        echo view('v_footer');
        echo view('units/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $unit = [
                "name" => @$_POST["name"],
            ];
            $unit = $unit + $this->updated_values();
            if ($this->units->update($id, $unit))
                $this->session->setFlashdata("flash_message", ["success", "Success editing unit"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing unit"]);
            return redirect()->to(base_url() . '/units');
        }

        $data["__modulename"] = "Edit unit";
        $data["unit"] = $this->units->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('units/v_edit');
        echo view('v_footer');
        echo view('units/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->units->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting unit"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting unit"]);
        return redirect()->to(base_url() . '/units');
    }
}
