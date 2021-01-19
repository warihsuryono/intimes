<?php

namespace App\Controllers;

use App\Models\m_tire_pattern;

class Tire_pattern extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $tire_patterns;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "tire_patterns";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->tire_patterns =  new m_tire_pattern();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Tire Patterns";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($tire_patterns = $this->tire_patterns->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->tire_patterns->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["tire_patterns"] = $tire_patterns;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tire_patterns/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $tire_pattern = [
                "name"          => @$_POST["name"],
            ];
            $tire_pattern = $tire_pattern + $this->created_values() + $this->updated_values();
            if ($this->tire_patterns->save($tire_pattern))
                $this->session->setFlashdata("flash_message", ["success", "Success adding Tire Pattern"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding Tire Pattern"]);
            return redirect()->to(base_url() . '/tire_patterns');
        }

        $data["__modulename"] = "Add Tire Pattern";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tire_patterns/v_edit');
        echo view('v_footer');
        echo view('tire_patterns/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $tire_pattern = [
                "name"          => @$_POST["name"],
            ];
            $tire_pattern = $tire_pattern + $this->updated_values();
            if ($this->tire_patterns->update($id, $tire_pattern))
                $this->session->setFlashdata("flash_message", ["success", "Success editing tire Pattern"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing tire Pattern"]);
            return redirect()->to(base_url() . '/tire_patterns');
        }

        $data["__modulename"] = "Edit Tire Pattern";
        $data["tire_pattern"] = $this->tire_patterns->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tire_patterns/v_edit');
        echo view('v_footer');
        echo view('tire_patterns/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->tire_patterns->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting tire pattern"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting tire pattern"]);
        return redirect()->to(base_url() . '/tire_patterns');
    }
}
