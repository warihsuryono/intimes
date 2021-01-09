<?php

namespace App\Controllers;

use App\Models\m_coa;

class Coa extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $coas;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "coa";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->coas =  new m_coa();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "COA";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["coa"]) && $_GET["coa"] != "")
            $wherclause .= "AND coa LIKE '%" . $_GET["coa"] . "%'";

        if (isset($_GET["parent_coa"]) && $_GET["parent_coa"] != "")
            $wherclause .= "AND parent_coa = '" . $_GET["parent_coa"] . "'";

        if (isset($_GET["description"]) && $_GET["description"] != "")
            $wherclause .= "AND description LIKE '%" . $_GET["description"] . "%'";

        if ($coas = $this->coas->where($wherclause)->orderBy("coa")->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->coas->where($wherclause)->findAll());

            foreach ($coas as $coa) {
                $parent_coa = @$this->coas->where("coa", $coa->parent_coa)->get()->getResult()[0];
                $coa_detail[$coa->id]["parent_coa"] = @$parent_coa->coa . " -- " . @$parent_coa->description;
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["coas"] = $coas;
        $data["coa_detail"] = @$coa_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('coa_/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $coa = [
                "coa" => @$_POST["coa"],
                "parent_coa" => @$_POST["parent_coa"],
                "description" => @$_POST["description"],
            ];
            $coa = $coa + $this->created_values() + $this->updated_values();
            if ($this->coas->save($coa))
                $this->session->setFlashdata("flash_message", ["success", "Success adding COA"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding COA"]);
            return redirect()->to(base_url() . '/coa');
        }

        $data["__modulename"] = "Add COA";
        $data["coas"] = $this->coas->where("is_deleted", 0)->findAll();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('coa_/v_edit');
        echo view('v_footer');
        echo view('coa_/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $coa = [
                "coa" => @$_POST["coa"],
                "parent_coa" => @$_POST["parent_coa"],
                "description" => @$_POST["description"],
            ];
            $coa = $coa + $this->updated_values();
            if ($this->coas->update($id, $coa))
                $this->session->setFlashdata("flash_message", ["success", "Success editing COA"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing COA"]);
            return redirect()->to(base_url() . '/coa');
        }

        $data["__modulename"] = "Edit COA";
        $data["coas"] = $this->coas->where("is_deleted", 0)->findAll();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('coa_/v_edit');
        echo view('v_footer');
        echo view('coa_/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->coas->update($id, ["is_deleted" => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting COA"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting COA"]);
        return redirect()->to(base_url() . '/coa');
    }
}
