<?php

namespace App\Controllers;

use App\Models\m_customer_level;

class Customer_level extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $customer_levels;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "customer_levels";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->customer_levels =  new m_customer_level();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Customer Levels";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($customer_levels = $this->customer_levels->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->customer_levels->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["customer_levels"] = $customer_levels;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('customer_levels/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $customer_level = [
                "name" => @$_POST["name"],
                "description" => @$_POST["description"],
            ];
            $customer_level = $customer_level + $this->created_values() + $this->updated_values();
            if ($this->customer_levels->save($customer_level))
                $this->session->setFlashdata("flash_message", ["success", "Success adding customer level"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding customer level"]);
            return redirect()->to(base_url() . '/customer_levels');
        }

        $data["__modulename"] = "Add Customer Level";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('customer_levels/v_edit');
        echo view('v_footer');
        echo view('customer_levels/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $customer_level = [
                "name" => @$_POST["name"],
                "description" => @$_POST["description"],
            ];
            $customer_level = $customer_level + $this->updated_values();
            if ($this->customer_levels->update($id, $customer_level))
                $this->session->setFlashdata("flash_message", ["success", "Success editing customer level"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing customer level"]);
            return redirect()->to(base_url() . '/customer_levels');
        }

        $data["__modulename"] = "Edit Customer Level";
        $data["customer_level"] = $this->customer_levels->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('customer_levels/v_edit');
        echo view('v_footer');
        echo view('customer_levels/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->customer_levels->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting customer level"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting customer level"]);
        return redirect()->to(base_url() . '/customer_levels');
    }
}
