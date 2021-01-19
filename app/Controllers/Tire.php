<?php

namespace App\Controllers;

use App\Models\m_tire;
use App\Models\m_tire_brand;
use App\Models\m_tire_size;
use App\Models\m_tire_type;
use App\Models\m_tire_pattern;

class Tire extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $tires;
    protected $tire_sizes;
    protected $tire_brands;
    protected $tire_types;
    protected $tire_patterns;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "tires";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->tires =  new m_tire();
        $this->tire_sizes =  new m_tire_size();
        $this->tire_brands =  new m_tire_brand();
        $this->tire_types =  new m_tire_type();
        $this->tire_patterns =  new m_tire_pattern();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Tires";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if (isset($_GET["qrcode"]) && $_GET["qrcode"] != "")
            $wherclause .= "AND qrcode LIKE '%" . $_GET["qrcode"] . "%'";

        if (isset($_GET["serialno"]) && $_GET["serialno"] != "")
            $wherclause .= "AND serialno LIKE '%" . $_GET["serialno"] . "%'";

        if (isset($_GET["tire_size_id"]) && $_GET["tire_size_id"] != "")
            $wherclause .= "AND tire_size_id = '" . $_GET["tire_size_id"] . "'";

        if (isset($_GET["tire_brand_id"]) && $_GET["tire_brand_id"] != "")
            $wherclause .= "AND tire_brand_id = '" . $_GET["tire_brand_id"] . "'";

        if (isset($_GET["tire_type_id"]) && $_GET["tire_type_id"] != "")
            $wherclause .= "AND tire_type_id = '" . $_GET["tire_type_id"] . "'";

        if (isset($_GET["tire_pattern_id"]) && $_GET["tire_pattern_id"] != "")
            $wherclause .= "AND tire_pattern_id = '" . $_GET["tire_pattern_id"] . "'";

        if ($tires = $this->tires->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->tires->where($wherclause)->findAll());
            foreach ($tires as $tire) {
                $tire_detail[$tire->id]["tire_size"] = @$this->tire_sizes->where("id", $tire->tire_size_id)->findAll()[0];
                $tire_detail[$tire->id]["tire_brand"] = @$this->tire_brands->where("id", $tire->tire_brand_id)->findAll()[0];
                $tire_detail[$tire->id]["tire_type"] = @$this->tire_types->where("id", $tire->tire_type_id)->findAll()[0];
                $tire_detail[$tire->id]["tire_pattern"] = @$this->tire_patterns->where("id", $tire->tire_pattern_id)->findAll()[0];
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["tire_sizes"] = $this->tire_sizes->where("is_deleted", 0)->findAll();
        $data["tire_brands"] = $this->tire_brands->where("is_deleted", 0)->findAll();
        $data["tire_types"] = $this->tire_types->where("is_deleted", 0)->findAll();
        $data["tire_patterns"] = $this->tire_patterns->where("is_deleted", 0)->findAll();
        $data["tires"] = $tires;
        $data["tire_detail"] = @$tire_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tires/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $tire = [
                "name"              => "",
                "qrcode"            => @$_POST["qrcode"],
                "serialno"          => @$_POST["serialno"],
                "tire_size_id"      => @$_POST["tire_size_id"],
                "tire_brand_id"     => @$_POST["tire_brand_id"],
                "tire_type_id"      => @$_POST["tire_type_id"],
                "tire_pattern_id"   => @$_POST["tire_pattern_id"],
                "tread_depth"       => @$_POST["tread_depth"],
                "psi"               => @$_POST["psi"],
                "remark"            => @$_POST["remark"],
            ];
            $tire = $tire + $this->created_values() + $this->updated_values();
            if ($this->tires->save($tire))
                $this->session->setFlashdata("flash_message", ["success", "Success adding Tire"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding Tire"]);
            return redirect()->to(base_url() . '/tires');
        }

        $data["__modulename"] = "Add Tire";
        $data["__mode"] = "add";
        $data["tire_sizes"] = $this->tire_sizes->where("is_deleted", 0)->findAll();
        $data["tire_brands"] = $this->tire_brands->where("is_deleted", 0)->findAll();
        $data["tire_types"] = $this->tire_types->where("is_deleted", 0)->findAll();
        $data["tire_patterns"] = $this->tire_patterns->where("is_deleted", 0)->findAll();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tires/v_edit');
        echo view('v_footer');
        echo view('tires/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $tire = [
                "name"              => "",
                "qrcode"            => @$_POST["qrcode"],
                "serialno"          => @$_POST["serialno"],
                "tire_size_id"      => @$_POST["tire_size_id"],
                "tire_brand_id"     => @$_POST["tire_brand_id"],
                "tire_type_id"      => @$_POST["tire_type_id"],
                "tire_pattern_id"   => @$_POST["tire_pattern_id"],
                "tread_depth"       => @$_POST["tread_depth"],
                "psi"               => @$_POST["psi"],
                "remark"            => @$_POST["remark"],
            ];
            $tire = $tire + $this->updated_values();
            if ($this->tires->update($id, $tire))
                $this->session->setFlashdata("flash_message", ["success", "Success editing tire"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing tire"]);
            return redirect()->to(base_url() . '/tires');
        }

        $data["__modulename"] = "Edit Tire";
        $data["__mode"] = "edit";
        $data["tire_sizes"] = $this->tire_sizes->where("is_deleted", 0)->findAll();
        $data["tire_brands"] = $this->tire_brands->where("is_deleted", 0)->findAll();
        $data["tire_types"] = $this->tire_types->where("is_deleted", 0)->findAll();
        $data["tire_patterns"] = $this->tire_patterns->where("is_deleted", 0)->findAll();
        $data["tire"] = $this->tires->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tires/v_edit');
        echo view('v_footer');
        echo view('tires/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->tires->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting tire"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting tire"]);
        return redirect()->to(base_url() . '/tires');
    }

    public function get_item($id)
    {
        return json_encode($this->tires->where("is_deleted", 0)->find([$id]));
    }

    public function subwindow()
    {
        $wherclause = "is_deleted = '0'";

        if (isset($_GET["keyword"]) && $_GET["keyword"] != "") {
            $wherclause .= "AND (qrcode LIKE '%" . $_GET["keyword"] . "%' ";
            $wherclause .= "OR serialno LIKE '%" . $_GET["keyword"] . "%')";
        }

        if ($tires = $this->tires->where($wherclause)->findAll(LIMIT_SUBWINDOW, 0)) {
            foreach ($tires as $tire) {
                $tire_detail[$tire->id]["tire_size"] = @$this->tire_sizes->where("id", $tire->tire_size_id)->findAll()[0];
                $tire_detail[$tire->id]["tire_brand"] = @$this->tire_brands->where("id", $tire->tire_brand_id)->findAll()[0];
                $tire_detail[$tire->id]["tire_type"] = @$this->tire_types->where("id", $tire->tire_type_id)->findAll()[0];
                $tire_detail[$tire->id]["tire_pattern"] = @$this->tire_patterns->where("id", $tire->tire_pattern_id)->findAll()[0];
            }
        }

        $data["tires"]       = $tires;
        $data["tire_detail"] = @$tire_detail;
        $data                = $data + $this->common();
        echo view('tires/v_subwindow', $data);
    }
}
