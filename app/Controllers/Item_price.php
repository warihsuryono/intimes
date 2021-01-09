<?php

namespace App\Controllers;

use App\Models\m_item;
use App\Models\m_item_price;
use App\Models\m_item_specification;
use App\Models\m_item_category;
use App\Models\m_item_sub_category;
use App\Models\m_item_type;
use App\Models\m_item_brand;
use App\Models\m_item_scope;
use App\Models\m_item_costing;
use App\Models\m_unit;
use App\Models\m_currency;

class Item_price extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $items;
    protected $item_prices;
    protected $item_specifications;
    protected $item_categories;
    protected $item_sub_categories;
    protected $item_types;
    protected $item_scope;
    protected $item_brands;
    protected $item_costings;
    protected $units;
    protected $currencies;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "item_prices";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->items =  new m_item();
        $this->item_prices =  new m_item_price();
        $this->item_specifications =  new m_item_specification();
        $this->item_categories =  new m_item_category();
        $this->item_sub_categories =  new m_item_sub_category();
        $this->item_types =  new m_item_type();
        $this->item_scopes =  new m_item_scope();
        $this->item_brands =  new m_item_brand();
        $this->item_costings =  new m_item_costing();
        $this->units =  new m_unit();
        $this->currencies =  new m_currency();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Items Price";
        $data["_this"] = $this;
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
                $item_detail[$item->id]["item_price"] = @$this->item_prices->where("item_id", $item->id)->get()->getResult()[0];
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
        echo view('item_prices/v_list');
        echo view('v_footer');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $success_editing_price = False;
            $item_price = [
                "item_id"           => $id,
                "cogs"              => @$_POST["cogs"],
                "cogs_currency_id"  => @$_POST["cogs_currency_id"],
                "price"             => @$_POST["price"],
                "price_currency_id" => @$_POST["price_currency_id"],
            ];
            $item_price = $item_price + $this->updated_values();

            $_item_price = @$this->item_prices->where("item_id", $id)->findAll();

            if (count($_item_price) <= 0) {
                $item_price = $item_price + $this->created_values();
                if ($this->item_prices->save($item_price)) $success_editing_price = True;
            } else
                if ($this->item_prices->update($_item_price[0]->id, $item_price)) $success_editing_price = True;

            if ($success_editing_price) {
                $this->item_costings->where('item_id', $id)->delete();
                foreach ($_POST["costing_item_id"] as $key => $costing_item_id) {
                    $item_scope_ids = "";
                    if (is_array($_POST["item_scope_ids"][$key])) {
                        foreach ($_POST["item_scope_ids"][$key] as $item_scope_id) {
                            $item_scope_ids .= "|" . $item_scope_id . "|";
                        }
                    }
                    $item_costing = [
                        "item_id" => $id,
                        "costing_item_id" => $costing_item_id,
                        "code" => @$_POST["code"][$key],
                        "item_specification_id" => @$_POST["item_specification_id"][$key],
                        "item_category_id" => @$_POST["item_category_id"][$key],
                        "item_sub_category_id" => @$_POST["item_sub_category_id"][$key],
                        "item_type_id" => @$_POST["item_type_id"][$key],
                        "item_scope_ids" => $item_scope_ids,
                        "item_name" => @$_POST["item_name"][$key],
                        "volume_budget" => @$_POST["volume_budget"][$key],
                        "volume_unit_id" => @$_POST["volume_unit_id"][$key],
                        "cost_currency_id" => @$_POST["cost_currency_id"][$key],
                        "cost_budget" => @$_POST["cost_budget"][$key],
                        "revenue_currency_id" => @$_POST["revenue_currency_id"][$key],
                        "revenue" => @$_POST["revenue"][$key],
                    ];
                    $item_costing = $item_costing + $this->created_values() + $this->updated_values();
                    $this->item_costings->save($item_costing);
                }
                $this->session->setFlashdata("flash_message", ["success", "Success editing item"]);
            } else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing item"]);
            return redirect()->to(base_url() . '/item_prices');
        }

        $data["__modulename"]       = "Edit item price";

        $data["item"]               = $this->items->where("is_deleted", 0)->find([$id])[0];

        $data["item_specifications"]    = $this->item_specifications->where("is_deleted", 0)->findAll();
        $data["item_categories"]        = $this->item_categories->where("is_deleted", 0)->findAll();
        $data["item_sub_categories"]    = $this->item_sub_categories->where("is_deleted", 0)->findAll();
        $data["item_types"]             = $this->item_types->where("is_deleted", 0)->findAll();
        $data["item_scopes"]            = [];
        $data["units"]                  = $this->units->where("is_deleted", 0)->findAll();
        $data["currencies"]             = $this->currencies->where("is_deleted", 0)->findAll();
        $data["item_specification"]     = @$this->item_specifications->where("id", $data["item"]->item_specification_id)->get()->getResult()[0]->name;
        $data["item_category"]          = @$this->item_categories->where("id", $data["item"]->item_category_id)->get()->getResult()[0]->name;
        $data["item_sub_category"]      = @$this->item_sub_categories->where("id", $data["item"]->item_sub_category_id)->get()->getResult()[0]->name;
        $data["item_brand"]             = @$this->item_brands->where("id", $data["item"]->item_brand_id)->get()->getResult()[0]->name;
        $data["item_type"]              = @$this->item_types->where("id", $data["item"]->item_type_id)->get()->getResult()[0]->name;
        $data["unit"]                   = $this->units->where("id", $data["item"]->unit_id)->get()->getResult()[0]->name;
        $data["item_price"]             = @$this->item_prices->where("item_id", $data["item"]->id)->get()->getResult()[0];
        $data["item_costings"]          = @$this->item_costings->where("item_id", $data["item"]->id)->findAll();

        $data                           = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_prices/v_edit');
        echo view('v_footer');
        echo view('item_prices/v_js');
    }
}
