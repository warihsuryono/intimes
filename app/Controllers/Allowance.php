<?php

namespace App\Controllers;

use App\Models\m_allowance;

class Allowance extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $allowances;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "allowances";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->allowances =  new m_allowance();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Allowances";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($allowances = $this->allowances->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->allowances->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["allowances"] = $allowances;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('allowances/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $allowance = [
                "name" => @$_POST["name"],
                "description" => @$_POST["description"],
            ];
            $allowance = $allowance + $this->created_values() + $this->updated_values();
            if ($this->allowances->save($allowance))
                $this->session->setFlashdata("flash_message", ["success", "Success adding allowance"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding allowance"]);
            return redirect()->to(base_url() . '/allowances');
        }

        $data["__modulename"] = "Add Allowance";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('allowances/v_edit');
        echo view('v_footer');
        echo view('allowances/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $allowance = [
                "name" => @$_POST["name"],
                "description" => @$_POST["description"],
            ];
            $allowance = $allowance + $this->updated_values();
            if ($this->allowances->update($id, $allowance))
                $this->session->setFlashdata("flash_message", ["success", "Success editing allowance"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing allowance"]);
            return redirect()->to(base_url() . '/allowances');
        }

        $data["__modulename"] = "Edit Allowance";
        $data["allowance"] = $this->allowances->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('allowances/v_edit');
        echo view('v_footer');
        echo view('allowances/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->allowances->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting allowance"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting allowance"]);
        return redirect()->to(base_url() . '/allowances');
    }
}
