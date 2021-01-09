<?php

namespace App\Controllers;

use App\Models\m_payment_type;

class Payment_type extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $payment_types;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "payment_types";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->payment_types =  new m_payment_type();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Item Types";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($payment_types = $this->payment_types->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->payment_types->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["payment_types"] = $payment_types;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('payment_types/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $payment_type = [
                "name" => @$_POST["name"],
                "description" => @$_POST["description"],
            ];
            $payment_type = $payment_type + $this->created_values() + $this->updated_values();
            if ($this->payment_types->save($payment_type))
                $this->session->setFlashdata("flash_message", ["success", "Success adding payment type"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding payment type"]);
            return redirect()->to(base_url() . '/payment_types');
        }

        $data["__modulename"] = "Add Item Type";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('payment_types/v_edit');
        echo view('v_footer');
        echo view('payment_types/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $payment_type = [
                "name" => @$_POST["name"],
                "description" => @$_POST["description"],
            ];
            $payment_type = $payment_type + $this->updated_values();
            if ($this->payment_types->update($id, $payment_type))
                $this->session->setFlashdata("flash_message", ["success", "Success editing payment type"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing payment type"]);
            return redirect()->to(base_url() . '/payment_types');
        }

        $data["__modulename"] = "Edit Item Type";
        $data["payment_type"] = $this->payment_types->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('payment_types/v_edit');
        echo view('v_footer');
        echo view('payment_types/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->payment_types->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting payment type"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting payment type"]);
        return redirect()->to(base_url() . '/payment_types');
    }
}
