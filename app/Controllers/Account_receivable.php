<?php

namespace App\Controllers;

use App\Models\m_customer_po;
use App\Models\m_customer_po_detail;
use App\Models\m_customer;
use App\Models\m_item;
use App\Models\m_currency;
use App\Models\m_invoice;
use App\Models\m_invoice_detail;
use App\Models\m_invoice_status;
use App\Models\m_payment_type;
use App\Models\m_unit;

class Account_receivable extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $invoices;
    protected $invoice_details;
    protected $customer_po_;
    protected $customer_po_details;
    protected $customers;
    protected $items;
    protected $currencies;
    protected $payment_types;
    protected $units;
    protected $invoice_statuses;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "account_receivable";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->invoices =  new m_invoice();
        $this->invoice_details =  new m_invoice_detail();
        $this->customer_po_ =  new m_customer_po();
        $this->customer_po_details =  new m_customer_po_detail();
        $this->customers =  new m_customer();
        $this->items =  new m_item();
        $this->currencies =  new m_currency();
        $this->payment_types =  new m_payment_type();
        $this->units =  new m_unit();
        $this->invoice_statuses =  new m_invoice_status();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Account Receivable";
        $data["_this"] = $this;
        $startrow = $page * MAX_ROW;

        $tanggal =  (isset($_GET["tanggal"]) && $_GET["tanggal"] != "") ? $_GET["tanggal"] : date("Y-m-d");

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["customer_id"]) && $_GET["customer_id"] != "")
            $wherclause .= "AND customer_id = '" . $_GET["customer_id"] . "'";

        $customers = $this->customers->where($wherclause)->findAll();
        $total = 0;
        foreach ($customers as $customer) {
            $customer_po[$customer->id] = $this->customer_po_->where(["is_deleted" => 0, "customer_id" => $customer->id, "po_received_at <= " => $tanggal])->findAll();
            $detail_data[$customer->id]["saldo_awal"] = $this->customer_po_->selectSum('total')->where(["is_deleted" => 0, "customer_id" => $customer->id, "po_received_at < " => $tanggal])->get()->getResult()[0]->total;
            $detail_data[$customer->id]["penjualan"] = $this->customer_po_->selectSum('total')->where(["is_deleted" => 0, "customer_id" => $customer->id, "po_received_at = " => $tanggal])->get()->getResult()[0]->total;
            $detail_data[$customer->id]["pelunasan"] = $this->invoices->selectSum('total')->where(["is_deleted" => 0, "customer_id" => $customer->id, "is_paid = " => 1, "paid_at <= " => $tanggal])->get()->getResult()[0]->total;
            $detail_data[$customer->id]["saldo_akhir"] = $detail_data[$customer->id]["saldo_awal"] + $detail_data[$customer->id]["penjualan"] - $detail_data[$customer->id]["pelunasan"];
            $total += $detail_data[$customer->id]["saldo_akhir"];
        }

        $numrow = count($this->customers->where($wherclause)->findAll());

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["tanggal"] = $tanggal;
        $data["customers"] = $customers;
        $data["customer_po"] = $customer_po;
        $data["detail_data"] = $detail_data;
        $data["total"] = $total;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('reports/v_account_receivable');
        echo view('v_footer');
    }
}
