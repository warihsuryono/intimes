<?php

namespace App\Controllers;

use App\Models\m_tire_size;

class Tire_size extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $tire_sizes;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "tire_sizes";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->tire_sizes =  new m_tire_size();
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

        if (isset($_GET["diameter"]) && $_GET["diameter"] != "")
            $wherclause .= "AND diameter = '" . $_GET["diameter"] . "'";

        if (isset($_GET["width"]) && $_GET["width"] != "")
            $wherclause .= "AND width = '" . $_GET["width"] . "'";

        if (isset($_GET["wheel"]) && $_GET["wheel"] != "")
            $wherclause .= "AND wheel = '" . $_GET["wheel"] . "'";

        if (isset($_GET["sidewall"]) && $_GET["sidewall"] != "")
            $wherclause .= "AND sidewall = '" . $_GET["sidewall"] . "'";

        if (isset($_GET["circumference"]) && $_GET["circumference"] != "")
            $wherclause .= "AND circumference = '" . $_GET["circumference"] . "'";

        if (isset($_GET["revs_mile"]) && $_GET["revs_mile"] != "")
            $wherclause .= "AND revs_mile = '" . $_GET["revs_mile"] . "'";

        if ($tire_sizes = $this->tire_sizes->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->tire_sizes->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["tire_sizes"] = $tire_sizes;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tire_sizes/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $tire_size = [
                "name"          => @$_POST["name"],
                "diameter"      => @$_POST["diameter"],
                "width"         => @$_POST["width"],
                "wheel"         => @$_POST["wheel"],
                "sidewall"      => @$_POST["sidewall"],
                "circumference" => @$_POST["circumference"],
                "revs_mile"     => @$_POST["revs_mile"],
            ];
            $tire_size = $tire_size + $this->created_values() + $this->updated_values();
            if ($this->tire_sizes->save($tire_size))
                $this->session->setFlashdata("flash_message", ["success", "Success adding Tire Size"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding Tire Size"]);
            return redirect()->to(base_url() . '/tire_sizes');
        }

        $data["__modulename"] = "Add Tire Size";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tire_sizes/v_edit');
        echo view('v_footer');
        echo view('tire_sizes/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $tire_size = [
                "name"          => @$_POST["name"],
                "diameter"      => @$_POST["diameter"],
                "width"         => @$_POST["width"],
                "wheel"         => @$_POST["wheel"],
                "sidewall"      => @$_POST["sidewall"],
                "circumference" => @$_POST["circumference"],
                "revs_mile"     => @$_POST["revs_mile"],
            ];
            $tire_size = $tire_size + $this->updated_values();
            if ($this->tire_sizes->update($id, $tire_size))
                $this->session->setFlashdata("flash_message", ["success", "Success editing tire size"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing tire size"]);
            return redirect()->to(base_url() . '/tire_sizes');
        }

        $data["__modulename"] = "Edit Tire Size";
        $data["tire_size"] = $this->tire_sizes->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tire_sizes/v_edit');
        echo view('v_footer');
        echo view('tire_sizes/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->tire_sizes->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting tire size"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting tire size"]);
        return redirect()->to(base_url() . '/tire_sizes');
    }
}
