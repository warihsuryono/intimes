<?php

namespace App\Controllers;

use App\Models\m_item;
use App\Models\m_item_specification;
use App\Models\m_item_category;
use App\Models\m_item_sub_category;
use App\Models\m_item_type;
use App\Models\m_item_brand;
use App\Models\m_item_scope;
use App\Models\m_item_price;
use App\Models\m_unit;

class Item extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $items;
    protected $item_specifications;
    protected $item_categories;
    protected $item_sub_categories;
    protected $item_types;
    protected $item_scope;
    protected $item_brands;
    protected $item_prices;
    protected $units;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "items";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->items =  new m_item();
        $this->item_specifications =  new m_item_specification();
        $this->item_categories =  new m_item_category();
        $this->item_sub_categories =  new m_item_sub_category();
        $this->item_types =  new m_item_type();
        $this->item_scopes =  new m_item_scope();
        $this->item_brands =  new m_item_brand();
        $this->item_prices =  new m_item_price();
        $this->units =  new m_unit();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Items";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["code"]) && $_GET["code"] != "")
            $wherclause .= "AND code LIKE '%" . $_GET["code"] . "%'";

        if (isset($_GET["item_specification_id"]) && $_GET["item_specification_id"] != "")
            $wherclause .= "AND item_specification_id LIKE '%" . $_GET["item_specification_id"] . "%'";

        if (isset($_GET["item_category_id"]) && $_GET["item_category_id"] != "")
            $wherclause .= "AND item_category_id LIKE '%" . $_GET["item_category_id"] . "%'";

        if (isset($_GET["item_sub_category_id"]) && $_GET["item_sub_category_id"] != "")
            $wherclause .= "AND item_sub_category_id LIKE '%" . $_GET["item_sub_category_id"] . "%'";

        if (isset($_GET["item_type_id"]) && $_GET["item_type_id"] != "")
            $wherclause .= "AND item_type_id LIKE '%" . $_GET["item_type_id"] . "%'";

        if (isset($_GET["item_brand_id"]) && $_GET["item_brand_id"] != "")
            $wherclause .= "AND item_brand_id LIKE '%" . $_GET["item_brand_id"] . "%'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($items = $this->items->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->items->where($wherclause)->findAll());

            foreach ($items as $item) {
                $item_detail[$item->id]["item_specification"] = @$this->item_specifications->where("id", $item->item_specification_id)->get()->getResult()[0]->name;
                $item_detail[$item->id]["item_category"] = @$this->item_categories->where("id", $item->item_category_id)->get()->getResult()[0]->name;
                $item_detail[$item->id]["item_sub_category"] = @$this->item_sub_categories->where("id", $item->item_sub_category_id)->get()->getResult()[0]->name;
                $item_detail[$item->id]["item_brand"] = @$this->item_brands->where("id", $item->item_brand_id)->get()->getResult()[0]->name;
                $item_detail[$item->id]["item_type"] = @$this->item_types->where("id", $item->item_type_id)->get()->getResult()[0]->name;
                $item_detail[$item->id]["unit"] = $this->units->where("id", $item->unit_id)->get()->getResult()[0]->name;
                $item_scopes = "";
                foreach (explode("|", $item->item_scope_ids) as $item_scope_id) {
                    if ($item_scope_id != "") {
                        $item_scope = $this->item_scopes->where("id", $item_scope_id)->get()->getResult()[0];
                        $item_scopes .= $item_scope->name . " " . $this->units->where("id", $item_scope->unit_id)->get()->getResult()[0]->name . "; ";
                    }
                }
                $item_detail[$item->id]["item_scopes"] = substr($item_scopes, 0, -2);
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"]       = $startrow;
        $data["numrow"]         = $numrow;
        $data["maxpage"]        = ceil($numrow / MAX_ROW);
        $data["item_specifications"]    = $this->item_specifications->where("is_deleted", 0)->findAll();
        $data["item_categories"]    = $this->item_categories->where("is_deleted", 0)->findAll();
        $data["item_sub_categories"]    = $this->item_sub_categories->where("is_deleted", 0)->findAll();
        $data["item_types"]     = $this->item_types->where("is_deleted", 0)->findAll();
        $data["item_brands"]    = $this->item_brands->where("is_deleted", 0)->findAll();
        $data["items"]          = $items;
        $data["item_detail"]    = @$item_detail;
        $data                   = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('items/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $item_scope_ids = "";
            foreach ($_POST["item_scope_ids"] as $item_scope_id) {
                $item_scope_ids .= "|" . $item_scope_id . "|";
            }
            $item = [
                "code"                  => @$_POST["code"],
                "item_specification_id" => @$_POST["item_specification_id"],
                "item_category_id"      => @$_POST["item_category_id"],
                "item_sub_category_id"  => @$_POST["item_sub_category_id"],
                "item_type_id"          => @$_POST["item_type_id"],
                "item_scope_ids"         => $item_scope_ids,
                "item_brand_id"         => @$_POST["item_brand_id"],
                "name"                  => @$_POST["name"],
                "unit_id"               => @$_POST["unit_id"],
                "stock_min"             => @$_POST["stock_min"],
                "stock_max"             => @$_POST["stock_max"],
            ];
            $item = $item + $this->created_values() + $this->updated_values();
            if ($this->items->save($item))
                $this->session->setFlashdata("flash_message", ["success", "Success adding item"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding item"]);
            return redirect()->to(base_url() . '/items');
        }

        $data["__modulename"]       = "Add Item";
        $data["item_specifications"]    = $this->item_specifications->where("is_deleted", 0)->findAll();
        $data["item_categories"]        = $this->item_categories->where("is_deleted", 0)->findAll();
        $data["item_sub_categories"]    = $this->item_sub_categories->where("is_deleted", 0)->findAll();
        $data["item_types"]             = $this->item_types->where("is_deleted", 0)->findAll();
        $data["item_scopes"]            = [];
        $data["item_brands"]            = $this->item_brands->where("is_deleted", 0)->findAll();
        $data["units"]                  = $this->units->where("is_deleted", 0)->findAll();
        foreach ($data["units"] as $unit) {
            $data["_units"][$unit->id] = $unit->name;
        }
        $data                           = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('items/v_edit');
        echo view('v_footer');
        echo view('items/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $item_scope_ids = "";
            foreach ($_POST["item_scope_ids"] as $item_scope_id) {
                $item_scope_ids .= "|" . $item_scope_id . "|";
            }
            $item = [
                "code"                  => @$_POST["code"],
                "item_specification_id" => @$_POST["item_specification_id"],
                "item_category_id"      => @$_POST["item_category_id"],
                "item_sub_category_id"  => @$_POST["item_sub_category_id"],
                "item_type_id"          => @$_POST["item_type_id"],
                "item_scope_ids"        => $item_scope_ids,
                "item_brand_id"         => @$_POST["item_brand_id"],
                "name"                  => @$_POST["name"],
                "unit_id"               => @$_POST["unit_id"],
                "stock_min"             => @$_POST["stock_min"],
                "stock_max"             => @$_POST["stock_max"],
            ];
            $item = $item + $this->updated_values();
            if ($this->items->update($id, $item))
                $this->session->setFlashdata("flash_message", ["success", "Success editing item"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing item"]);
            return redirect()->to(base_url() . '/items');
        }

        $data["__modulename"]       = "Edit item";
        $data["item_specifications"]    = $this->item_specifications->where("is_deleted", 0)->findAll();
        $data["item_categories"]        = $this->item_categories->where("is_deleted", 0)->findAll();
        $data["item_sub_categories"]    = $this->item_sub_categories->where("is_deleted", 0)->findAll();
        $data["item_types"]             = $this->item_types->where("is_deleted", 0)->findAll();
        $data["item_scopes"]            = [];
        $data["item_brands"]            = $this->item_brands->where("is_deleted", 0)->findAll();
        $data["units"]                  = $this->units->where("is_deleted", 0)->findAll();
        foreach ($data["units"] as $unit) {
            $data["_units"][$unit->id] = $unit->name;
        }
        $data["item"]               = $this->items->where("is_deleted", 0)->find([$id])[0];
        $data                       = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('items/v_edit');
        echo view('v_footer');
        echo view('items/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->items->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting item"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting item"]);
        return redirect()->to(base_url() . '/items');
    }

    public function get_item($id)
    {
        return json_encode($this->items->where("is_deleted", 0)->find([$id]));
    }

    public function subwindow()
    {
        $wherclause = "is_deleted = '0'";

        if (isset($_GET["keyword"]) && $_GET["keyword"] != "") {
            $wherclause .= "AND (code LIKE '%" . $_GET["keyword"] . "%'";
            $wherclause .= "OR name LIKE '%" . $_GET["keyword"] . "%')";
        }

        if ($items = $this->items->where($wherclause)->findAll(LIMIT_SUBWINDOW, 0)) {
            foreach ($items as $item) {
                $item_detail[$item->id]["item_specification_id"] = @$this->item_specifications->where("id", $item->item_specification_id)->get()->getResult()[0]->name;
                $item_detail[$item->id]["item_category_id"] = @$this->item_categories->where("id", $item->item_category_id)->get()->getResult()[0]->name;
                $item_detail[$item->id]["item_sub_category_id"] = @$this->item_sub_categories->where("id", $item->item_sub_category_id)->get()->getResult()[0]->name;
                $item_detail[$item->id]["item_type_id"] = @$this->item_types->where("id", $item->item_type_id)->get()->getResult()[0]->name;
                $item_detail[$item->id]["item_brand_id"] = @$this->item_brands->where("id", $item->item_brand_id)->get()->getResult()[0]->name;
                $item_detail[$item->id]["unit_id"] = @$this->units->where("id", $item->unit_id)->get()->getResult()[0]->name;
                $item_detail[$item->id]["prices"] = @$this->item_prices->where("item_id", $item->id)->get()->getResult()[0];
                $item_scopes = "";
                foreach (explode("|", $item->item_scope_ids) as $item_scope_id) {
                    if ($item_scope_id != "") {
                        $item_scope = $this->item_scopes->where("id", $item_scope_id)->get()->getResult()[0];
                        $item_scopes .= $item_scope->name . " " . $this->units->where("id", $item_scope->unit_id)->get()->getResult()[0]->name . "; ";
                    }
                }
                $item_detail[$item->id]["item_scopes"] = substr($item_scopes, 0, -2);
            }
        }

        $data["items"]      = $items;
        $data["item_detail"] = @$item_detail;
        $data                   = $data + $this->common();
        echo view('items/v_subwindow', $data);
    }
}
