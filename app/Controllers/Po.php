<?php

namespace App\Controllers;

use App\Models\m_po;
use App\Models\m_po_detail;
use App\Models\m_item_receive;
use App\Models\m_item_receive_detail;
use App\Models\m_supplier;
use App\Models\m_item;
use App\Models\m_currency;
use App\Models\m_payment_type;
use App\Models\m_pr;
use App\Models\m_unit;
use App\Models\m_price_condition;

class Po extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $po_;
    protected $po_details;
    protected $item_receives;
    protected $item_receive_details;
    protected $pr_;
    protected $suppliers;
    protected $items;
    protected $currencies;
    protected $payment_types;
    protected $units;
    protected $price_conditions;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "po";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->po_ =  new m_po();
        $this->po_details =  new m_po_detail();
        $this->item_receives =  new m_item_receive();
        $this->item_receive_details =  new m_item_receive_detail();
        $this->pr_ =  new m_pr();
        $this->suppliers =  new m_supplier();
        $this->items =  new m_item();
        $this->currencies =  new m_currency();
        $this->payment_types =  new m_payment_type();
        $this->units =  new m_unit();
        $this->price_conditions =  new m_price_condition();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Supplier PO";
        $data["_this"] = $this;
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["po_no"]) && $_GET["po_no"] != "")
            $wherclause .= "AND po_no LIKE '%" . $_GET["po_no"] . "%'";

        if (isset($_GET["quotation_no"]) && $_GET["quotation_no"] != "")
            $wherclause .= "AND quotation_no LIKE '%" . $_GET["quotation_no"] . "%'";

        if (isset($_GET["supplier_id"]) && $_GET["supplier_id"] != "")
            $wherclause .= "AND supplier_id = '" . $_GET["supplier_id"] . "'";

        if (isset($_GET["description"]) && $_GET["description"] != "")
            $wherclause .= "AND description LIKE '%" . $_GET["description"] . "%'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        if (isset($_GET["is_approved"]) && $_GET["is_approved"] != "")
            $wherclause .= "AND is_approved = '" . $_GET["is_approved"] . "'";

        if (isset($_GET["is_authorized"]) && $_GET["is_authorized"] != "")
            $wherclause .= "AND is_authorized = '" . $_GET["is_authorized"] . "'";

        $po_ = $this->po_->where($wherclause)->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        $numrow = count($this->po_->where($wherclause)->findAll());

        foreach ($po_ as $po) {
            $po_detail[$po->id]["supplier"] = @$this->suppliers->where("id", $po->supplier_id)->get()->getResult()[0]->company_name;
            $po_detail[$po->id]["payment_type"] = @$this->payment_types->where("id", $po->payment_type_id)->get()->getResult()[0]->name;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["suppliers"] = $this->suppliers->where("is_deleted", 0)->findAll();
        $data["po_"] = $po_;
        $data["po_detail"] = @$po_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('po_/v_list');
        echo view('v_footer');
    }

    public function get_po_no()
    {
        $po_no = $this->letter_no_template("letter_po_temp");
        $po_seqno = @$this->po_->where("po_no LIKE '" . $po_no . "'")->where("is_deleted", 0)->orderBy("id DESC")->findAll()[0]->po_no;
        if ($po_seqno == "")
            $po_no = str_replace("%", "001", $po_no);
        else {
            $po_temp = str_replace("%", "", $po_no);
            $seqno = str_replace($po_temp, "", $po_seqno) * 1;
            $seqno++;
            $po_no = str_replace("%", $this->numberpad($seqno, 3), $po_no);
        }
        return $po_no;
    }

    public function saving_data($mode)
    {
        if (@$_POST["pr_no"] != "") $pr_id = @$this->pr_->where("pr_no", @$_POST["pr_no"])->get()->getResult()[0]->id;
        else $pr_id = "";
        if (@$_POST["total_to_say_lang"] == "en") $total_to_say = $this->number_to_words(@$_POST["total"]);
        else $total_to_say = $this->angka_kalimat(@$_POST["total"]);
        return [
            "pr_id" => $pr_id,
            "pr_no" => @$_POST["pr_no"],
            "po_no" => @$_POST["po_no"],
            "revisi" => @$_POST["revisi"],
            "po_at" => @$_POST["po_at"],
            "supplier_id" => @$_POST["supplier_id"],
            "currency_id" => @$_POST["currency_id"],
            "is_tax" => @$_POST["is_tax"],
            "description" => @$_POST["description"],
            "shipment_company" => @$_POST["shipment_company"],
            "shipment_pic" => @$_POST["shipment_pic"],
            "shipment_phone" => @$_POST["shipment_phone"],
            "shipment_address" => @$_POST["shipment_address"],
            "shipment_at" => @$_POST["shipment_at"],
            "dp" => @$_POST["dp"],
            "payment_type_id" => @$_POST["payment_type_id"],
            "disc" => @$_POST["disc"],
            "subtotal" => @$_POST["subtotal"],
            "after_disc" => @$_POST["after_disc"],
            "tax" => @$_POST["tax"],
            "total" => @$_POST["total"],
            "total_to_say" => $total_to_say,
            "total_to_say_lang" => @$_POST["total_to_say_lang"],
            "bank_notes" => @$_POST["bank_notes"],
        ];
    }

    public function saving_add_revision()
    {
        if (isset($_POST["Save"])) {
            if ($_POST["mode"] == "add") $_POST["po_no"] = $this->get_po_no();
            $po = $this->saving_data($_POST["mode"]);
            if ($_POST["mode"] == "revision") {
                $created = $this->po_->where("po_no", $_POST["po_no"])->where("revisi", 0)->findAll()[0];
                $created_at = $created->created_at;
                $created_by = $created->created_by;
                $created_ip = $created->created_ip;
                $po = $po + ["created_at" => $created_at, "created_by" => $created_by, "created_ip" => $created_ip];
                $po = $po + ["revised_at" => date("Y-m-d H:i:s"), "revised_by" => $this->session->get("username"), "revised_ip" => $_SERVER["REMOTE_ADDR"]];
            } else $po = $po + $this->created_values();

            $po = $po + $this->updated_values();

            $this->po_->save($po);
            $id = $this->po_->insertID();
            foreach ($_POST["item_id"] as $key => $item_id) {
                $po_detail = [
                    "po_id" => $id,
                    "item_id" => $item_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "qty" => @$_POST["qty"][$key],
                    "price" => @$_POST["price"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $po_detail = $po_detail + $this->created_values() + $this->updated_values();
                $this->po_details->save($po_detail);
            }

            if ($_POST["mode"] == "add" && $po["pr_id"] != "")
                $this->pr_->update($po["pr_id"], ["is_po" => 1, "po_at" => date("Y-m-d H:i:s"), "po_by" => $this->session->get("username"), "po_ip" => $_SERVER["REMOTE_ADDR"]]);

            $this->session->setFlashdata("flash_message", ["success", "Success adding supplier PO"]);
            echo "<script> window.location='" . base_url() . "/po/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function saving_edit($id)
    {
        if (isset($_POST["Save"])) {
            $po = $this->saving_data($_POST["mode"]);
            $po = $po + $this->updated_values();
            $this->po_->update($id, $po);
            $this->po_details->where('po_id', $id)->delete();
            foreach ($_POST["item_id"] as $key => $item_id) {
                $po_detail = [
                    "po_id" => $id,
                    "item_id" => $item_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "qty" => @$_POST["qty"][$key],
                    "price" => @$_POST["price"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $po_detail = $po_detail + $this->created_values() + $this->updated_values();
                $this->po_details->save($po_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success editing supplier PO"]);
            echo "<script> window.location='" . base_url() . "/po/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function get_reference_data()
    {
        $data["suppliers"] = $this->suppliers->where("is_deleted", 0)->findAll();
        $data["price_conditions"] = $this->price_conditions->where("is_deleted", 0)->findAll();
        $data["items"] = $this->items->where("is_deleted", 0)->findAll();
        $data["currencies"] = $this->currencies->where("is_deleted", 0)->findAll();
        $data["payment_types"] = $this->payment_types->where("is_deleted", 0)->findAll();
        $data["units"] = $this->units->where("is_deleted", 0)->findAll();
        return $data;
    }

    public function get_saved_data($id)
    {
        $data["po"] = $this->po_->where("is_deleted", 0)->find([$id])[0];
        $data["po_details"] = $this->po_details->where(["is_deleted" => 0, "po_id" => $id])->findAll();
        $data["supplier"] = @$this->suppliers->where("id", $data["po"]->supplier_id)->where("is_deleted", 0)->findAll()[0];
        $data["payment_type"] = @$this->payment_types->where("id", $data["po"]->payment_type_id)->where("is_deleted", 0)->findAll()[0];
        $data["currency"] = @$this->currencies->where("id", $data["po"]->currency_id)->where("is_deleted", 0)->findAll()[0];
        $data["created_user"] = @$this->users->where("email", $data["po"]->created_by)->where("is_deleted", 0)->findAll()[0];
        $data["approved_user"] = @$this->users->where("email", $data["po"]->approved_by)->where("is_deleted", 0)->findAll()[0];
        $data["authorized_user"] = @$this->users->where("email", $data["po"]->authorized_by)->where("is_deleted", 0)->findAll()[0];
        $po_detail_item = [];
        $po_detail_unit = [];
        foreach ($data["po_details"] as $po_detail) {
            $po_detail_item[$po_detail->item_id] = @$this->items->where("id", $po_detail->item_id)->where("is_deleted", 0)->findAll()[0];
            $po_detail_unit[$po_detail->item_id] = @$this->units->where("id", $po_detail->unit_id)->where("is_deleted", 0)->findAll()[0];
        }
        $data["po_detail_item"] = $po_detail_item;
        $data["po_detail_unit"] = $po_detail_unit;
        return $data;
    }

    public function approve_authorize($id)
    {
        if (@$_GET["approving"] == 1) {
            $this->po_->update($id, ["is_approved" => 1, "approved_at" => date("Y-m-d H:i:s"), "approved_by" => $this->session->get("username"), "approved_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving PO"]);
            echo "<script> window.location='" . base_url() . "/po/view/" . $id . "'; </script>";
            exit();
        }

        if (@$_GET["authorizing"] == 1) {
            $this->po_->update($id, ["is_authorized" => 1, "authorized_at" => date("Y-m-d H:i:s"), "authorized_by" => $this->session->get("username"), "authorized_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success authorizing PO"]);
            echo "<script> window.location='" . base_url() . "/po/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_GET["pr_no"]) && $_GET["pr_no"] != "") {
            $this->session->setFlashdata("reload_pr", $_GET["pr_no"]);
            echo "<script> window.location='" . base_url() . "/po/add'; </script>";
            exit();
        }
        $this->saving_add_revision();

        $data["__modulename"] = "Add Supplier PO";
        $data["__mode"] = "add";
        $data["po_no"] = $this->get_po_no();
        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('po_/v_edit');
        echo view('v_footer');
        echo view('po_/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        $this->saving_edit($id);
        $data["__modulename"] = "Edit Supplier PO";
        $data["__mode"] = "edit";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        if ($data["po"]->is_approved > 0 || $data["po"]->is_authorized > 0) {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/po');
        }
        $data = $data + ["revisi" => @$this->po_->where("po_no", $data["po"]->po_no)->where("is_deleted", 0)->orderBy("revisi DESC")->findAll()[0]->revisi];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('po_/v_edit');
        echo view('v_footer');
        echo view('po_/v_js');
    }

    public function revision($id)
    {
        $this->saving_add_revision();

        $data["__modulename"] = "Revision Supplier PO";
        $data["__mode"] = "revision";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + ["revisi" => @$this->po_->where("po_no", $data["po"]->po_no)->where("is_deleted", 0)->orderBy("revisi DESC")->findAll()[0]->revisi + 1];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('po_/v_edit');
        echo view('v_footer');
        echo view('po_/v_js');
    }

    public function view($id)
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);
        $this->approve_authorize($id);

        $data["__modulename"] = "Supplier Purchase Order";
        $data["_this"] = $this;
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + ["revisi" => @$this->po_->where("po_no", $data["po"]->po_no)->where("is_deleted", 0)->orderBy("revisi DESC")->findAll()[0]->revisi];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('po_/v_view');
        echo view('v_footer');
        echo view('po_/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->po_->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting supplier PO"]);
        return redirect()->to(base_url() . '/po');
    }

    public function get_po()
    {
        $po_no = str_replace(" ", "", urldecode($_GET["po_no"]));
        if (stripos($po_no, "rev") > 0) {
            $revisi = str_replace("-", "", explode("rev", strtolower($po_no))[1]) * 1;
            $po_no = explode("rev", strtolower($po_no))[0];
        } else $revisi = 0;
        $po = $this->po_->where("po_no", $po_no)->where("revisi", $revisi)->where("is_deleted", 0)->findAll()[0];
        $return = $po;
        $supplier = @$this->suppliers->where("id", $po->supplier_id)->where("is_deleted", 0)->findAll()[0];
        $return->supplier_name = $supplier->company_name;
        return json_encode($return);
    }

    public function get_po_detail($id)
    {
        $return = [];
        $po_details = $this->po_details->where("po_id", $id)->where("is_deleted", 0)->findAll();
        foreach ($po_details as $key => $po_detail) {
            $item = @$this->items->where("id", $po_detail->item_id)->where("is_deleted", 0)->findAll()[0];
            $qty_received = @$this->item_receive_details->select("sum(qty) as qty")->where("is_deleted", 0)->where("item_id", $po_detail->item_id)->where("item_receive_id IN (SELECT id FROM item_receives WHERE po_id='" . $id . "' AND is_deleted=0 AND is_approved=1)")->findAll()[0]->qty;
            $return[$key]["id"] = $po_detail->id;
            $return[$key]["po_id"] = $po_detail->po_id;
            $return[$key]["item_id"] = $po_detail->item_id;
            $return[$key]["item_name"] = @$item->name;
            $return[$key]["unit_id"] = $po_detail->unit_id;
            $return[$key]["qty"] = $po_detail->qty;
            $return[$key]["qty_outstanding"] = $po_detail->qty - $qty_received;
            $return[$key]["notes"] = $po_detail->notes;
        }
        return json_encode($return);
    }
}
