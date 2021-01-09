<?php

namespace App\Controllers;

use App\Models\m_item_brand;

class Item_brand extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $item_brands;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "item_brands";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->item_brands =  new m_item_brand();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Item brands";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($item_brands = $this->item_brands->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->item_brands->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["item_brands"] = $item_brands;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_brands/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $item_brand = [
                "name" => @$_POST["name"],
            ];
            $item_brand = $item_brand + $this->created_values() + $this->updated_values();
            if ($this->item_brands->save($item_brand))
                $this->session->setFlashdata("flash_message", ["success", "Success adding item brand"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding item brand"]);
            return redirect()->to(base_url() . '/item_brands');
        }

        $data["__modulename"] = "Add Item brand";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_brands/v_edit');
        echo view('v_footer');
        echo view('item_brands/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $item_brand = [
                "name" => @$_POST["name"],
            ];
            $item_brand = $item_brand + $this->updated_values();
            if ($this->item_brands->update($id, $item_brand))
                $this->session->setFlashdata("flash_message", ["success", "Success editing item brand"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing item brand"]);
            return redirect()->to(base_url() . '/item_brands');
        }

        $data["__modulename"] = "Edit Item brand";
        $data["item_brand"] = $this->item_brands->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_brands/v_edit');
        echo view('v_footer');
        echo view('item_brands/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->item_brands->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting item brand"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting item brand"]);
        return redirect()->to(base_url() . '/item_brands');
    }
}
