<?php

namespace App\Controllers;

use App\Models\m_customer;
use App\Models\m_bank;
use App\Models\m_customer_level;
use App\Models\m_customer_prospect;
use App\Models\m_industry_category;

class Customer extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $customers;
    protected $banks;
    protected $customer_levels;
    protected $customer_prospect;
    protected $industry_categories;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "customers";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->customers =  new m_customer();
        $this->banks =  new m_bank();
        $this->customer_levels =  new m_customer_level();
        $this->customer_prospects =  new m_customer_prospect();
        $this->industry_categories =  new m_industry_category();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);
        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Customers";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["industry_category_id"]) && $_GET["industry_category_id"] != "")
            $wherclause .= " AND industry_category_id = '" . $_GET["industry_category_id"] . "'";

        if (isset($_GET["customer_prospect_id"]) && $_GET["customer_prospect_id"] != "")
            $wherclause .= " AND customer_prospect_id = '" . $_GET["customer_prospect_id"] . "'";

        if (isset($_GET["customer_level_id"]) && $_GET["customer_level_id"] != "")
            $wherclause .= " AND customer_level_id = '" . $_GET["customer_level_id"] . "'";

        if (isset($_GET["company_name"]) && $_GET["company_name"] != "")
            $wherclause .= " AND company_name LIKE '%" . $_GET["company_name"] . "%'";

        if (isset($_GET["pic"]) && $_GET["pic"] != "")
            $wherclause .= " AND pic LIKE '%" . $_GET["pic"] . "%'";

        if (isset($_GET["am_by"]) && $_GET["am_by"] != "")
            $wherclause .= " AND (am_by LIKE '%" . $_GET["am_by"] . "%' OR am_by IN (SELECT email FROM a_users WHERE name LIKE '%" . $_GET["am_by"] . "%'))";

        if ($customers = $this->customers->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->customers->where($wherclause)->findAll());

            foreach ($customers as $customer) {
                $customer_detail[$customer->id]["bank_id"] = @$this->banks->where("id", $customer->bank_id)->get()->getResult()[0]->name;
                $customer_detail[$customer->id]["customer_level_id"] = @$this->customer_levels->where("id", $customer->customer_level_id)->get()->getResult()[0]->name;
                $customer_detail[$customer->id]["customer_prospect_id"] = @$this->customer_prospects->where("id", $customer->customer_prospect_id)->get()->getResult()[0]->name;
                $customer_detail[$customer->id]["industry_category_id"] = @$this->industry_categories->where("id", $customer->industry_category_id)->get()->getResult()[0]->name;
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"]       = $startrow;
        $data["numrow"]         = $numrow;
        $data["maxpage"]        = ceil($numrow / MAX_ROW);
        $data["industry_categories"] = $this->industry_categories->where("is_deleted", 0)->findAll();
        $data["banks"]          = $this->banks->where("is_deleted", 0)->findAll();
        $data["customer_levels"] = $this->customer_levels->where("is_deleted", 0)->findAll();
        $data["customer_prospects"] = $this->customer_prospects->where("is_deleted", 0)->findAll();
        $data["customers"]      = $customers;
        $data["customer_detail"] = @$customer_detail;
        $data                   = $data + $this->common();

        echo view('v_header', $data);
        echo view('v_menu');
        echo view('customers/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $customer = [
                "industry_category_id" => @$_POST["industry_category_id"],
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
                "bank_id"           => @$_POST["bank_id"],
                "bank_account"      => @$_POST["bank_account"],
                "reg_code"          => @$_POST["reg_code"],
                "reg_at"            => @$_POST["reg_at"],
                "join_at"           => @$_POST["join_at"],
                "customer_level_id" => @$_POST["customer_level_id"],
                "customer_prospect_id" => @$_POST["customer_prospect_id"],
                "description"       => @$_POST["description"],
                "am_by"             => @$_POST["am_by"],
            ];
            $customer = $customer + $this->created_values() + $this->updated_values();
            if ($this->customers->save($customer))
                $this->session->setFlashdata("flash_message", ["success", "Success adding customer"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding customer"]);
            return redirect()->to(base_url() . '/customers');
        }

        $data["__modulename"]       = "Add Customer";
        $data["industry_categories"] = $this->industry_categories->where("is_deleted", 0)->findAll();
        $data["banks"]              = $this->banks->where("is_deleted", 0)->findAll();
        $data["customer_levels"]    = $this->customer_levels->where("is_deleted", 0)->findAll();
        $data["customer_prospects"] = $this->customer_prospects->where("is_deleted", 0)->findAll();
        $data["am_by"]              = $this->session->get("username");
        $data                       = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('customers/v_edit');
        echo view('v_footer');
        echo view('customers/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $customer = [
                "industry_category_id" => @$_POST["industry_category_id"],
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
                "bank_id"           => @$_POST["bank_id"],
                "bank_account"      => @$_POST["bank_account"],
                "reg_code"          => @$_POST["reg_code"],
                "reg_at"            => @$_POST["reg_at"],
                "join_at"           => @$_POST["join_at"],
                "customer_level_id" => @$_POST["customer_level_id"],
                "customer_prospect_id" => @$_POST["customer_prospect_id"],
                "description"       => @$_POST["description"],
                "am_by"             => @$_POST["am_by"],
            ];
            $customer = $customer + $this->updated_values();
            if ($this->customers->update($id, $customer))
                $this->session->setFlashdata("flash_message", ["success", "Success editing customer"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing customer"]);
            return redirect()->to(base_url() . '/customers');
        }

        $data["__modulename"]       = "Edit Customer";
        $data["industry_categories"] = $this->industry_categories->where("is_deleted", 0)->findAll();
        $data["banks"]              = $this->banks->where("is_deleted", 0)->findAll();
        $data["customer"]           = $this->customers->where("is_deleted", 0)->find([$id])[0];
        $data["customer_levels"]    = $this->customer_levels->where("is_deleted", 0)->findAll();
        $data["customer_prospects"] = $this->customer_prospects->where("is_deleted", 0)->findAll();
        $data                       = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('customers/v_edit');
        echo view('v_footer');
        echo view('customers/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->customers->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting customer"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting customer"]);
        return redirect()->to(base_url() . '/customers');
    }

    public function get_customer($id)
    {
        return json_encode($this->customers->where("is_deleted", 0)->find([$id]));
    }

    public function subwindow()
    {
        $wherclause = "is_deleted = '0'";

        if (isset($_GET["keyword"]) && $_GET["keyword"] != "") {
            $wherclause .= "AND (company_name LIKE '%" . $_GET["keyword"] . "%' ";
            $wherclause .= "OR industry_category_id IN (SELECT id FROM industry_categories WHERE name LIKE '%" . $_GET["keyword"] . "%') ";
            $wherclause .= "OR customer_prospect_id IN (SELECT id FROM customer_prospects WHERE name LIKE '%" . $_GET["keyword"] . "%') ";
            $wherclause .= "OR pic_phone LIKE '%" . $_GET["keyword"] . "%' ";
            $wherclause .= "OR email LIKE '%" . $_GET["keyword"] . "%' ";
            $wherclause .= "OR pic LIKE '%" . $_GET["keyword"] . "%')";
        }
        $data["customers"]      = $this->customers->where($wherclause)->findAll(LIMIT_SUBWINDOW, 0);

        foreach ($data["customers"] as $customer) {
            $customer_detail[$customer->id]["industry_category_id"] = @$this->industry_categories->where("id", $customer->industry_category_id)->get()->getResult()[0]->name;
            $customer_detail[$customer->id]["customer_prospect_id"] = @$this->customer_prospects->where("id", $customer->customer_prospect_id)->get()->getResult()[0]->name;
        }
        $data["customer_detail"]    = $customer_detail;

        $data                   = $data + $this->common();
        echo view('customers/v_subwindow', $data);
    }
}
