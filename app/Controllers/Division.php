<?php

namespace App\Controllers;

use App\Models\m_division;

class Division extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $divisions;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "divisions";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->divisions =  new m_division();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Divisions";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($divisions = $this->divisions->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->divisions->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["divisions"] = $divisions;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('divisions/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $division = [
                "name" => @$_POST["name"],
                "description" => @$_POST["description"],
            ];
            $division = $division + $this->created_values() + $this->updated_values();
            if ($this->divisions->save($division))
                $this->session->setFlashdata("flash_message", ["success", "Success adding division"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding division"]);
            return redirect()->to(base_url() . '/divisions');
        }

        $data["__modulename"] = "Add Division";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('divisions/v_edit');
        echo view('v_footer');
        echo view('divisions/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $division = [
                "name" => @$_POST["name"],
                "description" => @$_POST["description"],
            ];
            $division = $division + $this->updated_values();
            if ($this->divisions->update($id, $division))
                $this->session->setFlashdata("flash_message", ["success", "Success editing division"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing division"]);
            return redirect()->to(base_url() . '/divisions');
        }

        $data["__modulename"] = "Edit Division";
        $data["division"] = $this->divisions->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('divisions/v_edit');
        echo view('v_footer');
        echo view('divisions/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->divisions->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting division"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting division"]);
        return redirect()->to(base_url() . '/divisions');
    }
}
