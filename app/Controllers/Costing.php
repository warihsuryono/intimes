<?php

namespace App\Controllers;

use App\Models\m_costing;
use App\Models\m_item;
use App\Models\m_item_specification;
use App\Models\m_item_category;
use App\Models\m_item_sub_category;
use App\Models\m_item_type;
use App\Models\m_item_scope;
use App\Models\m_unit;
use App\Models\m_currency;

class Costing extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $costings;
    protected $items;
    protected $item_specifications;
    protected $item_categories;
    protected $item_sub_categories;
    protected $item_types;
    protected $item_scope;
    protected $units;
    protected $currencies;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "costings";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->costings =  new m_costing();
        $this->items =  new m_item();
        $this->item_specifications =  new m_item_specification();
        $this->item_categories =  new m_item_category();
        $this->item_sub_categories =  new m_item_sub_category();
        $this->item_types =  new m_item_type();
        $this->item_scopes =  new m_item_scope();
        $this->units =  new m_unit();
        $this->currencies =  new m_currency();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Costings";
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

        if ($costings = $this->costings->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->costings->where($wherclause)->findAll());

            foreach ($costings as $costing) {
                $costing_detail[$costing->id]["item_specification"] = @$this->item_specifications->where("id", $costing->item_specification_id)->get()->getResult()[0]->name;
                $costing_detail[$costing->id]["item_category"] = @$this->item_categories->where("id", $costing->item_category_id)->get()->getResult()[0]->name;
                $costing_detail[$costing->id]["item_sub_category"] = @$this->item_sub_categories->where("id", $costing->item_sub_category_id)->get()->getResult()[0]->name;
                $costing_detail[$costing->id]["item_type"] = @$this->item_types->where("id", $costing->item_type_id)->get()->getResult()[0]->name;
                $costing_detail[$costing->id]["volume_unit"] = @$this->units->where("id", $costing->volume_unit_id)->get()->getResult()[0]->name;
                $costing_detail[$costing->id]["cost_currency"] = @$this->currencies->where("id", $costing->cost_currency_id)->get()->getResult()[0]->symbol;
                $costing_detail[$costing->id]["revenue_currency"] = @$this->currencies->where("id", $costing->revenue_currency_id)->get()->getResult()[0]->symbol;
                $item_scopes = "";
                foreach (explode("|", $costing->item_scope_ids) as $item_scope_id) {
                    if ($item_scope_id != "") {
                        $item_scope = $this->item_scopes->where("id", $item_scope_id)->get()->getResult()[0];
                        $item_scopes .= $item_scope->name . " " . $this->units->where("id", $item_scope->unit_id)->get()->getResult()[0]->name . "; ";
                    }
                }
                $costing_detail[$costing->id]["item_scopes"] = substr($item_scopes, 0, -2);
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"]               = $startrow;
        $data["numrow"]                 = $numrow;
        $data["maxpage"]                = ceil($numrow / MAX_ROW);
        $data["item_specifications"]    = $this->item_specifications->where("is_deleted", 0)->findAll();
        $data["item_categories"]        = $this->item_categories->where("is_deleted", 0)->findAll();
        $data["item_sub_categories"]    = $this->item_sub_categories->where("is_deleted", 0)->findAll();
        $data["item_types"]             = $this->item_types->where("is_deleted", 0)->findAll();
        $data["costings"]               = $costings;
        $data["costing_detail"]         = @$costing_detail;
        $data                           = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('costings/v_list');
        echo view('v_footer');
    }

    public function get_reference_data()
    {
        $data["item_specifications"]    = $this->item_specifications->where("is_deleted", 0)->findAll();
        $data["item_categories"]        = $this->item_categories->where("is_deleted", 0)->findAll();
        $data["item_sub_categories"]    = $this->item_sub_categories->where("is_deleted", 0)->findAll();
        $data["item_types"]             = $this->item_types->where("is_deleted", 0)->findAll();
        $data["item_scopes"]            = [];
        $data["units"]                  = $this->units->where("is_deleted", 0)->findAll();
        foreach ($data["units"] as $unit) {
            $data["_units"][$unit->id] = $unit->name;
        }
        $data["currencies"]             = $this->currencies->where("is_deleted", 0)->findAll();
        return $data;
    }

    public function saving_data()
    {
        $item_scope_ids = "";
        foreach ($_POST["item_scope_ids"] as $item_scope_id) {
            $item_scope_ids .= "|" . $item_scope_id . "|";
        }
        $costing = [
            "item_id"               => @$_POST["item_id"],
            "code"                  => @$_POST["code"],
            "item_specification_id" => @$_POST["item_specification_id"],
            "item_category_id"      => @$_POST["item_category_id"],
            "item_sub_category_id"  => @$_POST["item_sub_category_id"],
            "item_type_id"          => @$_POST["item_type_id"],
            "item_scope_ids"        => $item_scope_ids,
            "item_name"             => @$_POST["item_name"],
            "volume_budget"         => @$_POST["volume_budget"],
            "volume_unit_id"        => @$_POST["volume_unit_id"],
            "cost_currency_id"      => @$_POST["cost_currency_id"],
            "cost_budget"           => @$_POST["cost_budget"],
            "revenue_currency_id"   => @$_POST["revenue_currency_id"],
            "revenue"               => @$_POST["revenue"],
        ];
        return $costing;
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $costing = $this->saving_data();
            $costing = $costing + $this->created_values() + $this->updated_values();
            if ($this->costings->save($costing))
                $this->session->setFlashdata("flash_message", ["success", "Success adding costing"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding costing"]);
            return redirect()->to(base_url() . '/costings');
        }

        $data["__modulename"]       = "Add Costing";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('costings/v_edit');
        echo view('v_footer');
        echo view('costings/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $costing = $this->saving_data();
            $costing = $costing + $this->updated_values();
            if ($this->costings->update($id, $costing))
                $this->session->setFlashdata("flash_message", ["success", "Success editing costing"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing costing"]);
            return redirect()->to(base_url() . '/costings');
        }

        $data["__modulename"]       = "Edit Costing";
        $data = $data + $this->get_reference_data();
        $data["costing"] = $this->costings->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('costings/v_edit');
        echo view('v_footer');
        echo view('costings/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->costings->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting costing"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting costing"]);
        return redirect()->to(base_url() . '/costings');
    }
}
