<?php

namespace App\Controllers;

use App\Models\m_customer_po;
use App\Models\m_customer_po_detail;
use App\Models\m_customer;
use App\Models\m_item;
use App\Models\m_currency;
use App\Models\m_payment_type;
use App\Models\m_unit;

class Customer_po extends BaseController
{
    protected $customer_po_;
    protected $customer_po_details;
    protected $customers;
    protected $items;
    protected $currencies;
    protected $payment_types;
    protected $units;

    public function __construct()
    {
        parent::__construct();
        $this->customer_po_ =  new m_customer_po();
        $this->customer_po_details =  new m_customer_po_detail();
        $this->customers =  new m_customer();
        $this->items =  new m_item();
        $this->currencies =  new m_currency();
        $this->payment_types =  new m_payment_type();
        $this->units =  new m_unit();
    }

    public function index()
    {

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Customer PO";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["po_no"]) && $_GET["po_no"] != "")
            $wherclause .= "AND po_no LIKE '%" . $_GET["po_no"] . "%'";

        if (isset($_GET["quotation_no"]) && $_GET["quotation_no"] != "")
            $wherclause .= "AND quotation_no LIKE '%" . $_GET["quotation_no"] . "%'";

        if (isset($_GET["customer_id"]) && $_GET["customer_id"] != "")
            $wherclause .= "AND customer_id = '" . $_GET["customer_id"] . "'";

        if (isset($_GET["description"]) && $_GET["description"] != "")
            $wherclause .= "AND description LIKE '%" . $_GET["description"] . "%'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        $customer_po_ = $this->customer_po_->where($wherclause)->findAll(MAX_ROW, $startrow);

        $numrow = count($this->customer_po_->where($wherclause)->findAll());

        foreach ($customer_po_ as $customer_po) {
            $customer_po_detail[$customer_po->id]["customer"] = $this->customers->where("id", $customer_po->customer_id)->get()->getResult()[0]->company_name;
            $customer_po_detail[$customer_po->id]["payment_type"] = $this->payment_types->where("id", $customer_po->payment_type_id)->get()->getResult()[0]->name;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["customers"] = $this->customers->where("is_deleted", 0)->findAll();
        $data["customer_po_"] = $customer_po_;
        $data["customer_po_detail"] = @$customer_po_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('customer_po_/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        if (isset($_POST["Save"])) {
            $customer_po = [
                "po_no" => @$_POST["po_no"],
                "quotation_no" => @$_POST["quotation_no"],
                "customer_id" => @$_POST["customer_id"],
                "currency_id" => @$_POST["currency_id"],
                "is_tax" => @$_POST["is_tax"],
                "po_received_at" => @$_POST["po_received_at"],
                "description" => @$_POST["description"],
                "shipment_pic" => @$_POST["shipment_pic"],
                "shipment_phone" => @$_POST["shipment_phone"],
                "shipment_address" => @$_POST["shipment_address"],
                "shipment_at" => @$_POST["shipment_at"],
                "dp" => @$_POST["dp"],
                "payment_type_id" => @$_POST["payment_type_id"],
                "subtotal" => @$_POST["subtotal"],
                "disc" => @$_POST["disc"],
                "after_disc" => @$_POST["after_disc"],
                "tax" => @$_POST["tax"],
                "total" => @$_POST["total"],
            ];
            $customer_po = $customer_po + $this->created_values() + $this->updated_values();
            $this->customer_po_->save($customer_po);
            $id = $this->customer_po_->insertID();
            foreach ($_POST["item_id"] as $key => $item_id) {
                $customer_po_detail = [
                    "po_id" => $id,
                    "item_id" => $item_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "qty" => @$_POST["qty"][$key],
                    "price" => @$_POST["price"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $customer_po_detail = $customer_po_detail + $this->created_values() + $this->updated_values();
                $this->customer_po_details->save($customer_po_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success adding Customer PO"]);
            return redirect()->to('/customer_po');
        }

        $data["__modulename"] = "Add Customer PO";
        $data["customers"] = $this->customers->where("is_deleted", 0)->findAll();
        $data["items"] = $this->items->where("is_deleted", 0)->findAll();
        $data["currencies"] = $this->currencies->where("is_deleted", 0)->findAll();
        $data["payment_types"] = $this->payment_types->where("is_deleted", 0)->findAll();
        $data["units"] = $this->units->where("is_deleted", 0)->findAll();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('customer_po_/v_edit');
        echo view('v_footer');
        echo view('customer_po_/v_js');
    }

    public function edit($id)
    {
        if (isset($_POST["Save"])) {
            $customer_po = [
                "po_no" => @$_POST["po_no"],
                "quotation_no" => @$_POST["quotation_no"],
                "customer_id" => @$_POST["customer_id"],
                "currency_id" => @$_POST["currency_id"],
                "is_tax" => @$_POST["is_tax"],
                "po_received_at" => @$_POST["po_received_at"],
                "description" => @$_POST["description"],
                "shipment_pic" => @$_POST["shipment_pic"],
                "shipment_phone" => @$_POST["shipment_phone"],
                "shipment_address" => @$_POST["shipment_address"],
                "shipment_at" => @$_POST["shipment_at"],
                "dp" => @$_POST["dp"],
                "payment_type_id" => @$_POST["payment_type_id"],
                "subtotal" => @$_POST["subtotal"],
                "disc" => @$_POST["disc"],
                "after_disc" => @$_POST["after_disc"],
                "tax" => @$_POST["tax"],
                "total" => @$_POST["total"],
            ];
            $customer_po = $customer_po + $this->updated_values();
            $this->customer_po_->update($id, $customer_po);
            $this->customer_po_details->where('po_id', $id)->delete();
            foreach ($_POST["item_id"] as $key => $item_id) {
                $customer_po_detail = [
                    "po_id" => $id,
                    "item_id" => $item_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "qty" => @$_POST["qty"][$key],
                    "price" => @$_POST["price"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $customer_po_detail = $customer_po_detail + $this->created_values() + $this->updated_values();
                $this->customer_po_details->save($customer_po_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success editing customer PO"]);
            return redirect()->to('/customer_po');
        }

        $data["__modulename"] = "Edit Customer PO";
        $data["customers"] = $this->customers->where("is_deleted", 0)->findAll();
        $data["items"] = $this->items->where("is_deleted", 0)->findAll();
        $data["currencies"] = $this->currencies->where("is_deleted", 0)->findAll();
        $data["payment_types"] = $this->payment_types->where("is_deleted", 0)->findAll();
        $data["units"] = $this->units->where("is_deleted", 0)->findAll();
        $data["customer_po"] = $this->customer_po_->where("is_deleted", 0)->find([$id])[0];
        $data["customer_po_details"] = $this->customer_po_details->where(["is_deleted" => 0, "po_id" => $id])->findAll();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('customer_po_/v_edit');
        echo view('v_footer');
        echo view('customer_po_/v_js');
    }

    public function delete($id)
    {
        $this->customer_po_->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting customer PO"]);
        return redirect()->to('/customer_po');
    }

    public function get_customer_po($id)
    {
        return json_encode($this->customer_po_->where("is_deleted", 0)->find([$id])[0]);
    }

    public function get_customer_po_detail($id)
    {
        return json_encode($this->customer_po_details->where("po_id", $id)->where("is_deleted", 0)->findAll());
    }
}
