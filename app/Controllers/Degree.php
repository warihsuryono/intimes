<?php

namespace App\Controllers;

use App\Models\m_degree;

class Degree extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $degrees;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "degrees";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->degrees =  new m_degree();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Degrees";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($degrees = $this->degrees->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->degrees->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["degrees"] = $degrees;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('degrees/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $degree = [
                "name" => @$_POST["name"],
            ];
            $degree = $degree + $this->created_values() + $this->updated_values();
            if ($this->degrees->save($degree))
                $this->session->setFlashdata("flash_message", ["success", "Success adding degree"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding degree"]);
            return redirect()->to(base_url() . '/degrees');
        }

        $data["__modulename"] = "Add Degree";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('degrees/v_edit');
        echo view('v_footer');
        echo view('degrees/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $degree = [
                "name" => @$_POST["name"],
            ];
            $degree = $degree + $this->updated_values();
            if ($this->degrees->update($id, $degree))
                $this->session->setFlashdata("flash_message", ["success", "Success editing degree"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing degree"]);
            return redirect()->to(base_url() . '/degrees');
        }

        $data["__modulename"] = "Edit Degree";
        $data["degree"] = $this->degrees->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('degrees/v_edit');
        echo view('v_footer');
        echo view('degrees/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->degrees->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting degree"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting degree"]);
        return redirect()->to(base_url() . '/degrees');
    }
}
