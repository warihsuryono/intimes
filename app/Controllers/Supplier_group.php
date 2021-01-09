<?php

namespace App\Controllers;

use App\Models\m_supplier_group;

class Supplier_group extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $supplier_groups;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "supplier_groups";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->supplier_groups =  new m_supplier_group();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Supplier Groups";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($supplier_groups = $this->supplier_groups->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->supplier_groups->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["supplier_groups"] = $supplier_groups;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('supplier_groups/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $supplier_group = [
                "name" => @$_POST["name"],
                "description" => @$_POST["description"],
            ];
            $supplier_group = $supplier_group + $this->created_values() + $this->updated_values();
            if ($this->supplier_groups->save($supplier_group))
                $this->session->setFlashdata("flash_message", ["success", "Success adding supplier group"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding supplier group"]);
            return redirect()->to(base_url() . '/supplier_groups');
        }

        $data["__modulename"] = "Add Supplier Group";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('supplier_groups/v_edit');
        echo view('v_footer');
        echo view('supplier_groups/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $supplier_group = [
                "name" => @$_POST["name"],
                "description" => @$_POST["description"],
            ];
            $supplier_group = $supplier_group + $this->updated_values();
            if ($this->supplier_groups->update($id, $supplier_group))
                $this->session->setFlashdata("flash_message", ["success", "Success editing supplier group"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing supplier group"]);
            return redirect()->to(base_url() . '/supplier_groups');
        }

        $data["__modulename"] = "Edit Supplier Group";
        $data["supplier_group"] = $this->supplier_groups->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('supplier_groups/v_edit');
        echo view('v_footer');
        echo view('supplier_groups/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->supplier_groups->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting supplier group"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting supplier group"]);
        return redirect()->to(base_url() . '/supplier_groups');
    }
}
