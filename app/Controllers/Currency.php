<?php

namespace App\Controllers;

use App\Models\m_currency;

class Currency extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $currencies;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "currencies";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->currencies =  new m_currency();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Currencies";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["id"]) && $_GET["id"] != "")
            $wherclause .= "AND id LIKE '%" . $_GET["id"] . "%'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($currencies = $this->currencies->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->currencies->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["currencies"] = $currencies;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('currencies/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $currency = [
                "id"   => @$_POST["id"],
                "name" => @$_POST["name"],
                "symbol" => @$_POST["symbol"],
                "kurs" => @$_POST["kurs"],
            ];
            $currency = $currency + $this->created_values() + $this->updated_values();
            if ($this->currencies->save($currency))
                $this->session->setFlashdata("flash_message", ["success", "Success adding currency"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding currency"]);
            return redirect()->to(base_url() . '/currencies');
        }

        $data["__modulename"] = "Add Currency";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('currencies/v_edit');
        echo view('v_footer');
        echo view('currencies/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $currency = [
                "id"   => @$_POST["id"],
                "name" => @$_POST["name"],
                "symbol" => @$_POST["symbol"],
                "kurs" => @$_POST["kurs"],
            ];
            $currency = $currency + $this->updated_values();
            if ($this->currencies->update($id, $currency))
                $this->session->setFlashdata("flash_message", ["success", "Success editing currency"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing currency"]);
            return redirect()->to(base_url() . '/currencies');
        }

        $data["__modulename"] = "Edit Currency";
        $data["currency"] = $this->currencies->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('currencies/v_edit');
        echo view('v_footer');
        echo view('currencies/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->currencies->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting currency"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting currency"]);
        return redirect()->to(base_url() . '/currencies');
    }
}
