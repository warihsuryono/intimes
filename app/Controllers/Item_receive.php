<?php

namespace App\Controllers;

use App\Models\m_item_receive;
use App\Models\m_item_receive_detail;
use App\Models\m_item_history;
use App\Models\m_supplier;
use App\Models\m_item;
use App\Models\m_currency;
use App\Models\m_po;
use App\Models\m_po_detail;
use App\Models\m_unit;

class Item_receive extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $item_receives;
    protected $item_receive_details;
    protected $item_histories;
    protected $po_;
    protected $po_detail;
    protected $suppliers;
    protected $items;
    protected $currencies;
    protected $units;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "item_receives";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->item_receives =  new m_item_receive();
        $this->item_receive_details =  new m_item_receive_detail();
        $this->item_histories =  new m_item_history();
        $this->po_ =  new m_po();
        $this->po_detail =  new m_po_detail();
        $this->suppliers =  new m_supplier();
        $this->items =  new m_item();
        $this->currencies =  new m_currency();
        $this->units =  new m_unit();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Item Receive";
        $data["_this"] = $this;
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["item_receive_no"]) && $_GET["item_receive_no"] != "")
            $wherclause .= "AND item_receive_no LIKE '%" . $_GET["item_receive_no"] . "%'";

        if (isset($_GET["po_no"]) && $_GET["po_no"] != "")
            $wherclause .= "AND po_no LIKE '%" . $_GET["po_no"] . "%'";

        if (isset($_GET["supplier_id"]) && $_GET["supplier_id"] != "")
            $wherclause .= "AND supplier_id = '" . $_GET["supplier_id"] . "'";

        if (isset($_GET["description"]) && $_GET["description"] != "")
            $wherclause .= "AND description LIKE '%" . $_GET["description"] . "%'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        if (isset($_GET["is_approved"]) && $_GET["is_approved"] != "")
            $wherclause .= "AND is_approved = '" . $_GET["is_approved"] . "'";


        $item_receives = $this->item_receives->where($wherclause)->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        $numrow = count($this->item_receives->where($wherclause)->findAll());

        foreach ($item_receives as $item_receive) {
            $item_receive_detail[$item_receive->id]["supplier"] = @$this->suppliers->where("id", $item_receive->supplier_id)->get()->getResult()[0]->company_name;
            $item_receive_detail[$item_receive->id]["po"] = @$this->po_->where("id", $item_receive->po_id)->get()->getResult()[0];
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["suppliers"] = $this->suppliers->where("is_deleted", 0)->findAll();
        $data["item_receives"] = $item_receives;
        $data["item_receive_detail"] = @$item_receive_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_receives/v_list');
        echo view('v_footer');
    }

    public function get_item_receive_no()
    {
        $item_receive_no = $this->letter_no_template("letter_receive_temp");
        $item_receive_seqno = @$this->item_receives->where("item_receive_no LIKE '" . $item_receive_no . "'")->where("is_deleted", 0)->orderBy("id DESC")->findAll()[0]->item_receive_no;
        if ($item_receive_seqno == "")
            $item_receive_no = str_replace("%", "001", $item_receive_no);
        else {
            $item_receive_temp = str_replace("%", "", $item_receive_no);
            $seqno = str_replace($item_receive_temp, "", $item_receive_seqno) * 1;
            $seqno++;
            $item_receive_no = str_replace("%", $this->numberpad($seqno, 3), $item_receive_no);
        }
        return $item_receive_no;
    }

    public function saving_data()
    {
        $po_no = @$_POST["po_no"];
        if (@$_POST["po_no"] != "") {
            $po_no = str_replace(" ", "", urldecode(@$_POST["po_no"]));
            if (stripos($po_no, "Rev") > 0) {
                $revisi = str_replace("-", "", explode("Rev", $po_no)[1]) * 1;
                $po_no = explode("Rev", $po_no)[0];
            } else $revisi = 0;
            $po_id = @$this->po_->where("po_no", $po_no)->where("revisi", $revisi)->where("is_deleted", 0)->findAll()[0]->id;
        } else $po_id = 0;
        return [
            "item_receive_no" => @$_POST["item_receive_no"],
            "item_receive_at" => @$_POST["item_receive_at"],
            "po_no" => $po_no,
            "po_id" => $po_id,
            "supplier_id" => @$_POST["supplier_id"],
            "shipment_company" => @$_POST["shipment_company"],
            "shipment_pic" => @$_POST["shipment_pic"],
            "shipment_phone" => @$_POST["shipment_phone"],
            "shipment_address" => @$_POST["shipment_address"],
            "shipment_at" => @$_POST["shipment_at"],
            "description" => @$_POST["description"],
        ];
    }

    public function saving_add()
    {
        if (isset($_POST["Save"])) {
            $_POST["item_receive_no"] = $this->get_item_receive_no();
            $item_receive = $this->saving_data();
            $item_receive = $item_receive + $this->created_values() + $this->updated_values();

            $this->item_receives->save($item_receive);
            $id = $this->item_receives->insertID();
            $po_no = @$_POST["po_no"];
            if (@$_POST["po_no"] != "") {
                $po_no = str_replace(" ", "", urldecode(@$_POST["po_no"]));
                if (stripos($po_no, "Rev") > 0) {
                    $revisi = str_replace("-", "", explode("Rev", $po_no)[1]) * 1;
                    $po_no = explode("Rev", $po_no)[0];
                } else $revisi = 0;
                $po_id = @$this->po_->where("po_no", $po_no)->where("revisi", $revisi)->where("is_deleted", 0)->findAll()[0]->id;
            } else $po_id = 0;

            foreach ($_POST["item_id"] as $key => $item_id) {
                if ($po_id > 0) {
                    $qty_po = @$this->po_detail->select("sum(qty) as qty")->where("is_deleted", 0)->where("po_id", $po_id)->where("item_id", $item_id)->findAll()[0]->qty;
                    $qty_received = @$this->item_receive_details->select("sum(qty) as qty")->where("is_deleted", 0)->where("item_id", $item_id)->where("item_receive_id IN (SELECT id FROM item_receives WHERE po_id='" . $po_id . "' AND is_deleted=0)")->findAll()[0]->qty;
                    $qty_outstanding = $qty_po - $qty_received;
                } else {
                    $qty_po = 0;
                    $qty_received = 0;
                    $qty_outstanding = 0;
                }

                $item_receive_detail = [
                    "item_receive_id" => $id,
                    "po_id" => $po_id,
                    "po_no" => $po_no,
                    "item_id" => $item_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "qty_po" => $qty_po,
                    "qty_outstanding" => $qty_outstanding,
                    "qty" => @$_POST["qty"][$key],
                    "sku" => @$_POST["sku"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $item_receive_detail = $item_receive_detail + $this->created_values() + $this->updated_values();
                $this->item_receive_details->save($item_receive_detail);
            }

            $this->session->setFlashdata("flash_message", ["success", "Success adding Item Receive"]);
            echo "<script> window.location='" . base_url() . "/item_receive/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function saving_edit($id)
    {
        if (isset($_POST["Save"])) {
            $item_receive = $this->saving_data();
            $item_receive = $item_receive + $this->updated_values();
            $this->item_receives->update($id, $item_receive);
            $this->item_receive_details->where('item_receive_id', $id)->delete();
            $po_no = @$_POST["po_no"];
            if (@$_POST["po_no"] != "") {
                $po_no = str_replace(" ", "", urldecode(@$_POST["po_no"]));
                if (stripos($po_no, "Rev") > 0) {
                    $revisi = str_replace("-", "", explode("Rev", $po_no)[1]) * 1;
                    $po_no = explode("Rev", $po_no)[0];
                } else $revisi = 0;
                $po_id = @$this->po_->where("po_no", $po_no)->where("revisi", $revisi)->where("is_deleted", 0)->findAll()[0]->id;
            } else $po_id = 0;

            foreach ($_POST["item_id"] as $key => $item_id) {
                if ($po_id > 0) {
                    $qty_po = @$this->po_detail->select("sum(qty) as qty")->where("is_deleted", 0)->where("po_id", $po_id)->where("item_id", $item_id)->findAll()[0]->qty;
                    $qty_received = @$this->item_receive_details->select("sum(qty) as qty")->where("is_deleted", 0)->where("item_id", $item_id)->where("item_receive_id IN (SELECT id FROM item_receives WHERE po_id='" . $po_id . "' AND is_deleted=0)")->findAll()[0]->qty;
                    $qty_outstanding = $qty_po - $qty_received;
                } else {
                    $qty_po = 0;
                    $qty_received = 0;
                    $qty_outstanding = 0;
                }

                $item_receive_detail = [
                    "item_receive_id" => $id,
                    "po_id" => $po_id,
                    "po_no" => $po_no,
                    "item_id" => $item_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "qty_po" => $qty_po,
                    "qty_outstanding" => $qty_outstanding,
                    "qty" => @$_POST["qty"][$key],
                    "sku" => @$_POST["sku"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $item_receive_detail = $item_receive_detail + $this->created_values() + $this->updated_values();
                $this->item_receive_details->save($item_receive_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success editing item_receive"]);
            echo "<script> window.location='" . base_url() . "/item_receive/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function get_reference_data()
    {
        $data["suppliers"] = $this->suppliers->where("is_deleted", 0)->findAll();
        $data["items"] = $this->items->where("is_deleted", 0)->findAll();
        $data["currencies"] = $this->currencies->where("is_deleted", 0)->findAll();
        $data["units"] = $this->units->where("is_deleted", 0)->findAll();
        return $data;
    }

    public function get_saved_data($id)
    {
        $data["item_receive"] = @$this->item_receives->where("is_deleted", 0)->find([$id])[0];
        $data["item_receive_details"] = @$this->item_receive_details->where(["is_deleted" => 0, "item_receive_id" => $id])->findAll();
        $data["supplier"] = @$this->suppliers->where("id", $data["item_receive"]->supplier_id)->where("is_deleted", 0)->findAll()[0];
        $data["po"] = @$this->po_->where("id", $data["item_receive"]->po_id)->where("is_deleted", 0)->findAll()[0];
        $data["created_user"] = @$this->users->where("email", $data["item_receive"]->created_by)->where("is_deleted", 0)->findAll()[0];
        $data["approved_user"] = @$this->users->where("email", $data["item_receive"]->approved_by)->where("is_deleted", 0)->findAll()[0];
        $item_receive_detail_item = [];
        $item_receive_detail_unit = [];
        foreach ($data["item_receive_details"] as $item_receive_detail) {
            $item_receive_detail_item[$item_receive_detail->item_id] = @$this->items->where("id", $item_receive_detail->item_id)->where("is_deleted", 0)->findAll()[0];
            $item_receive_detail_unit[$item_receive_detail->item_id] = @$this->units->where("id", $item_receive_detail->unit_id)->where("is_deleted", 0)->findAll()[0];
        }
        $data["item_receive_detail_item"] = $item_receive_detail_item;
        $data["item_receive_detail_unit"] = $item_receive_detail_unit;
        return $data;
    }

    public function approve($id)
    {
        if (@$_GET["approving"] == 1) {
            $item_receive = @$this->item_receives->where("is_deleted", 0)->find([$id])[0];
            $this->item_receives->update($id, ["is_approved" => 1, "approved_at" => date("Y-m-d H:i:s"), "approved_by" => $this->session->get("username"), "approved_ip" => $_SERVER["REMOTE_ADDR"]]);
            $item_receive_details = @$this->item_receive_details->where(["is_deleted" => 0, "item_receive_id" => $id])->findAll();
            foreach ($item_receive_details as $item_receive_detail) {
                $qty = $item_receive_detail->qty;
                if ($qty > 0) {
                    $item_id = $item_receive_detail->item_id;
                    $sku = $item_receive_detail->sku;
                    $unit_id = $item_receive_detail->unit_id;
                    $notes = $item_receive_detail->notes;
                    $this->item_histories->save(["in_out" => "in", "item_history_type_id" => 1, "dok_no" => $item_receive->item_receive_no, "item_receive_id" => $id, "item_id" => $item_id, "sku" => $sku, "qty" => $qty, "unit_id" => $unit_id, "notes" => $notes, "is_approved" => 1, "approved_at" => date("Y-m-d H:i:s"), "approved_by" => $this->session->get("username"), "approved_ip" => $_SERVER["REMOTE_ADDR"]]);
                }
            }
            $this->session->setFlashdata("flash_message", ["success", "Success approving Item Receive"]);
            echo "<script> window.location='" . base_url() . "/item_receive/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_GET["po_no"]) && $_GET["po_no"] != "") {
            $this->session->setFlashdata("reload_po", $_GET["po_no"]);
            echo "<script> window.location='" . base_url() . "/item_receive/add'; </script>";
            exit();
        }
        $this->saving_add();

        $data["__modulename"] = "Add Item Receive";
        $data["__mode"] = "add";
        $data["item_receive_no"] = $this->get_item_receive_no();

        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_receives/v_edit');
        echo view('v_footer');
        echo view('item_receives/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        $this->saving_edit($id);
        $data["__modulename"] = "Edit Item Receive";
        $data["__mode"] = "edit";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        if (@$data["po"]->revisi > 0) $data["item_receive"]->po_no .= " Rev-" . $this->numberpad($data["po"]->revisi, 2);
        if (@$data["item_receive"]->is_approved > 0) {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/item_receives');
        }
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_receives/v_edit');
        echo view('v_footer');
        echo view('item_receives/v_js');
    }

    public function view($id)
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);
        $this->approve($id);

        $data["__modulename"] = "Item Receive";
        $data["_this"] = $this;
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('item_receives/v_view');
        echo view('v_footer');
        echo view('item_receives/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->item_receives->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting Item Receive"]);
        return redirect()->to(base_url() . '/item_receives');
    }

    public function get_item_receive($id)
    {
        return json_encode($this->item_receives->where("is_deleted", 0)->find([$id])[0]);
    }

    public function get_item_receive_detail($id)
    {
        return json_encode($this->item_receive_details->where("item_receives_id", $id)->where("is_deleted", 0)->findAll());
    }
}
