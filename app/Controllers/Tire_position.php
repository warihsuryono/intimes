<?php

namespace App\Controllers;

use App\Models\m_tire_position;

class Tire_position extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $tire_positions;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "tire_positions";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->tire_positions =  new m_tire_position();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Tire Positions";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if (isset($_GET["code"]) && $_GET["code"] != "")
            $wherclause .= "AND code LIKE '%" . $_GET["code"] . "%'";

        if (isset($_GET["left_right"]) && $_GET["left_right"] != "")
            $wherclause .= "AND left_right = '" . $_GET["left_right"] . "'";

        if (isset($_GET["front_rear"]) && $_GET["front_rear"] != "")
            $wherclause .= "AND front_rear = '" . $_GET["front_rear"] . "'";

        if (isset($_GET["inner_outter"]) && $_GET["inner_outter"] != "")
            $wherclause .= "AND inner_outter = '" . $_GET["inner_outter"] . "'";

        if ($tire_positions = $this->tire_positions->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->tire_positions->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["tire_positions"] = $tire_positions;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tire_positions/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $tire_position = [
                "name"          => @$_POST["name"],
                "code"          => @$_POST["code"],
                "left_right"    => @$_POST["left_right"],
                "front_rear"    => @$_POST["front_rear"],
                "inner_outter"  => @$_POST["inner_outter"],
            ];
            $tire_position = $tire_position + $this->created_values() + $this->updated_values();
            if ($this->tire_positions->save($tire_position))
                $this->session->setFlashdata("flash_message", ["success", "Success adding Tire Position"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding Tire Position"]);
            return redirect()->to(base_url() . '/tire_positions');
        }

        $data["__modulename"] = "Add Tire Position";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tire_positions/v_edit');
        echo view('v_footer');
        echo view('tire_positions/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $tire_position = [
                "name"          => @$_POST["name"],
                "code"          => @$_POST["code"],
                "left_right"    => @$_POST["left_right"],
                "front_rear"    => @$_POST["front_rear"],
                "inner_outter"  => @$_POST["inner_outter"],
            ];
            $tire_position = $tire_position + $this->updated_values();
            if ($this->tire_positions->update($id, $tire_position))
                $this->session->setFlashdata("flash_message", ["success", "Success editing tire Position"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing tire Position"]);
            return redirect()->to(base_url() . '/tire_positions');
        }

        $data["__modulename"] = "Edit Tire Position";
        $data["tire_position"] = $this->tire_positions->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('tire_positions/v_edit');
        echo view('v_footer');
        echo view('tire_positions/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->tire_positions->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting tire position"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting tire position"]);
        return redirect()->to(base_url() . '/tire_positions');
    }
}
