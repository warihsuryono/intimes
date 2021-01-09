<?php

namespace App\Controllers;

use App\Models\m_customer;
use App\Models\m_customer_call;
use App\Models\m_customer_level;
use App\Models\m_industry_category;

class Customer_call extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $customers;
    protected $customer_calls;
    protected $customer_levels;
    protected $industry_categories;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "customer_calls";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->customers =  new m_customer();
        $this->customer_calls =  new m_customer_call();
        $this->customer_levels =  new m_customer_level();
        $this->industry_categories =  new m_industry_category();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);
        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Customer Calls & Follow Ups";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["customer_level_id"]) && $_GET["customer_level_id"] != "")
            $wherclause .= " AND customer_id IN (SELECT id FROM customers WHERE customer_level_id='" . $_GET["customer_level_id"] . "')";

        if (isset($_GET["industry_category_id"]) && $_GET["industry_category_id"] != "")
            $wherclause .= " AND customer_id IN (SELECT id FROM customers WHERE industry_category_id='" . $_GET["industry_category_id"] . "')";

        if (isset($_GET["company_name"]) && $_GET["company_name"] != "")
            $wherclause .= " AND customer_id IN (SELECT id FROM customers WHERE company_name LIKE '%" . $_GET["company_name"] . "%')";

        if (isset($_GET["cp"]) && $_GET["cp"] != "")
            $wherclause .= " AND cp LIKE '%" . $_GET["cp"] . "%'";

        if (isset($_GET["phone"]) && $_GET["phone"] != "")
            $wherclause .= " AND phone LIKE '%" . $_GET["phone"] . "%'";

        if (isset($_GET["email"]) && $_GET["email"] != "")
            $wherclause .= " AND email LIKE '%" . $_GET["email"] . "%'";

        if (isset($_GET["call_at"]) && $_GET["call_at"] != "")
            $wherclause .= " AND call_at LIKE '" . $_GET["call_at"] . "%'";

        if (isset($_GET["call_by"]) && $_GET["call_by"] != "")
            $wherclause .= " AND sales_user_id IN (SELECT id FROM a_users WHERE email LIKE '" . $_GET["call_by"] . "' OR name LIKE '" . $_GET["call_by"] . "')";

        if (isset($_GET["next_followup_at"]) && $_GET["next_followup_at"] != "")
            $wherclause .= " AND next_followup_at LIKE '" . $_GET["next_followup_at"] . "%'";

        if (isset($_GET["am_by"]) && $_GET["am_by"] != "")
            $wherclause .= " AND (customer_id IN (SELECT id FROM customers WHERE am_by LIKE '%" . $_GET["am_by"] . "%' OR am_by IN (SELECT email FROM a_users WHERE name LIKE '%" . $_GET["am_by"] . "%')))";

        if (isset($_GET["exporttoxls"]))
            $customer_calls = $this->customer_calls->where($wherclause)->orderBy("id DESC")->findAll();
        else
            $customer_calls = $this->customer_calls->where($wherclause)->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        if (count($customer_calls) > 0) {

            $numrow = count($this->customer_calls->where($wherclause)->findAll());

            foreach ($customer_calls as $customer_call) {
                $customer_call_detail[$customer_call->id]["customer"] = @$this->customers->where(["is_deleted" => 0, "id" => $customer_call->customer_id])->findAll()[0];
                $customer_call_detail[$customer_call->id]["sales_user"] = @$this->users->where(["is_deleted" => 0, "id" => $customer_call->sales_user_id])->findAll()[0];
                $customer_call_detail[$customer_call->id]["customer_level"] = @$this->customer_levels->where(["is_deleted" => 0, "id" => $customer_call_detail[$customer_call->id]["customer"]->customer_level_id])->findAll()[0];
                $customer_call_detail[$customer_call->id]["industry_category"] = @$this->industry_categories->where(["is_deleted" => 0, "id" => $customer_call_detail[$customer_call->id]["customer"]->industry_category_id])->findAll()[0];
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"]               = $startrow;
        $data["numrow"]                 = $numrow;
        $data["maxpage"]                = ceil($numrow / MAX_ROW);
        $data["industry_categories"]    = $this->industry_categories->where("is_deleted", 0)->findAll();
        $data["customer_levels"]        = $this->customer_levels->where("is_deleted", 0)->findAll();
        $data["customer_calls"]         = $customer_calls;
        $data["customer_call_detail"]   = @$customer_call_detail;
        $data                           = $data + $this->common();

        if (isset($_GET["exporttoxls"])) {
            $this->response->setHeader('Content-Type', 'application/vnd-ms-excel');
            $this->response->setHeader('Content-Disposition', 'attachment; filename=' . $data["__modulename"] . '.xls');
            echo view('customer_calls/v_export', $data);
        } else {
            echo view('v_header', $data);
            echo view('v_menu');
            echo view('customer_calls/v_list');
            echo view('v_footer');
        }
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $customer_call = [
                "customer_id"       => @$_POST["customer_id"],
                "sales_user_id"     => $this->session->get("user_id"),
                "cp"                => @$_POST["cp"],
                "cp_position"       => @$_POST["cp_position"],
                "phone"             => @$_POST["phone"],
                "email"             => @$_POST["email"],
                "call_at"           => @$_POST["call_at"],
                "notes"             => @$_POST["notes"],
                "followup_activity" => @$_POST["followup_activity"],
                "next_followup_at"  => @$_POST["next_followup_at"],
            ];
            $customer_call = $customer_call + $this->created_values() + $this->updated_values();
            if ($this->customer_calls->save($customer_call))
                $this->session->setFlashdata("flash_message", ["success", "Success adding customer call"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding customer call"]);

            echo "<script> window.location='" . base_url() . "/customer_call/view?customer_id=" . $_POST["customer_id"] . "'; </script>";
            exit();
        }

        $data["__modulename"]           = "Add Customer Calls & Follow Ups";
        $data["industry_categories"]    = $this->industry_categories->where("is_deleted", 0)->findAll();
        if (isset($_GET["customer_id"]) && $_GET["customer_id"] > 0)
            $data["customer"]           = $this->customers->where("is_deleted", 0)->find([$_GET["customer_id"]]);
        $data                           = $data + $this->common();
        $data["customer_call"] = (object) [
            "customer_id" => @$_GET["customer_id"],
            "customer_name" => @$data["customer"][0]->company_name,
            "cp" => @$data["customer"][0]->pic,
            "phone" => @$data["customer"][0]->phone,
            "email" => @$data["customer"][0]->email,
            "call_at" => date("Y-m-d") . "T" . date("H:i"),
            "next_followup_at" => date("Y-m-d") . "T" . date("H:i")
        ];
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('customer_calls/v_edit');
        echo view('v_footer');
        echo view('customer_calls/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $customer_call = [
                "customer_id"       => @$_POST["customer_id"],
                "cp"                => @$_POST["cp"],
                "cp_position"       => @$_POST["cp_position"],
                "phone"             => @$_POST["phone"],
                "email"             => @$_POST["email"],
                "call_at"           => @$_POST["call_at"],
                "notes"             => @$_POST["notes"],
                "followup_activity" => @$_POST["followup_activity"],
                "next_followup_at"  => @$_POST["next_followup_at"],
            ];
            $customer_call = $customer_call + $this->updated_values();
            if ($this->customer_calls->update($id, $customer_call))
                $this->session->setFlashdata("flash_message", ["success", "Success editing customer call"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing customer call"]);

            echo "<script> window.location='" . base_url() . "/customer_call/view?customer_id=" . $_POST["customer_id"] . "'; </script>";
            exit();
        }

        $data["__modulename"]           = "Edit Customer Calls & Follow Ups";
        $data["industry_categories"]    = $this->industry_categories->where("is_deleted", 0)->findAll();
        $data["customer_call"]          = $this->customer_calls->where("is_deleted", 0)->find([$id])[0];
        $data["customer"]           = $this->customers->where("is_deleted", 0)->find([$data["customer_call"]->customer_id])[0];
        $data                           = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('customer_calls/v_edit');
        echo view('v_footer');
        echo view('customer_calls/v_js');
    }

    public function view()
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);

        $data["__modulename"]           = "Customer Calls & Follow Ups";
        $data["industry_categories"]    = $this->industry_categories->where("is_deleted", 0)->findAll();
        $data["customer"]               = $this->customers->where("is_deleted", 0)->find([$_GET["customer_id"]])[0];
        $data["customer_call"]          = $this->customer_calls->where(["is_deleted" => 0, "customer_id" => $_GET["customer_id"]])->findAll();
        $data                           = $data + $this->common();


        $wherclause = ["is_deleted" => 0, "customer_id" => $_GET["customer_id"]];
        if ($customer_calls = $this->customer_calls->where($wherclause)->orderBy("id DESC")->findAll(MAX_ROW, 0)) {

            foreach ($customer_calls as $customer_call) {
                $customer_call_detail[$customer_call->id]["customer"] = @$this->customers->where(["is_deleted" => 0, "id" => $customer_call->customer_id])->findAll()[0];
                $customer_call_detail[$customer_call->id]["sales_user"] = @$this->users->where(["is_deleted" => 0, "id" => $customer_call->sales_user_id])->findAll()[0];
                $customer_call_detail[$customer_call->id]["customer_level"] = @$this->customer_levels->where(["is_deleted" => 0, "id" => $customer_call_detail[$customer_call->id]["customer"]->customer_level_id])->findAll()[0];
                $customer_call_detail[$customer_call->id]["industry_category"] = @$this->industry_categories->where(["is_deleted" => 0, "id" => $customer_call_detail[$customer_call->id]["customer"]->industry_category_id])->findAll()[0];
            }
        }

        $data["customer_calls"]         = $customer_calls;
        $data["customer_call_detail"]   = @$customer_call_detail;
        $data                           = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('customer_calls/v_view');
        echo view('v_footer');
        echo view('customer_calls/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $customer_id = @$this->customers->where(["is_deleted" => 1, "id" => $id])->findALL()[0]->customer_id;
        if ($this->customers->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting customer call"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting customer call"]);
        echo "<script> window.location='" . base_url() . "/customer_call/view?customer_id=" . @$customer_id . "'; </script>";
        exit();
    }

    public function get_customer_call($id)
    {
        return json_encode($this->customer_calls->where("is_deleted", 0)->find([$id]));
    }
}
