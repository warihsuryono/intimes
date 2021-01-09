<?php

namespace App\Controllers;

use App\Models\m_item_category;
use App\Models\m_item_sub_category;

class Item_sub_category extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $item_category;
    protected $item_sub_categories;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "item_sub_categories";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->item_categories =  new m_item_category();
        $this->item_sub_categories =  new m_item_sub_category();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);
        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Item Sub Categories";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if (isset($_GET["item_category_id"]) && $_GET["item_category_id"] != "")
            $wherclause .= "AND item_category_id = '" . $_GET["item_category_id"] . "'";

        if ($item_sub_categories = $this->item_sub_categories->where($wherclause)->findAll(MAX_ROW, $startrow)) {
            $numrow = count($this->item_sub_categories->where($wherclause)->findAll());
            foreach ($item_sub_categories as $item_sub_category) {
                $item_sub_category_detail[$item_sub_category->id]["item_category"] = @$this->item_categories->where("id", $item_sub_category->item_category_id)->get()->getResult()[0]->name;
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["item_categories"] = $this->item_categories->where("is_deleted", 0)->findAll();
        $data["item_sub_categories"] = $item_sub_categories;
        $data["item_sub_category_detail"]    = @$item_sub_category_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_sub_categories/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $item_sub_category = [
                "name" => @$_POST["name"],
                "item_category_id" => @$_POST["item_category_id"],
            ];
            $item_sub_category = $item_sub_category + $this->created_values() + $this->updated_values();
            if ($this->item_sub_categories->save($item_sub_category))
                $this->session->setFlashdata("flash_message", ["success", "Success adding item sub_category"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding item sub_category"]);
            return redirect()->to(base_url() . '/item_sub_categories');
        }

        $data["__modulename"] = "Add Item Sub Category";
        $data["item_categories"]        = $this->item_categories->where("is_deleted", 0)->findAll();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_sub_categories/v_edit');
        echo view('v_footer');
        echo view('item_sub_categories/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $item_sub_category = [
                "name" => @$_POST["name"],
                "item_category_id" => @$_POST["item_category_id"],
            ];
            $item_sub_category = $item_sub_category + $this->updated_values();
            if ($this->item_sub_categories->update($id, $item_sub_category))
                $this->session->setFlashdata("flash_message", ["success", "Success editing item sub_category"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing item sub_category"]);
            return redirect()->to(base_url() . '/item_sub_categories');
        }

        $data["__modulename"] = "Edit Item Sub Category";
        $data["item_categories"]        = $this->item_categories->where("is_deleted", 0)->findAll();
        $data["item_sub_category"] = $this->item_sub_categories->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_sub_categories/v_edit');
        echo view('v_footer');
        echo view('item_sub_categories/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->item_sub_categories->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting item sub_category"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting item sub_category"]);
        return redirect()->to(base_url() . '/item_sub_categories');
    }
}
