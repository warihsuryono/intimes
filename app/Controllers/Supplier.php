<?php

namespace App\Controllers;

use App\Models\m_supplier;
use App\Models\m_supplier_group;
use App\Models\m_invoice;
use App\Models\m_payment_type;
use App\Models\m_bank;
use App\Models\m_coa;

class Supplier extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $suppliers;
    protected $supplier_groups;
    protected $invoices;
    protected $payment_types;
    protected $banks;
    protected $coas;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "suppliers";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->suppliers =  new m_supplier();
        $this->supplier_groups =  new m_supplier_group();
        $this->invoices =  new m_invoice();
        $this->payment_types =  new m_payment_type();
        $this->banks =  new m_bank();
        $this->coas =  new m_coa();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Suppliers";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["supplier_group_id"]) && $_GET["supplier_group_id"] != "")
            $wherclause .= "AND supplier_group_id LIKE '%" . $_GET["supplier_group_id"] . "%'";

        if (isset($_GET["company_name"]) && $_GET["company_name"] != "")
            $wherclause .= "AND company_name LIKE '%" . $_GET["company_name"] . "%'";

        if (isset($_GET["pic"]) && $_GET["pic"] != "")
            $wherclause .= "AND pic LIKE '%" . $_GET["pic"] . "%'";

        if (isset($_GET["coa"]) && $_GET["coa"] != "")
            $wherclause .= "AND coa LIKE '%" . $_GET["coa"] . "%'";

        if ($suppliers = $this->suppliers->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->suppliers->where($wherclause)->findAll());

            foreach ($suppliers as $supplier) {
                $supplier_detail[$supplier->id]["supplier_group_id"] = @$this->supplier_groups->where("id", $supplier->supplier_group_id)->get()->getResult()[0]->name;
                $supplier_detail[$supplier->id]["tax_invoice_no"] = @$this->invoices->where("invoice_no", $supplier->tax_invoice_no)->get()->getResult()[0]->invoice_no;
                $supplier_detail[$supplier->id]["payment_type_id"] = @$this->payment_types->where("id", $supplier->payment_type_id)->get()->getResult()[0]->name;
                $supplier_detail[$supplier->id]["bank_id"] = @$this->banks->where("id", $supplier->bank_id)->get()->getResult()[0]->name;
                $supplier_detail[$supplier->id]["coa"] = @$this->coas->where("coa", $supplier->coa)->get()->getResult()[0]->coa;
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"]       = $startrow;
        $data["numrow"]         = $numrow;
        $data["maxpage"]        = ceil($numrow / MAX_ROW);
        $data["supplier_groups"] = $this->supplier_groups->where("is_deleted", 0)->findAll();
        $data["invoices"]       = $this->invoices->where("is_deleted", 0)->findAll();
        $data["payment_types"]  = $this->payment_types->where("is_deleted", 0)->findAll();
        $data["banks"]          = $this->banks->where("is_deleted", 0)->findAll();
        $data["coas"]           = $this->coas->where("is_deleted", 0)->findAll();
        $data["suppliers"]      = $suppliers;
        $data["supplier_detail"] = @$supplier_detail;
        $data                   = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('suppliers/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $supplier = [
                "supplier_group_id" => @$_POST["supplier_group_id"],
                "company_name"      => @$_POST["company_name"],
                "pic"               => @$_POST["pic"],
                "pic_phone"         => @$_POST["pic_phone"],
                "email"             => @$_POST["email"],
                "address"           => @$_POST["address"],
                "city"              => @$_POST["city"],
                "province"          => @$_POST["province"],
                "country"           => @$_POST["country"],
                "zipcode"           => @$_POST["zipcode"],
                "phone"             => @$_POST["phone"],
                "fax"               => @$_POST["fax"],
                "nationality"       => @$_POST["nationality"],
                "remarks"           => @$_POST["remarks"],
                "npwp"              => @$_POST["npwp"],
                "nppkp"             => @$_POST["nppkp"],
                "tax_invoice_no"    => @$_POST["tax_invoice_no"],
                "coa"               => @$_POST["coa"],
                "payment_type_id"   => @$_POST["payment_type_id"],
                "bank_id"           => @$_POST["bank_id"],
                "bank_account"      => @$_POST["bank_account"],
                "reg_code"          => @$_POST["reg_code"],
                "reg_at"            => @$_POST["reg_at"],
                "join_at"           => @$_POST["join_at"],
                "description"       => @$_POST["description"],
            ];
            $supplier = $supplier + $this->created_values() + $this->updated_values();
            if ($this->suppliers->save($supplier))
                $this->session->setFlashdata("flash_message", ["success", "Success adding supplier"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding supplier"]);
            return redirect()->to(base_url() . '/suppliers');
        }

        $data["__modulename"]       = "Add Supplier";
        $data["supplier_groups"]    = $this->supplier_groups->where("is_deleted", 0)->findAll();
        $data["invoices"]           = $this->invoices->where("is_deleted", 0)->findAll();
        $data["payment_types"]      = $this->payment_types->where("is_deleted", 0)->findAll();
        $data["banks"]              = $this->banks->where("is_deleted", 0)->findAll();
        $data["coas"]               = $this->coas->where("is_deleted", 0)->findAll();
        $data                       = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('suppliers/v_edit');
        echo view('v_footer');
        echo view('suppliers/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $supplier = [
                "supplier_group_id" => @$_POST["supplier_group_id"],
                "company_name"      => @$_POST["company_name"],
                "pic"               => @$_POST["pic"],
                "pic_phone"         => @$_POST["pic_phone"],
                "email"             => @$_POST["email"],
                "address"           => @$_POST["address"],
                "city"              => @$_POST["city"],
                "province"          => @$_POST["province"],
                "country"           => @$_POST["country"],
                "zipcode"           => @$_POST["zipcode"],
                "phone"             => @$_POST["phone"],
                "fax"               => @$_POST["fax"],
                "nationality"       => @$_POST["nationality"],
                "remarks"           => @$_POST["remarks"],
                "npwp"              => @$_POST["npwp"],
                "nppkp"             => @$_POST["nppkp"],
                "tax_invoice_no"    => @$_POST["tax_invoice_no"],
                "coa"               => @$_POST["coa"],
                "payment_type_id"   => @$_POST["payment_type_id"],
                "bank_id"           => @$_POST["bank_id"],
                "bank_account"      => @$_POST["bank_account"],
                "reg_code"          => @$_POST["reg_code"],
                "reg_at"            => @$_POST["reg_at"],
                "join_at"           => @$_POST["join_at"],
                "description"       => @$_POST["description"],
            ];
            $supplier = $supplier + $this->updated_values();
            if ($this->suppliers->update($id, $supplier))
                $this->session->setFlashdata("flash_message", ["success", "Success editing supplier"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing supplier"]);
            return redirect()->to(base_url() . '/suppliers');
        }

        $data["__modulename"]       = "Edit Supplier";
        $data["supplier_groups"]    = $this->supplier_groups->where("is_deleted", 0)->findAll();
        $data["invoices"]           = $this->invoices->where("is_deleted", 0)->findAll();
        $data["payment_types"]      = $this->payment_types->where("is_deleted", 0)->findAll();
        $data["banks"]              = $this->banks->where("is_deleted", 0)->findAll();
        $data["coas"]               = $this->coas->where("is_deleted", 0)->findAll();
        $data["supplier"]           = $this->suppliers->where("is_deleted", 0)->find([$id])[0];
        $data                       = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('suppliers/v_edit');
        echo view('v_footer');
        echo view('suppliers/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->suppliers->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting supplier"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting supplier"]);
        return redirect()->to(base_url() . '/suppliers');
    }

    public function subwindow()
    {
        $wherclause = "is_deleted = '0'";

        if (isset($_GET["keyword"]) && $_GET["keyword"] != "") {
            $wherclause .= "AND (company_name LIKE '%" . $_GET["keyword"] . "%'";
            $wherclause .= "OR pic LIKE '%" . $_GET["keyword"] . "%')";
        }

        if ($suppliers = $this->suppliers->where($wherclause)->findAll(LIMIT_SUBWINDOW, 0)) {
            foreach ($suppliers as $supplier) {
                $supplier_detail[$supplier->id]["supplier_group_id"] = @$this->supplier_groups->where("id", $supplier->supplier_group_id)->get()->getResult()[0]->name;
            }
        }

        $data["supplier_groups"] = $this->supplier_groups->where("is_deleted", 0)->findAll();
        $data["suppliers"]      = $suppliers;
        $data["supplier_detail"] = @$supplier_detail;
        $data                   = $data + $this->common();
        echo view('suppliers/v_subwindow', $data);
    }
}
