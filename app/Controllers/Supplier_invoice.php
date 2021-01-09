<?php

namespace App\Controllers;

use App\Models\m_po;
use App\Models\m_po_detail;
use App\Models\m_supplier;
use App\Models\m_item;
use App\Models\m_currency;
use App\Models\m_supplier_invoice;
use App\Models\m_supplier_invoice_detail;
use App\Models\m_supplier_invoice_status;
use App\Models\m_payment_type;
use App\Models\m_unit;

class Supplier_invoice extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $supplier_invoices;
    protected $supplier_invoice_details;
    protected $po_;
    protected $po_details;
    protected $suppliers;
    protected $items;
    protected $currencies;
    protected $payment_types;
    protected $units;
    protected $supplier_invoice_statuses;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "supplier_invoices";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->supplier_invoices =  new m_supplier_invoice();
        $this->supplier_invoice_details =  new m_supplier_invoice_detail();
        $this->po_ =  new m_po();
        $this->po_details =  new m_po_detail();
        $this->suppliers =  new m_supplier();
        $this->items =  new m_item();
        $this->currencies =  new m_currency();
        $this->payment_types =  new m_payment_type();
        $this->units =  new m_unit();
        $this->supplier_invoice_statuses =  new m_supplier_invoice_status();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "supplier_invoices";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["invoice_no"]) && $_GET["invoice_no"] != "")
            $wherclause .= "AND supplier_invoice_no LIKE '%" . $_GET["invoice_no"] . "%'";

        if (isset($_GET["po_no"]) && $_GET["po_no"] != "")
            $wherclause .= "AND po_no LIKE '%" . $_GET["po_no"] . "%'";

        if (isset($_GET["supplier_id"]) && $_GET["supplier_id"] != "")
            $wherclause .= "AND supplier_id = '" . $_GET["supplier_id"] . "'";

        if (isset($_GET["issued_at"]) && $_GET["issued_at"] != "")
            $wherclause .= "AND issued_at = '" . $_GET["issued_at"] . "'";

        if (isset($_GET["due_date_at"]) && $_GET["due_date_at"] != "")
            $wherclause .= "AND due_date_at = '" . $_GET["due_date_at"] . "'";

        if (isset($_GET["description"]) && $_GET["description"] != "")
            $wherclause .= "AND description LIKE '%" . $_GET["description"] . "%'";

        if (isset($_GET["invoice_status_id"]) && $_GET["invoice_status_id"] != "")
            $wherclause .= "AND invoice_status_id = '" . $_GET["invoice_status_id"] . "'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        $supplier_invoices = $this->supplier_invoices->where($wherclause)->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        $numrow = count($this->supplier_invoices->where($wherclause)->findAll());

        foreach ($supplier_invoices as $supplier_invoice) {
            $supplier_invoice_detail[$supplier_invoice->id]["supplier"] = @$this->suppliers->where("id", $supplier_invoice->supplier_id)->get()->getResult()[0]->company_name;
            $supplier_invoice_detail[$supplier_invoice->id]["payment_type"] = $this->payment_types->where("id", $supplier_invoice->payment_type_id)->get()->getResult()[0]->name;
            $supplier_invoice_detail[$supplier_invoice->id]["status"] = @$this->supplier_invoice_statuses->where("id", $supplier_invoice->invoice_status_id)->get()->getResult()[0]->name;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["suppliers"] = $this->suppliers->where("is_deleted", 0)->findAll();
        $data["po_"] = $this->po_->where("is_deleted", 0)->findAll();
        $data["supplier_invoice_statuses"] = $this->supplier_invoice_statuses->where("is_deleted", 0)->findAll();
        $data["supplier_invoices"] = $supplier_invoices;
        $data["supplier_invoice_detail"] = @$supplier_invoice_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('supplier_invoices/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $supplier_invoice_no = $this->generate_supplier_invoice_no();
            $po_no = $this->po_->where("is_deleted", 0)->find([$_POST["po_id"]])[0]->po_no;
            $due_date_at = date("Y-m-d", strtotime(@$_POST["issued_at"] . " +" . @$_POST["due_date"] . " days"));
            $supplier_invoice = [
                "invoice_no" => $supplier_invoice_no,
                "po_id" => @$_POST["po_id"],
                "po_no" => $po_no,
                "supplier_id" => @$_POST["supplier_id"],
                "currency_id" => @$_POST["currency_id"],
                "issued_at" => @$_POST["issued_at"],
                "payment_type_id" => @$_POST["payment_type_id"],
                "due_date" => @$_POST["due_date"],
                "due_date_at" => $due_date_at,
                "description" => @$_POST["description"],
                "subtotal" => @$_POST["subtotal"],
                "is_tax" => @$_POST["is_tax"],
                "tax" => @$_POST["tax"],
                "total" => @$_POST["total"],
                "invoice_status_id" => "1",
                "is_paid" => "0",
            ];
            $supplier_invoice = $supplier_invoice + $this->created_values() + $this->updated_values();
            $this->supplier_invoices->save($supplier_invoice);
            $id = $this->supplier_invoices->insertID();
            foreach ($_POST["item_id"] as $key => $item_id) {
                $supplier_invoice_detail = [
                    "invoice_id" => $id,
                    "item_id" => $item_id,
                    "item" => @$_POST["item"][$key],
                    "unit_id" => @$_POST["unit_id"][$key],
                    "qty" => @$_POST["qty"][$key],
                    "price" => @$_POST["price"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $supplier_invoice_detail = $supplier_invoice_detail + $this->created_values() + $this->updated_values();
                $this->supplier_invoice_details->save($supplier_invoice_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success adding supplier_invoice"]);
            return redirect()->to(base_url() . '/supplier_invoices');
        }

        $data["__modulename"] = "Add supplier_invoice";
        $data["po_"] = $this->po_->where("is_deleted", 0)->findAll();
        $data["suppliers"] = $this->suppliers->where("is_deleted", 0)->findAll();
        $data["items"] = $this->items->where("is_deleted", 0)->findAll();
        $data["currencies"] = $this->currencies->where("is_deleted", 0)->findAll();
        $data["payment_types"] = $this->payment_types->where("is_deleted", 0)->findAll();
        $data["units"] = $this->units->where("is_deleted", 0)->findAll();
        $data["generate_supplier_invoice_no"] = $this->generate_supplier_invoice_no();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('supplier_invoices/v_edit');
        echo view('v_footer');
        echo view('supplier_invoices/v_js');
    }

    public function loadVieweditData($id)
    {
        $data["po_"] = $this->po_->where("is_deleted", 0)->findAll();
        $data["suppliers"] = $this->suppliers->where("is_deleted", 0)->findAll();
        $data["items"] = $this->items->where("is_deleted", 0)->findAll();
        $data["currencies"] = $this->currencies->where("is_deleted", 0)->findAll();
        $data["payment_types"] = $this->payment_types->where("is_deleted", 0)->findAll();
        $data["units"] = $this->units->where("is_deleted", 0)->findAll();
        $data["supplier_invoice"] = $this->supplier_invoices->where("is_deleted", 0)->find([$id])[0];
        $data["supplier_invoice_details"] = $this->supplier_invoice_details->where(["is_deleted" => 0, "invoice_id" => $id])->findAll();
        $data["generate_supplier_invoice_no"] = $data["supplier_invoice"]->invoice_no;
        $data = $data + $this->common();
        return $data;
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if ($this->supplier_invoices->where("is_deleted", 0)->find([$id])[0]->invoice_status_id > 1) {
            $this->session->setFlashdata("flash_message", ["error", "The supplier_invoice cannot be edit any more"]);
            return redirect()->to(base_url() . '/supplier_invoices');
        }
        if (isset($_POST["Save"])) {
            $po_no = $this->po_->where("is_deleted", 0)->find([$_POST["po_id"]])[0]->po_no;
            $due_date_at = date("Y-m-d", strtotime(@$_POST["issued_at"] . " +" . @$_POST["due_date"] . " days"));
            $supplier_invoice = [
                "po_id" => @$_POST["po_id"],
                "po_no" => $po_no,
                "supplier_id" => @$_POST["supplier_id"],
                "currency_id" => @$_POST["currency_id"],
                "issued_at" => @$_POST["issued_at"],
                "payment_type_id" => @$_POST["payment_type_id"],
                "due_date" => @$_POST["due_date"],
                "due_date_at" => $due_date_at,
                "description" => @$_POST["description"],
                "subtotal" => @$_POST["subtotal"],
                "is_tax" => @$_POST["is_tax"],
                "tax" => @$_POST["tax"],
                "total" => @$_POST["total"],
            ];
            $supplier_invoice = $supplier_invoice + $this->updated_values();
            $this->supplier_invoices->update($id, $supplier_invoice);
            $this->supplier_invoice_details->where('invoice_id', $id)->delete();
            foreach ($_POST["item_id"] as $key => $item_id) {
                $supplier_invoice_detail = [
                    "invoice_id" => $id,
                    "item_id" => $item_id,
                    "item" => @$_POST["item"][$key],
                    "unit_id" => @$_POST["unit_id"][$key],
                    "qty" => @$_POST["qty"][$key],
                    "price" => @$_POST["price"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $supplier_invoice_detail = $supplier_invoice_detail + $this->created_values() + $this->updated_values();
                $this->supplier_invoice_details->save($supplier_invoice_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success editing supplier_invoice"]);
            return redirect()->to(base_url() . '/supplier_invoices');
        }
        $data["__modulename"] = "Edit supplier_invoice";
        $data = $data + $this->loadVieweditData($id);
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('supplier_invoices/v_edit');
        echo view('v_footer');
        echo view('supplier_invoices/v_js');
    }

    public function view($id)
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);
        if (isset($_GET["action_invoice_status_id"]) && $_GET["action_invoice_status_id"] != "") {
            $this->supplier_invoices->update($id, ["invoice_status_id" => $_GET["action_invoice_status_id"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success Update supplier_invoice status"]);
            return redirect()->to(base_url() . '/supplier_invoice/view/' . $id);
        }
        $data["__modulename"] = "supplier_invoice";
        $data["_this"] = $this;
        $data["supplier_invoice_statuses"] = $this->supplier_invoice_statuses->where("is_deleted", 0)->findAll();
        $data = $data + $this->loadVieweditData($id);
        $supplier = @$this->suppliers->where("is_deleted", 0)->find([$data["supplier_invoice"]->supplier_id])[0];
        foreach ($data["supplier_invoice_details"] as $_supplier_invoice_detail) {
            $supplier_invoice_detail[$_supplier_invoice_detail->id]["unit"] = @$this->units->where("id", $_supplier_invoice_detail->unit_id)->get()->getResult()[0];
            $supplier_invoice_detail[$_supplier_invoice_detail->id]["item"] = @$this->items->where("id", $_supplier_invoice_detail->item_id)->get()->getResult()[0];
            $supplier_invoice_detail[$_supplier_invoice_detail->id]["subtotal"] = @$_supplier_invoice_detail->qty * @$_supplier_invoice_detail->price;
        }
        $data = $data + ["supplier" => $supplier];
        $data = $data + ["supplier_invoice_detail_details" => $supplier_invoice_detail];
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('supplier_invoices/v_view');
        echo view('v_footer');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->supplier_invoices->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting supplier_invoice"]);
        return redirect()->to(base_url() . '/supplier_invoices');
    }

    public function generate_supplier_invoice_no()
    {
        $template = str_replace(["{month}", "{year}", "{seqno}"], [$this->numberToRoman(date("m") * 1), date("Y"), "%"], $this->invoice_no_template());
        if ($supplier_invoice_no = $this->supplier_invoices->where("invoice_no LIKE '" . $template . "'")->orderBY("invoice_no DESC")->get()->getResult()) {
            $supplier_invoice_no = $supplier_invoice_no[0]->invoice_no;
            $template = str_replace("%", "", $template);
            $seqno = str_replace($template, "", $supplier_invoice_no) * 1;
            $seqno++;
            $supplier_invoice_no = $template . str_pad($seqno, 3, "0", STR_PAD_LEFT);
        } else {
            $supplier_invoice_no = str_replace("%", "001", $template);
        }
        return $supplier_invoice_no;
    }
}
