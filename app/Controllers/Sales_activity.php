<?php

namespace App\Controllers;

use App\Models\m_customer;
use App\Models\m_customer_call;
use App\Models\m_customer_level;
use App\Models\m_industry_category;
use App\Models\m_quotation;
use App\Models\m_so;


class Sales_activity extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $customers;
    protected $customer_calls;
    protected $customer_levels;
    protected $industry_categories;
    protected $quotations;
    protected $so_;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "sales_activities";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->customers =  new m_customer();
        $this->customer_calls =  new m_customer_call();
        $this->customer_levels =  new m_customer_level();
        $this->industry_categories =  new m_industry_category();
        $this->quotations =  new m_quotation();
        $this->so_ =  new m_so();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);
        $data["__modulename"] = "Sales Activities";

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["call_at"]) && $_GET["call_at"] != "")
            $wherclause .= " AND call_at LIKE '" . substr($_GET["call_at"], 0, 7) . "%'";

        if (isset($_GET["sales_user_id"]) && $_GET["sales_user_id"] != "")
            $wherclause .= " AND sales_user_id LIKE '%" . $_GET["sales_user_id"] . "%'";



        $activities = [];
        $total = [];
        if (@$_GET["call_at"] != "" && @$_GET["sales_user_id"] != "") {
            $sales_user_email = $this->users->where(["is_deleted" => 0, "id" => $_GET["sales_user_id"]])->findAll()[0]->email;
            $sales_name = $this->users->where(["is_deleted" => 0, "id" => $_GET["sales_user_id"]])->findAll()[0]->name;
            for ($day = 1; $day <= date("t", strtotime($_GET["call_at"] . "-01")); $day++) {
                $date = substr($_GET["call_at"], 0, 7) . "-" . str_pad($day, 2, "0", STR_PAD_LEFT);
                $activities[$date]["quotation"] = count($this->quotations->where("is_deleted", 0)->where(["quotation_at" => $date, "created_by" => $sales_user_email, "is_approved" => 1])->findAll());
                $activities[$date]["deal"] = count($this->so_->where("is_deleted", 0)->where(["so_at" => $date, "created_by" => $sales_user_email, "is_approved" => 1])->findAll());

                if (isset($total["quotation"])) $total["quotation"] += $activities[$date]["quotation"];
                else $total["quotation"] = $activities[$date]["quotation"];

                if (isset($total["deal"])) $total["deal"] += $activities[$date]["deal"];
                else $total["deal"] = $activities[$date]["deal"];
            }

            if ($sales_activities = $this->customer_calls->where("is_deleted", 0)->where($wherclause)->findAll()) {
                foreach ($sales_activities as $sales_activity) {
                    $date = substr($sales_activity->call_at, 0, 10);
                    if ($sales_activity->followup_activity == "Meeting") {
                        if (isset($activities[$date]["meeting"])) $activities[$date]["meeting"]++;
                        else $activities[$date]["meeting"] = 1;
                        if (isset($total["meeting"])) $total["meeting"]++;
                        else $total["meeting"] = 1;
                    }

                    if ($sales_activity->followup_activity == "Cold Call") {
                        if (isset($activities[$date]["cold_call"])) $activities[$date]["cold_call"]++;
                        else $activities[$date]["cold_call"] = 1;
                        if (isset($total["cold_call"])) $total["cold_call"]++;
                        else $total["cold_call"] = 1;
                    }

                    if ($sales_activity->followup_activity == "Quality Call") {
                        if (isset($activities[$date]["quality_call"])) $activities[$date]["quality_call"]++;
                        else $activities[$date]["quality_call"] = 1;
                        if (isset($total["quality_call"])) $total["quality_call"]++;
                        else $total["quality_call"] = 1;
                    }
                }
            }
        }



        $data["sales_users"] = $this->users->where("is_deleted", 0)->where("division_id IN (SELECT id FROM divisions WHERE name LIKE '%sales%')")->findAll();
        $data["activities"] = $activities;
        $data["total"] = $total;
        $data["sales_name"] = $sales_name;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('sales_activities/v_list');
        echo view('v_footer');
    }
}
