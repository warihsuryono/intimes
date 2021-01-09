<?php

namespace App\Controllers;

use App\Models\m_relation;

class Relation extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $relations;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "relations";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->relations =  new m_relation();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Relations";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($relations = $this->relations->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->relations->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["relations"] = $relations;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('relations/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $relation = [
                "name" => @$_POST["name"],
            ];
            $relation = $relation + $this->created_values() + $this->updated_values();
            if ($this->relations->save($relation))
                $this->session->setFlashdata("flash_message", ["success", "Success adding relation"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding relation"]);
            return redirect()->to(base_url() . '/relations');
        }

        $data["__modulename"] = "Add Relation";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('relations/v_edit');
        echo view('v_footer');
        echo view('relations/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $relation = [
                "name" => @$_POST["name"],
            ];
            $relation = $relation + $this->updated_values();
            if ($this->relations->update($id, $relation))
                $this->session->setFlashdata("flash_message", ["success", "Success editing relation"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing relation"]);
            return redirect()->to(base_url() . '/relations');
        }

        $data["__modulename"] = "Edit Relation";
        $data["relation"] = $this->relations->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('relations/v_edit');
        echo view('v_footer');
        echo view('relations/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->relations->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting relation"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting relation"]);
        return redirect()->to(base_url() . '/relations');
    }
}
