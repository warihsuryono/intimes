<?php

namespace App\Controllers;

use App\Models\m_invoice;
use App\Models\m_invoice_detail;
use App\Models\m_customer;
use App\Models\m_item;
use App\Models\m_currency;
use App\Models\m_payment_type;
use App\Models\m_invoice_status;
use App\Models\m_so;
use App\Models\m_unit;

class Invoice extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $invoices;
    protected $invoice_details;
    protected $so_;
    protected $customers;
    protected $items;
    protected $currencies;
    protected $payment_types;
    protected $invoice_statuses;
    protected $units;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "invoices";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->invoices =  new m_invoice();
        $this->invoice_details =  new m_invoice_detail();
        $this->so_ =  new m_so();
        $this->customers =  new m_customer();
        $this->items =  new m_item();
        $this->currencies =  new m_currency();
        $this->payment_types =  new m_payment_type();
        $this->invoice_statuses =  new m_invoice_status();
        $this->units =  new m_unit();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Invoice";
        $data["_this"] = $this;
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["invoice_no"]) && $_GET["invoice_no"] != "")
            $wherclause .= "AND invoice_no LIKE '%" . $_GET["invoice_no"] . "%'";

        if (isset($_GET["so_no"]) && $_GET["so_no"] != "")
            $wherclause .= "AND so_no LIKE '%" . $_GET["so_no"] . "%'";

        if (isset($_GET["customer_id"]) && $_GET["customer_id"] != "")
            $wherclause .= "AND customer_id = '" . $_GET["customer_id"] . "'";

        if (isset($_GET["description"]) && $_GET["description"] != "")
            $wherclause .= "AND description LIKE '%" . $_GET["description"] . "%'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        if (isset($_GET["is_approved"]) && $_GET["is_approved"] != "")
            $wherclause .= "AND is_approved = '" . $_GET["is_approved"] . "'";

        if (isset($_GET["invoice_status_id"]) && $_GET["invoice_status_id"] != "")
            $wherclause .= "AND invoice_status_id = '" . $_GET["invoice_status_id"] . "'";

        $invoices = $this->invoices->where($wherclause)->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        $numrow = count($this->invoices->where($wherclause)->findAll());

        foreach ($invoices as $invoice) {
            $invoice_detail[$invoice->id]["customer"] = @$this->customers->where("id", $invoice->customer_id)->get()->getResult()[0]->company_name;
            $invoice_detail[$invoice->id]["payment_type"] = @$this->payment_types->where("id", $invoice->payment_type_id)->get()->getResult()[0]->name;
            $invoice_detail[$invoice->id]["invoice_status"] = @$this->invoice_statuses->where("id", $invoice->invoice_status_id)->get()->getResult()[0]->name;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["customers"] = $this->customers->where("is_deleted", 0)->findAll();
        $data["invoice_statuses"] = $this->invoice_statuses->where("is_deleted", 0)->findAll();
        $data["invoices"] = $invoices;
        $data["invoice_detail"] = @$invoice_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('invoices/v_list');
        echo view('v_footer');
    }

    public function saving_data($mode)
    {
        if (@$_POST["so_no"] != "") $so_id = @$this->so_->where("so_no", @$_POST["so_no"])->get()->getResult()[0]->id;
        else $so_id = "";
        $due_date_at = date('Y-m-d', strtotime(@$_POST["invoice_at"] . ' +' . @$_POST["due_date"] . ' days'));
        return [
            "so_id" => $so_id,
            "so_no" => @$_POST["so_no"],
            "invoice_no" => @$_POST["invoice_no"],
            "invoice_at" => @$_POST["invoice_at"],
            "customer_id" => @$_POST["customer_id"],
            "currency_id" => @$_POST["currency_id"],
            "due_date" => @$_POST["due_date"],
            "due_date_at" => $due_date_at,
            "invoice_status_id" => "1",
            "is_tax" => @$_POST["is_tax"],
            "description" => @$_POST["description"],
            "dp" => @$_POST["dp"],
            "payment_type_id" => @$_POST["payment_type_id"],
            "disc" => @$_POST["disc"],
            "subtotal" => @$_POST["subtotal"],
            "after_disc" => @$_POST["after_disc"],
            "tax" => @$_POST["tax"],
            "total" => @$_POST["total"],
            "total_to_say" => $this->number_to_words(@$_POST["total"]),
        ];
    }

    public function saving_add()
    {
        if (isset($_POST["Save"])) {
            $invoice = $this->saving_data($_POST["mode"]);
            $invoice = $invoice + $this->created_values() + $this->updated_values();

            $this->invoices->save($invoice);
            $id = $this->invoices->insertID();
            foreach ($_POST["item_id"] as $key => $item_id) {
                $invoice_detail = [
                    "invoice_id" => $id,
                    "item_id" => $item_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "qty" => @$_POST["qty"][$key],
                    "price" => @$_POST["price"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $invoice_detail = $invoice_detail + $this->created_values() + $this->updated_values();
                $this->invoice_details->save($invoice_detail);
            }

            if ($_POST["mode"] == "add" && $invoice["so_id"] != "")
                $this->so_->update($invoice["so_id"], ["is_invoice" => 1, "invoice_at" => date("Y-m-d H:i:s"), "invoice_by" => $this->session->get("username"), "invoice_ip" => $_SERVER["REMOTE_ADDR"]]);

            $this->session->setFlashdata("flash_message", ["success", "Success adding Invoice"]);
            echo "<script> window.location='" . base_url() . "/invoice/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function saving_edit($id)
    {
        if (isset($_POST["Save"])) {
            $invoice = $this->saving_data($_POST["mode"]);
            $invoice = $invoice + $this->updated_values();
            $this->invoices->update($id, $invoice);
            $this->invoice_details->where('invoice_id', $id)->delete();
            foreach ($_POST["item_id"] as $key => $item_id) {
                $invoice_detail = [
                    "invoice_id" => $id,
                    "item_id" => $item_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "qty" => @$_POST["qty"][$key],
                    "price" => @$_POST["price"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $invoice_detail = $invoice_detail + $this->created_values() + $this->updated_values();
                $this->invoice_details->save($invoice_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success editing Invoice"]);
            echo "<script> window.location='" . base_url() . "/invoice/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function get_reference_data()
    {
        $data["customers"] = $this->customers->where("is_deleted", 0)->findAll();
        $data["items"] = $this->items->where("is_deleted", 0)->findAll();
        $data["currencies"] = $this->currencies->where("is_deleted", 0)->findAll();
        $data["payment_types"] = $this->payment_types->where("is_deleted", 0)->findAll();
        $data["invoice_statuses"] = $this->invoice_statuses->where("is_deleted", 0)->findAll();
        $data["units"] = $this->units->where("is_deleted", 0)->findAll();
        return $data;
    }

    public function get_saved_data($id)
    {
        $data["invoice"] = $this->invoices->where("is_deleted", 0)->find([$id])[0];
        $data["invoice_details"] = $this->invoice_details->where(["is_deleted" => 0, "invoice_id" => $id])->findAll();
        $data["customer"] = @$this->customers->where("id", $data["invoice"]->customer_id)->where("is_deleted", 0)->findAll()[0];
        $data["so"] = @$this->so_->where("id", $data["invoice"]->so_no)->where("is_deleted", 0)->findAll()[0];
        $data["invoice_status"] = @$this->invoice_statuses->where("id", $data["invoice"]->invoice_status_id)->where("is_deleted", 0)->findAll()[0];
        $data["payment_type"] = @$this->payment_types->where("id", $data["invoice"]->payment_type_id)->where("is_deleted", 0)->findAll()[0];
        $data["currency"] = @$this->currencies->where("id", $data["invoice"]->currency_id)->where("is_deleted", 0)->findAll()[0];
        $data["created_user"] = @$this->users->where("email", $data["invoice"]->created_by)->where("is_deleted", 0)->findAll()[0];
        $data["approved_user"] = @$this->users->where("email", $data["invoice"]->approved_by)->where("is_deleted", 0)->findAll()[0];
        $invoice_detail_item = [];
        $invoice_detail_unit = [];
        foreach ($data["invoice_details"] as $invoice_detail) {
            $invoice_detail_item[$invoice_detail->item_id] = @$this->items->where("id", $invoice_detail->item_id)->where("is_deleted", 0)->findAll()[0];
            $invoice_detail_unit[$invoice_detail->item_id] = @$this->units->where("id", $invoice_detail->unit_id)->where("is_deleted", 0)->findAll()[0];
        }
        $data["invoice_detail_item"] = $invoice_detail_item;
        $data["invoice_detail_unit"] = $invoice_detail_unit;
        return $data;
    }

    public function approve($id)
    {
        if (@$_GET["approving"] == 1) {
            $this->invoices->update($id, ["is_approved" => 1, "approved_at" => date("Y-m-d H:i:s"), "approved_by" => $this->session->get("username"), "approved_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Invoice"]);
            echo "<script> window.location='" . base_url() . "/invoice/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_GET["so_no"]) && $_GET["so_no"] != "") {
            $this->session->setFlashdata("reload_so", $_GET["so_no"]);
            echo "<script> window.location='" . base_url() . "/invoice/add'; </script>";
            exit();
        }
        $this->saving_add();

        $data["__modulename"] = "Add Invoice";
        $data["__mode"] = "add";

        $invoice_no = str_replace(["{seqno}", "{year}"], ["%", date("Y")], $this->invoice_no_template());
        $invoice_seqno = @$this->invoices->where("invoice_no LIKE '" . $invoice_no . "'")->where("is_deleted", 0)->orderBy("id DESC")->findAll()[0]->invoice_no;
        if ($invoice_seqno == "")
            $invoice_no = str_replace("%", "001", $invoice_no);
        else {
            $invoice_temp = str_replace("%", "", $invoice_no);
            $seqno = str_replace($invoice_temp, "", $invoice_seqno) * 1;
            $seqno++;
            $invoice_no = str_replace("%", $this->numberpad($seqno, 3), $invoice_no);
        }
        $data["invoice_no"] = $invoice_no;

        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('invoices/v_edit');
        echo view('v_footer');
        echo view('invoices/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        $this->saving_edit($id);
        $data["__modulename"] = "Edit Invoice";
        $data["__mode"] = "edit";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        if ($data["invoice"]->is_approved > 0) {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/invoices');
        }
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('invoices/v_edit');
        echo view('v_footer');
        echo view('invoices/v_js');
    }

    public function view($id)
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);
        $this->approve($id);

        $data["__modulename"] = "Invoice";
        $data["_this"] = $this;
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('invoices/v_view');
        echo view('v_footer');
        echo view('invoices/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->invoices->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting Invoice"]);
        return redirect()->to(base_url() . '/invoices');
    }

    public function get_invoice($id)
    {
        return json_encode($this->invoices->where("is_deleted", 0)->find([$id])[0]);
    }

    public function get_invoice_detail($id)
    {
        return json_encode($this->invoice_details->where("invoice_id", $id)->where("is_deleted", 0)->findAll());
    }
}
