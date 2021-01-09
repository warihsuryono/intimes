<?php

namespace App\Controllers;

use App\Models\m_stock_control;
use App\Models\m_stock_control_detail;
use App\Models\m_item_history;
use App\Models\m_item_history_type;
use App\Models\m_item;
use App\Models\m_unit;

class Stock_control extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $stock_controls;
    protected $stock_control_details;
    protected $item_histories;
    protected $item_history_types;
    protected $items;
    protected $units;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "stock_controls";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->stock_controls =  new m_stock_control();
        $this->stock_control_details =  new m_stock_control_detail();
        $this->item_histories =  new m_item_history();
        $this->item_history_types =  new m_item_history_type();
        $this->items =  new m_item();
        $this->units =  new m_unit();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Stock Control";
        $data["_this"] = $this;
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["stock_control_no"]) && $_GET["stock_control_no"] != "")
            $wherclause .= "AND stock_control_no LIKE '%" . $_GET["stock_control_no"] . "%'";

        if (isset($_GET["stock_control_at"]) && $_GET["stock_control_at"] != "")
            $wherclause .= "AND stock_control_at LIKE '" . $_GET["stock_control_at"] . "'";

        if (isset($_GET["description"]) && $_GET["description"] != "")
            $wherclause .= "AND description LIKE '%" . $_GET["description"] . "%'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        if (isset($_GET["is_approved"]) && $_GET["is_approved"] != "")
            $wherclause .= "AND is_approved = '" . $_GET["is_approved"] . "'";


        $stock_controls = $this->stock_controls->where($wherclause)->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        $numrow = count($this->stock_controls->where($wherclause)->findAll());

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["stock_controls"] = $stock_controls;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('stock_controls/v_list');
        echo view('v_footer');
    }

    public function get_stock_control_no()
    {
        $stock_control_no = $this->letter_no_template("letter_stock_control_temp");
        $stock_control_seqno = @$this->stock_controls->where("stock_control_no LIKE '" . $stock_control_no . "'")->where("is_deleted", 0)->orderBy("id DESC")->findAll()[0]->stock_control_no;
        if ($stock_control_seqno == "")
            $stock_control_no = str_replace("%", "001", $stock_control_no);
        else {
            $stock_control_temp = str_replace("%", "", $stock_control_no);
            $seqno = str_replace($stock_control_temp, "", $stock_control_seqno) * 1;
            $seqno++;
            $stock_control_no = str_replace("%", $this->numberpad($seqno, 3), $stock_control_no);
        }
        return $stock_control_no;
    }

    public function saving_data()
    {
        return [
            "stock_control_no" => @$_POST["stock_control_no"],
            "stock_control_at" => @$_POST["stock_control_at"],
            "description" => @$_POST["description"],
        ];
    }

    public function saving_add()
    {
        if (isset($_POST["Save"])) {
            $stock_control = $this->saving_data();
            $stock_control = $stock_control + $this->created_values() + $this->updated_values();

            $this->stock_controls->save($stock_control);
            $id = $this->stock_controls->insertID();

            foreach ($_POST["item_id"] as $key => $item_id) {
                $stock_control_detail = [
                    "stock_control_id" => $id,
                    "in_out" => @$_POST["in_out"][$key],
                    "item_history_type_id" => @$_POST["item_history_type_id"][$key],
                    "dok_no" => @$_POST["dok_no"][$key],
                    "item_id" => $item_id,
                    "sku" => @$_POST["sku"][$key],
                    "qty" => @$_POST["qty"][$key],
                    "unit_id" => @$_POST["unit_id"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $stock_control_detail = $stock_control_detail + $this->created_values() + $this->updated_values();
                $this->stock_control_details->save($stock_control_detail);
            }

            $this->session->setFlashdata("flash_message", ["success", "Success adding Stock Control"]);
            echo "<script> window.location='" . base_url() . "/stock_control/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function saving_edit($id)
    {
        if (isset($_POST["Save"])) {
            $stock_control = $this->saving_data();
            $stock_control = $stock_control + $this->updated_values();
            $this->stock_controls->update($id, $stock_control);
            $this->stock_control_details->where('stock_control_id', $id)->delete();

            foreach ($_POST["item_id"] as $key => $item_id) {
                $stock_control_detail = [
                    "stock_control_id" => $id,
                    "in_out" => @$_POST["in_out"][$key],
                    "item_history_type_id" => @$_POST["item_history_type_id"][$key],
                    "dok_no" => @$_POST["dok_no"][$key],
                    "item_id" => $item_id,
                    "sku" => @$_POST["sku"][$key],
                    "qty" => @$_POST["qty"][$key],
                    "unit_id" => @$_POST["unit_id"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $stock_control_detail = $stock_control_detail + $this->created_values() + $this->updated_values();
                $this->stock_control_details->save($stock_control_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success editing stock control"]);
            echo "<script> window.location='" . base_url() . "/stock_control/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function get_reference_data()
    {
        $data["units"] = $this->units->where("is_deleted", 0)->findAll();
        $data["item_history_types"] = $this->item_history_types->where("is_deleted", 0)->findAll();
        return $data;
    }

    public function get_saved_data($id)
    {
        $data["stock_control"] = @$this->stock_controls->where("is_deleted", 0)->find([$id])[0];
        $data["stock_control_details"] = @$this->stock_control_details->where(["is_deleted" => 0, "stock_control_id" => $id])->findAll();
        $data["created_user"] = @$this->users->where("email", $data["stock_control"]->created_by)->where("is_deleted", 0)->findAll()[0];
        $data["approved_user"] = @$this->users->where("email", $data["stock_control"]->approved_by)->where("is_deleted", 0)->findAll()[0];
        $stock_control_detail_item = [];
        $stock_control_detail_unit = [];
        $stock_control_detail_item_history_type = [];
        foreach ($data["stock_control_details"] as $stock_control_detail) {
            $stock_control_detail_item[$stock_control_detail->item_id] = @$this->items->where("id", $stock_control_detail->item_id)->where("is_deleted", 0)->findAll()[0];
            $stock_control_detail_unit[$stock_control_detail->item_id] = @$this->units->where("id", $stock_control_detail->unit_id)->where("is_deleted", 0)->findAll()[0];
            $stock_control_detail_item_history_type[$stock_control_detail->item_id] = @$this->item_history_types->where("id", $stock_control_detail->item_history_type_id)->where("is_deleted", 0)->findAll()[0];
        }
        $data["stock_control_detail_item"] = $stock_control_detail_item;
        $data["stock_control_detail_unit"] = $stock_control_detail_unit;
        $data["stock_control_detail_item_history_type"] = $stock_control_detail_item_history_type;
        return $data;
    }

    public function approve($id)
    {
        if (@$_GET["approving"] == 1) {
            $stock_control = @$this->stock_controls->where("is_deleted", 0)->find([$id])[0];
            $this->stock_controls->update($id, ["is_approved" => 1, "approved_at" => date("Y-m-d H:i:s"), "approved_by" => $this->session->get("username"), "approved_ip" => $_SERVER["REMOTE_ADDR"]]);
            $stock_control_details = @$this->stock_control_details->where(["is_deleted" => 0, "stock_control_id" => $id])->findAll();
            foreach ($stock_control_details as $stock_control_detail) {
                $qty = $stock_control_detail->qty;
                if ($qty > 0) {
                    $in_out = $stock_control_detail->in_out;
                    $item_history_type_id = $stock_control_detail->item_history_type_id;
                    $dok_no = $stock_control_detail->dok_no;
                    $item_id = $stock_control_detail->item_id;
                    $sku = $stock_control_detail->sku;
                    $unit_id = $stock_control_detail->unit_id;
                    $notes = $stock_control_detail->notes;
                    $this->item_histories->save(["in_out" => $in_out, "item_history_type_id" => $item_history_type_id, "dok_no" => $dok_no, "item_id" => $item_id, "sku" => $sku, "qty" => $qty, "unit_id" => $unit_id, "notes" => $notes, "is_approved" => 1, "approved_at" => date("Y-m-d H:i:s"), "approved_by" => $this->session->get("username"), "approved_ip" => $_SERVER["REMOTE_ADDR"]]);
                }
            }
            $this->session->setFlashdata("flash_message", ["success", "Success approving Stock Control"]);
            echo "<script> window.location='" . base_url() . "/stock_control/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        $stock_control_no = $this->get_stock_control_no();
        $_POST["stock_control_no"] = $stock_control_no;
        $this->saving_add();

        $data["__modulename"] = "Add Stock Control";
        $data["__mode"] = "add";
        $data["stock_control_no"] = $stock_control_no;

        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('stock_controls/v_edit');
        echo view('v_footer');
        echo view('stock_controls/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        $this->saving_edit($id);
        $data["__modulename"] = "Edit Stock Control";
        $data["__mode"] = "edit";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        if (@$data["stock_control"]->is_approved > 0) {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/stock_controls');
        }
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('stock_controls/v_edit');
        echo view('v_footer');
        echo view('stock_controls/v_js');
    }

    public function view($id)
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);
        $this->approve($id);

        $data["__modulename"] = "Stock Control";
        $data["_this"] = $this;
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('stock_controls/v_view');
        echo view('v_footer');
        echo view('stock_controls/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->stock_controls->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting stock control"]);
        return redirect()->to(base_url() . '/stock_controls');
    }
}
