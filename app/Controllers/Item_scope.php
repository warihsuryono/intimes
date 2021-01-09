<?php

namespace App\Controllers;

use App\Models\m_item;
use App\Models\m_item_scope;
use App\Models\m_item_type;
use App\Models\m_unit;
use App\Models\m_currency;

class Item_scope extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $items;
    protected $item_scopes;
    protected $item_types;
    protected $units;
    protected $currencies;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "item_scopes";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->items =  new m_item();
        $this->item_scopes =  new m_item_scope();
        $this->item_types =  new m_item_type();
        $this->units =  new m_unit();
        $this->currencies =  new m_currency();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Item scopes";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if (isset($_GET["item_type_id"]) && $_GET["item_type_id"] != "")
            $wherclause .= "AND item_type_id = '" . $_GET["item_type_id"] . "'";

        if (isset($_GET["unit_id"]) && $_GET["unit_id"] != "")
            $wherclause .= "AND unit_id = '" . $_GET["unit_id"] . "'";

        if ($item_scopes = $this->item_scopes->where($wherclause)->findAll(MAX_ROW, $startrow)) {
            $numrow = count($this->item_scopes->where($wherclause)->findAll());
            foreach ($item_scopes as $item_scope) {
                $i_scope_detail[$item_scope->id]["item_type"] = @$this->item_types->where("id", $item_scope->item_type_id)->get()->getResult()[0]->name;
                $i_scope_detail[$item_scope->id]["unit"] = @$this->units->where("id", $item_scope->unit_id)->get()->getResult()[0]->name;
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["item_scopes"] = $item_scopes;
        $data["item_types"] = $this->item_types->where("is_deleted", 0)->findAll();
        $data["units"]      = $this->units->where("is_deleted", 0)->findAll();
        $data["i_scope_detail"]    = @$i_scope_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_scopes/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $item_scope = [
                "name" => @$_POST["name"],
                "item_type_id"  => @$_POST["item_type_id"],
                "unit_id"       => @$_POST["unit_id"],
                "add_price"     => @$_POST["add_price"],
                "price_currency_id"     => @$_POST["price_currency_id"],
            ];
            $item_scope = $item_scope + $this->created_values() + $this->updated_values();
            if ($this->item_scopes->save($item_scope))
                $this->session->setFlashdata("flash_message", ["success", "Success adding item scope"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding item scope"]);
            return redirect()->to(base_url() . '/item_scopes');
        }

        $data["__modulename"] = "Add Item scope";
        $data["item_types"]             = $this->item_types->where("is_deleted", 0)->findAll();
        $data["units"]                  = $this->units->where("is_deleted", 0)->findAll();
        $data["currencies"]             = $this->currencies->where("is_deleted", 0)->findAll();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_scopes/v_edit');
        echo view('v_footer');
        echo view('item_scopes/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $item_scope = [
                "name" => @$_POST["name"],
                "item_type_id"  => @$_POST["item_type_id"],
                "unit_id"       => @$_POST["unit_id"],
                "add_price"     => @$_POST["add_price"],
                "price_currency_id"     => @$_POST["price_currency_id"],
            ];
            $item_scope = $item_scope + $this->updated_values();
            if ($this->item_scopes->update($id, $item_scope))
                $this->session->setFlashdata("flash_message", ["success", "Success editing item scope"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing item scope"]);
            return redirect()->to(base_url() . '/item_scopes');
        }

        $data["__modulename"] = "Edit Item scope";
        $data["item_types"]             = $this->item_types->where("is_deleted", 0)->findAll();
        $data["units"]                  = $this->units->where("is_deleted", 0)->findAll();
        $data["currencies"]             = $this->currencies->where("is_deleted", 0)->findAll();
        $data["item_scope"] = $this->item_scopes->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_scopes/v_edit');
        echo view('v_footer');
        echo view('item_scopes/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->item_scopes->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting item scope"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting item scope"]);
        return redirect()->to(base_url() . '/item_scopes');
    }

    public function scopes_by_type_id($item_type_id)
    {
        $return = [];
        $scopes = $this->item_scopes->where("item_type_id", $item_type_id)->where("is_deleted", 0)->findAll();
        foreach ($scopes as $key => $scope) {
            $unit = @$this->units->where("id", $scope->unit_id)->where("is_deleted", 0)->findAll()[0];
            $return[$key]["id"] = $scope->id;
            $return[$key]["name"] = $scope->name;
            $return[$key]["unit"] = $unit->name;
        }
        return json_encode($return);
    }

    public function scopes_by_item_id($item_id)
    {
        $item_type_id = $this->items->where("is_deleted", 0)->find([$item_id])[0]->item_type_id;
        $return = [];
        $scopes = $this->item_scopes->where("item_type_id", $item_type_id)->where("is_deleted", 0)->findAll();
        foreach ($scopes as $key => $scope) {
            $unit = @$this->units->where("id", $scope->unit_id)->where("is_deleted", 0)->findAll()[0];
            $return[$key]["id"] = $scope->id;
            $return[$key]["name"] = $scope->name;
            $return[$key]["unit"] = $unit->name;
        }
        return json_encode($return);
    }
}
