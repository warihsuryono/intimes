<?php

namespace App\Controllers;

use App\Models\m_benefit;

class Benefit extends BaseController
{
    protected $benefits;

    public function __construct()
    {
        parent::__construct();
        $this->benefits =  new m_benefit();
    }

    public function index()
    {

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Benefits";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";
        
        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($benefits = $this->benefits->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->benefits->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["benefits"] = $benefits;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('benefits/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        if (isset($_POST["Save"])) {
            $benefit = [
                "name" => @$_POST["name"],
            ];
            $benefit = $benefit + $this->created_values() + $this->updated_values();
            if ($this->benefits->save($benefit))
                $this->session->setFlashdata("flash_message", ["success", "Success adding benefit"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding benefit"]);
            return redirect()->to(base_url() . '/benefits');
        }

        $data["__modulename"] = "Add Benefit";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('benefits/v_edit');
        echo view('v_footer');
        echo view('benefits/v_js');
    }

    public function edit($id)
    {
        if (isset($_POST["Save"])) {
            $benefit = [
                "name" => @$_POST["name"],
            ];
            $benefit = $benefit + $this->updated_values();
            if ($this->benefits->update($id, $benefit))
                $this->session->setFlashdata("flash_message", ["success", "Success editing benefit"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing benefit"]);
            return redirect()->to(base_url() . '/benefits');
        }

        $data["__modulename"] = "Edit Benefit";
        $data["benefit"] = $this->benefits->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('benefits/v_edit');
        echo view('v_footer');
        echo view('benefits/v_js');
    }

    public function delete($id)
    {
        if ($this->benefits->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting benefit"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting benefit"]);
        return redirect()->to(base_url() . '/benefits');
    }
}
