<?php

namespace App\Controllers;

use App\Models\m_mounting;

class Mounting extends BaseController
{
    protected $menu_ids;
    protected $mountings;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "mountings";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->mountings =  new m_mounting();
    }

    public function get_reference_data()
    {
        $data = [];
        return $data;
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Mounting";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["spk_no"]) && $_GET["spk_no"] != "")
            $wherclause .= " AND spk_no LIKE '%" . $_GET["spk_no"] . "%'";

        if (isset($_GET["spk_at"]) && $_GET["spk_at"] != "")
            $wherclause .= " AND spk_at = '" . $_GET["spk_at"] . "'";

        if (isset($_GET["mounting_at"]) && $_GET["mounting_at"] != "")
            $wherclause .= " AND mounting_at = '" . $_GET["mounting_at"] . "'";

        if (isset($_GET["vehicle_registration_plate"]) && $_GET["vehicle_registration_plate"] != "")
            $wherclause .= " AND vehicle_registration_plate LIKE '%" . $_GET["vehicle_registration_plate"] . "%'";

        if (isset($_GET["code"]) && $_GET["code"] != "")
            $wherclause .= " AND id IN (SELECT mounting_id FROM mounting_details WHERE code LIKE '%" . $_GET["code"] . "%')";

        if ($mountings = $this->mountings->where($wherclause)->findAll(MAX_ROW, $startrow)) {
            $numrow = count($this->mountings->where($wherclause)->findAll());
            foreach ($mountings as $mounting) {
                $mounting_detail[$mounting->id]["mounting_details"] = @$this->mounting_details->where("mounting_id", $mounting->id)->findAll();
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["mountings"] = $mountings;
        $data["mounting_detail"] = @$mounting_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('mountings/v_list');
        echo view('v_footer');
    }
}