<?php

namespace App\Controllers;

use App\Models\m_item_history_type;
use App\Models\m_item_receive;
use App\Models\m_unit;
use App\Models\m_item_history;
use App\Models\m_item;

class Item_history extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $item_history_types;
    protected $item_receives;
    protected $units;
    protected $item_histories;
    protected $items;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "item_histories";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->item_history_types =  new m_item_history_type();
        $this->item_receives =  new m_item_receive();
        $this->units =  new m_unit();
        $this->item_histories =  new m_item_history();
        $this->items =  new m_item();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);
        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Stock History";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["in_out"]) && $_GET["in_out"] != "")
            $wherclause .= " AND in_out = '" . $_GET["in_out"] . "'";

        if (isset($_GET["item_history_type_id"]) && $_GET["item_history_type_id"] != "")
            $wherclause .= " AND item_history_type_id = '" . $_GET["item_history_type_id"] . "'";

        if (isset($_GET["dok_no"]) && $_GET["dok_no"] != "")
            $wherclause .= " AND (dok_no LIKE '%" . $_GET["dok_no"] . "%' OR item_receive_id IN (SELECT id FROM item_receives WHERE item_receive_no LIKE '%" . $_GET["dok_no"] . "%' OR  po_no LIKE '%" . $_GET["dok_no"] . "%'))";

        if (isset($_GET["item_id"]) && $_GET["item_id"] != "")
            $wherclause .= " AND item_id = '" . $_GET["item_id"] . "'";

        if (isset($_GET["code"]) && $_GET["code"] != "")
            $wherclause .= " AND item_id IN (SELECT id FROM items WHERE code LIKE '%" . $_GET["code"] . "%')";

        if (isset($_GET["notes"]) && $_GET["notes"] != "")
            $wherclause .= " AND notes LIKE '%" . $_GET["notes"] . "%'";

        if ($item_histories = $this->item_histories->where($wherclause)->findAll(MAX_ROW, $startrow)) {
            $numrow = count($this->item_histories->where($wherclause)->findAll());
            foreach ($item_histories as $item_history) {
                $item_history_detail[$item_history->id]["item_history_type"] = @$this->item_history_types->where("id", $item_history->item_history_type_id)->get()->getResult()[0]->name;
                $item_history_detail[$item_history->id]["item_receive"] = @$this->item_receives->where("id", $item_history->item_receive_id)->get()->getResult()[0]->name;
                $item_history_detail[$item_history->id]["item"] = @$this->items->where("id", $item_history->item_id)->get()->getResult()[0];
                $item_history_detail[$item_history->id]["unit"] = @$this->units->where("id", $item_history->unit_id)->get()->getResult()[0]->name;
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["item_history_types"] = $this->item_history_types->where("is_deleted", 0)->findAll();
        $data["item_receive"] = $this->item_receives->where("is_deleted", 0)->findAll();
        $data["units"] = $this->units->where("is_deleted", 0)->findAll();
        $data["item_histories"] = $item_histories;
        $data["item_history_detail"]    = @$item_history_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_histories/v_list');
        echo view('v_footer');
    }
}
