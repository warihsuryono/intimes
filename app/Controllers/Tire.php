<?php

namespace App\Controllers;

use App\Models\m_tire;
use App\Models\m_tire_brand;
use App\Models\m_tire_size;
use App\Models\m_tire_type;

class Tire extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $tires;
    protected $tire_sizes;
    protected $tire_brands;
    protected $tire_types;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "tires";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->tires =  new m_tire();
        $this->tire_sizes =  new m_tire_size();
        $this->tire_brands =  new m_tire_brand();
        $this->tire_types =  new m_tire_type();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Tire Sizes";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if (isset($_GET["qrcode"]) && $_GET["qrcode"] != "")
            $wherclause .= "AND qrcode LIKE '%" . $_GET["qrcode"] . "%'";

        if (isset($_GET["serialno"]) && $_GET["serialno"] != "")
            $wherclause .= "AND serialno LIKE '%" . $_GET["serialno"] . "%'";

        if (isset($_GET["is_retread"]) && $_GET["is_retread"] != "")
            $wherclause .= "AND is_retread = '" . $_GET["is_retread"] . "'";

        if (isset($_GET["tire_size_id"]) && $_GET["tire_size_id"] != "")
            $wherclause .= "AND tire_size_id = '" . $_GET["tire_size_id"] . "'";

        if (isset($_GET["tire_brand_id"]) && $_GET["tire_brand_id"] != "")
            $wherclause .= "AND tire_brand_id = '" . $_GET["tire_brand_id"] . "'";

        if (isset($_GET["tire_type_id"]) && $_GET["tire_type_id"] != "")
            $wherclause .= "AND tire_type_id = '" . $_GET["tire_type_id"] . "'";

        if (isset($_GET["pattern"]) && $_GET["pattern"] != "")
            $wherclause .= "AND pattern = '" . $_GET["pattern"] . "'";

        if ($tires = $this->tires->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->tires->where($wherclause)->findAll());
            foreach ($tires as $tire) {
                $tire_detail[$tire->id]["tire_size"] = @$this->tire_sizes->where("id", $tire->tire_size_id)->findAll()[0];
                $tire_detail[$tire->id]["tire_brand"] = @$this->tire_brands->where("id", $tire->tire_brand_id)->findAll()[0];
                $tire_detail[$tire->id]["tire_type"] = @$this->tire_types->where("id", $tire->tire_type_id)->findAll()[0];
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
                "name"          => "",
                "qrcode"        => @$_POST["qrcode"],
                "serialno"      => @$_POST["serialno"],
                "is_retread"    => @$_POST["is_retread"],
                "tire_size_id"  => @$_POST["tire_size_id"],
                "tire_brand_id" => @$_POST["tire_brand_id"],
                "tire_type_id"  => @$_POST["tire_type_id"],
                "tread_depth"   => @$_POST["tread_depth"],
                "pattern"       => @$_POST["pattern"],
                "psi"           => @$_POST["psi"],
                "remark"        => @$_POST["remark"],
            ];
            $tire = $tire + $this->created_values() + $this->updated_values();
            if ($this->tires->save($tire))
                $this->session->setFlashdata("flash_message", ["success", "Success adding Tire Size"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding Tire Size"]);
            return redirect()->to(base_url() . '/tires');
        }

        $data["__modulename"] = "Add Tire Size";
        $data["__mode"] = "add";
        $data["tire_sizes"] = $this->tire_sizes->where("is_deleted", 0)->findAll();
        $data["tire_brands"] = $this->tire_brands->where("is_deleted", 0)->findAll();
        $data["tire_types"] = $this->tire_types->where("is_deleted", 0)->findAll();
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
                "name"          => @$_POST["name"],
                "qrcode"        => @$_POST["qrcode"],
                "serialno"      => @$_POST["serialno"],
                "is_retread"    => @$_POST["is_retread"],
                "tire_size_id"  => @$_POST["tire_size_id"],
                "tire_brand_id" => @$_POST["tire_brand_id"],
                "tire_type_id"  => @$_POST["tire_type_id"],
                "tread_depth"   => @$_POST["tread_depth"],
                "pattern"       => @$_POST["pattern"],
                "psi"           => @$_POST["psi"],
                "remark"        => @$_POST["remark"],
            ];
            $tire = $tire + $this->updated_values();
            if ($this->tires->update($id, $tire))
                $this->session->setFlashdata("flash_message", ["success", "Success editing tire size"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing tire size"]);
            return redirect()->to(base_url() . '/tires');
        }

        $data["__modulename"] = "Edit Tire Size";
        $data["__mode"] = "edit";
        $data["tire_sizes"] = $this->tire_sizes->where("is_deleted", 0)->findAll();
        $data["tire_brands"] = $this->tire_brands->where("is_deleted", 0)->findAll();
        $data["tire_types"] = $this->tire_types->where("is_deleted", 0)->findAll();
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
            $this->session->setFlashdata("flash_message", ["success", "Success deleting tire size"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting tire size"]);
        return redirect()->to(base_url() . '/tires');
    }
}
