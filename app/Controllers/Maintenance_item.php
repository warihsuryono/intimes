<?php

namespace App\Controllers;

use App\Models\m_maintenance_item;
use App\Models\m_item_specification;
use App\Models\m_item_category;
use App\Models\m_item_sub_category;
use App\Models\m_item_type;
use App\Models\m_item_scope;
use App\Models\m_item_price;
use App\Models\m_unit;

class Maintenance_item extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $maintenance_items;
    protected $item_specifications;
    protected $item_categories;
    protected $item_sub_categories;
    protected $item_types;
    protected $item_scope;
    protected $item_prices;
    protected $units;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "maintenance_items";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->maintenance_items =  new m_maintenance_item();
        $this->item_specifications =  new m_item_specification();
        $this->item_categories =  new m_item_category();
        $this->item_sub_categories =  new m_item_sub_category();
        $this->item_types =  new m_item_type();
        $this->item_scopes =  new m_item_scope();
        $this->item_prices =  new m_item_price();
        $this->units =  new m_unit();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Maintenance Items";
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

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($maintenance_items = $this->maintenance_items->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->maintenance_items->where($wherclause)->findAll());

            foreach ($maintenance_items as $maintenance_item) {
                $maintenance_item_detail[$maintenance_item->id]["item_specification"] = @$this->item_specifications->where("id", $maintenance_item->item_specification_id)->get()->getResult()[0]->name;
                $maintenance_item_detail[$maintenance_item->id]["item_category"] = @$this->item_categories->where("id", $maintenance_item->item_category_id)->get()->getResult()[0]->name;
                $maintenance_item_detail[$maintenance_item->id]["item_sub_category"] = @$this->item_sub_categories->where("id", $maintenance_item->item_sub_category_id)->get()->getResult()[0]->name;
                $maintenance_item_detail[$maintenance_item->id]["item_type"] = @$this->item_types->where("id", $maintenance_item->item_type_id)->get()->getResult()[0]->name;
                $maintenance_item_detail[$maintenance_item->id]["unit"] = $this->units->where("id", $maintenance_item->unit_id)->get()->getResult()[0]->name;
                $item_scopes = "";
                foreach (explode("|", $maintenance_item->item_scope_ids) as $item_scope_id) {
                    if ($item_scope_id != "") {
                        $item_scope = $this->item_scopes->where("id", $item_scope_id)->get()->getResult()[0];
                        $item_scopes .= $item_scope->name . " " . $this->units->where("id", $item_scope->unit_id)->get()->getResult()[0]->name . "; ";
                    }
                }
                $maintenance_item_detail[$maintenance_item->id]["item_scopes"] = substr($item_scopes, 0, -2);
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"]           = $startrow;
        $data["numrow"]             = $numrow;
        $data["maxpage"]            = ceil($numrow / MAX_ROW);
        $data["item_specifications"] = $this->item_specifications->where("is_deleted", 0)->findAll();
        $data["item_categories"]    = $this->item_categories->where("is_deleted", 0)->findAll();
        $data["item_sub_categories"] = $this->item_sub_categories->where("is_deleted", 0)->findAll();
        $data["item_types"]         = $this->item_types->where("is_deleted", 0)->findAll();
        $data["items"]              = $maintenance_items;
        $data["item_detail"]        = @$maintenance_item_detail;
        $data                       = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('maintenance_items/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $item_scope_ids = "";
            if (isset($_POST["item_scope_ids"])) {
                foreach ($_POST["item_scope_ids"] as $item_scope_id) {
                    $item_scope_ids .= "|" . $item_scope_id . "|";
                }
            }
            $maintenance_item = [
                "code"                  => @$_POST["code"],
                "item_specification_id" => @$_POST["item_specification_id"],
                "item_category_id"      => @$_POST["item_category_id"],
                "item_sub_category_id"  => @$_POST["item_sub_category_id"],
                "item_type_id"          => @$_POST["item_type_id"],
                "item_scope_ids"         => $item_scope_ids,
                "name"                  => @$_POST["name"],
                "unit_id"               => @$_POST["unit_id"],
                "address"               => @$_POST["address"],
                "city"                  => @$_POST["city"],
                "province"              => @$_POST["province"],
                "lat"                   => @$_POST["lat"],
                "lon"                   => @$_POST["lon"],
            ];
            $maintenance_item = $maintenance_item + $this->created_values() + $this->updated_values();
            if ($this->maintenance_items->save($maintenance_item))
                $this->session->setFlashdata("flash_message", ["success", "Success adding item"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding item"]);
            return redirect()->to(base_url() . '/maintenance_items');
        }

        $data["__modulename"]       = "Add Item";
        $data["item_specifications"]    = $this->item_specifications->where("is_deleted", 0)->findAll();
        $data["item_categories"]        = $this->item_categories->where("is_deleted", 0)->findAll();
        $data["item_sub_categories"]    = $this->item_sub_categories->where("is_deleted", 0)->findAll();
        $data["item_types"]             = $this->item_types->where("is_deleted", 0)->findAll();
        $data["item_scopes"]            = [];
        $data["units"]                  = $this->units->where("is_deleted", 0)->findAll();
        foreach ($data["units"] as $unit) {
            $data["_units"][$unit->id] = $unit->name;
        }
        $data                           = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('maintenance_items/v_edit');
        echo view('v_footer');
        echo view('maintenance_items/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $item_scope_ids = "";
            if (isset($_POST["item_scope_ids"])) {
                foreach ($_POST["item_scope_ids"] as $item_scope_id) {
                    $item_scope_ids .= "|" . $item_scope_id . "|";
                }
            }
            $maintenance_item = [
                "code"                  => @$_POST["code"],
                "item_specification_id" => @$_POST["item_specification_id"],
                "item_category_id"      => @$_POST["item_category_id"],
                "item_sub_category_id"  => @$_POST["item_sub_category_id"],
                "item_type_id"          => @$_POST["item_type_id"],
                "item_scope_ids"        => $item_scope_ids,
                "name"                  => @$_POST["name"],
                "unit_id"               => @$_POST["unit_id"],
                "address"               => @$_POST["address"],
                "city"                  => @$_POST["city"],
                "province"              => @$_POST["province"],
                "lat"                   => @$_POST["lat"],
                "lon"                   => @$_POST["lon"],
            ];
            $maintenance_item = $maintenance_item + $this->updated_values();
            if ($this->maintenance_items->update($id, $maintenance_item))
                $this->session->setFlashdata("flash_message", ["success", "Success editing item"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing item"]);
            return redirect()->to(base_url() . '/maintenance_items');
        }

        $data["__modulename"]       = "Edit item";
        $data["item_specifications"]    = $this->item_specifications->where("is_deleted", 0)->findAll();
        $data["item_categories"]        = $this->item_categories->where("is_deleted", 0)->findAll();
        $data["item_sub_categories"]    = $this->item_sub_categories->where("is_deleted", 0)->findAll();
        $data["item_types"]             = $this->item_types->where("is_deleted", 0)->findAll();
        $data["item_scopes"]            = [];
        $data["units"]                  = $this->units->where("is_deleted", 0)->findAll();
        foreach ($data["units"] as $unit) {
            $data["_units"][$unit->id] = $unit->name;
        }
        $data["item"]               = $this->maintenance_items->where("is_deleted", 0)->find([$id])[0];
        $data                       = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('maintenance_items/v_edit');
        echo view('v_footer');
        echo view('maintenance_items/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->maintenance_items->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting item"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting item"]);
        return redirect()->to(base_url() . '/maintenance_items');
    }

    public function get_item($id)
    {
        return json_encode($this->maintenance_items->where("is_deleted", 0)->find([$id]));
    }

    public function subwindow()
    {
        $wherclause = "is_deleted = '0'";

        if (isset($_GET["keyword"]) && $_GET["keyword"] != "") {
            $wherclause .= "AND (code LIKE '%" . $_GET["keyword"] . "%'";
            $wherclause .= "OR name LIKE '%" . $_GET["keyword"] . "%')";
        }

        if ($maintenance_items = $this->maintenance_items->where($wherclause)->findAll(LIMIT_SUBWINDOW, 0)) {
            foreach ($maintenance_items as $maintenance_item) {
                $maintenance_item_detail[$maintenance_item->id]["item_specification_id"] = @$this->item_specifications->where("id", $maintenance_item->item_specification_id)->get()->getResult()[0]->name;
                $maintenance_item_detail[$maintenance_item->id]["item_category_id"] = @$this->item_categories->where("id", $maintenance_item->item_category_id)->get()->getResult()[0]->name;
                $maintenance_item_detail[$maintenance_item->id]["item_sub_category_id"] = @$this->item_sub_categories->where("id", $maintenance_item->item_sub_category_id)->get()->getResult()[0]->name;
                $maintenance_item_detail[$maintenance_item->id]["item_type_id"] = @$this->item_types->where("id", $maintenance_item->item_type_id)->get()->getResult()[0]->name;
                $maintenance_item_detail[$maintenance_item->id]["unit_id"] = @$this->units->where("id", $maintenance_item->unit_id)->get()->getResult()[0]->name;
                $item_scopes = "";
                foreach (explode("|", $maintenance_item->item_scope_ids) as $item_scope_id) {
                    if ($item_scope_id != "") {
                        $item_scope = $this->item_scopes->where("id", $item_scope_id)->get()->getResult()[0];
                        $item_scopes .= $item_scope->name . " " . $this->units->where("id", $item_scope->unit_id)->get()->getResult()[0]->name . "; ";
                    }
                }
                $maintenance_item_detail[$maintenance_item->id]["item_scopes"] = substr($item_scopes, 0, -2);
            }
        }

        $data["items"]              = $maintenance_items;
        $data["item_detail"]        = @$maintenance_item_detail;
        $data                       = $data + $this->common();
        echo view('maintenance_items/v_subwindow', $data);
    }
}
