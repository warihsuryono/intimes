<?php

namespace App\Controllers;

use App\Models\m_mounting;
use App\Models\m_mounting_detail;
use App\Models\m_mounting_photo;
use App\Models\m_tire_position;
use App\Models\m_tire_type;
use App\Models\m_vehicle;
use App\Models\m_vehicle_brand;
use App\Models\m_vehicle_type;

class Mounting extends BaseController
{
    protected $menu_ids;
    protected $mountings;
    protected $mounting_details;
    protected $mounting_photos;
    protected $tire_positions;
    protected $tire_types;
    protected $vehicles;
    protected $vehicle_types;
    protected $vehicle_brands;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "mountings";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->mountings =  new m_mounting();
        $this->mounting_details =  new m_mounting_detail();
        $this->mounting_photos =  new m_mounting_photo();
        $this->tire_positions =  new m_tire_position();
        $this->tire_types =  new m_tire_type();
        $this->vehicles =  new m_vehicle();
        $this->vehicle_types =  new m_vehicle_type();
        $this->vehicle_brands =  new m_vehicle_brand();
    }

    public function get_reference_data()
    {
        $data = [];
        @$data["yesnooption"][0]->id = 0;
        @$data["yesnooption"][0]->name = "No";
        @$data["yesnooption"][1]->id = 1;
        @$data["yesnooption"][1]->name = "Yes";

        $data["tire_positions"] = $this->tire_positions->where("is_deleted", "0")->findAll();
        $data["tire_types"] = $this->tire_types->where("is_deleted", "0")->findAll();

        $data["page"] = 1;

        if (isset($_POST["vehicle_id"])) {
            $data["vehicle"] = $this->vehicles->where(["is_deleted" => "0", "id" => $_POST["vehicle_id"]])->findAll()[0];
            $data["vehicle_type"] = $this->vehicle_types->where(["is_deleted" => "0", "id" => $data["vehicle"]->vehicle_type_id])->findAll()[0]->name;
            $data["vehicle_brand"] = $this->vehicle_brands->where(["is_deleted" => "0", "id" => $data["vehicle"]->vehicle_brand_id])->findAll()[0]->name;
        }
        if (isset($_POST["tire_position_id"]))
            $data["tire_position"] = $this->tire_positions->where(["is_deleted" => "0", "id" => $_POST["tire_position_id"]])->findAll()[0];
        if (isset($_POST["vehicle_id"]) && isset($_POST["tire_position_id"]))
            $data["page"] = 2;

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

        if (isset($_GET["customer_name"]) && $_GET["customer_name"] != "")
            $wherclause .= " AND customer_name LIKE '%" . $_GET["customer_name"] . "%'";

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

    public function saving_data($masterdetail = "master", $id = null, $key = null)
    {
        if ($masterdetail == "master")
            return  [
                "spk_no"                        => @$_POST["spk_no"],
                "spk_at"                        => @$_POST["spk_at"],
                "customer_id"                   => @$_POST["customer_id"],
                "customer_name"                 => @$_POST["customer_name"],
                "mounting_at"                   => @$_POST["mounting_at"],
                "vehicle_id"                    => @$_POST["vehicle_id"],
                "vehicle_registration_plate"    => @$_POST["vehicle_registration_plate"],
                "notes"                         => @$_POST["notes"],
            ];

        if ($masterdetail == "detail")
            return [
                "mounting_id"       => $id,
                "code"              => @$_POST["code"][$key],
                "tire_type_id"      => @$_POST["tire_type_id"][$key],
                "tire_position_id"  => @$_POST["tire_position_id"][$key],
                "km"                => @$_POST["km"][$key],
                "otd"               => @$_POST["otd"][$key],
                "price"             => @$_POST["price"][$key],
                "remark"            => @$_POST["remark"][$key],
            ];
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["saving_page_1"])) {
            echo "ssssss";
        }
        if (isset($_POST["Save"])) {
            $mounting = $this->saving_data();
            $mounting = $mounting + $this->created_values() + $this->updated_values();
            if ($this->mountings->save($mounting)) {
                $id = $this->mountings->insertID();
                foreach ($_POST["code"] as $key => $code) {
                    $mounting_detail = $this->saving_data("detail", $id, $key) + $this->created_values() + $this->updated_values();
                    $this->mounting_details->save($mounting_detail);
                }
                $this->session->setFlashdata("flash_message", ["success", "Success adding Mounting"]);
                return redirect()->to(base_url() . '/mounting/edit/' . $id);
            } else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding Mounting"]);
        }

        $data["__modulename"] = "Add Mounting";
        $data["__mode"] = "add";
        $data = $data + $this->common();
        $data = $data + $this->get_reference_data();
        echo view('v_header', $data);
        echo view('v_menu');
        if ($data["page"] == 1)
            echo view('mountings/v_edit1');
        if ($data["page"] == 2)
            echo view('mountings/v_edit2');
        echo view('v_footer');
        echo view('mountings/v_js');
    }
}
