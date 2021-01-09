<?php

namespace App\Controllers;

use App\Models\m_item_specification;

class Item_specification extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $item_specifications;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "item_specifications";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->item_specifications =  new m_item_specification();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Item specifications";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($item_specifications = $this->item_specifications->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->item_specifications->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["item_specifications"] = $item_specifications;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_specifications/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $item_specification = [
                "name" => @$_POST["name"],
            ];
            $item_specification = $item_specification + $this->created_values() + $this->updated_values();
            if ($this->item_specifications->save($item_specification))
                $this->session->setFlashdata("flash_message", ["success", "Success adding item specification"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding item specification"]);
            return redirect()->to(base_url() . '/item_specifications');
        }

        $data["__modulename"] = "Add Item specification";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_specifications/v_edit');
        echo view('v_footer');
        echo view('item_specifications/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $item_specification = [
                "name" => @$_POST["name"],
            ];
            $item_specification = $item_specification + $this->updated_values();
            if ($this->item_specifications->update($id, $item_specification))
                $this->session->setFlashdata("flash_message", ["success", "Success editing item specification"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing item specification"]);
            return redirect()->to(base_url() . '/item_specifications');
        }

        $data["__modulename"] = "Edit Item specification";
        $data["item_specification"] = $this->item_specifications->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_specifications/v_edit');
        echo view('v_footer');
        echo view('item_specifications/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->item_specifications->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting item specification"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting item specification"]);
        return redirect()->to(base_url() . '/item_specifications');
    }
}
