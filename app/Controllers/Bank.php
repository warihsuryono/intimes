<?php

namespace App\Controllers;

use App\Models\m_bank;
use App\Models\m_currency;
use App\Models\m_coa;

class Bank extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $banks;
    protected $currencies;
    protected $coas;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "banks";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->banks =  new m_bank();
        $this->currencies =  new m_currency();
        $this->coas =  new m_coa();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Banks";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["code"]) && $_GET["code"] != "")
            $wherclause .= "AND code LIKE '%" . $_GET["code"] . "%'";

        if (isset($_GET["coa"]) && $_GET["coa"] != "")
            $wherclause .= "AND coa LIKE '%" . $_GET["coa"] . "%'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if (isset($_GET["norek"]) && $_GET["norek"] != "")
            $wherclause .= "AND norek LIKE '%" . $_GET["norek"] . "%'";

        if ($banks = $this->banks->where($wherclause)->findAll(MAX_ROW, $startrow)) {

            $numrow = count($this->banks->where($wherclause)->findAll());

            foreach ($banks as $bank) {
                $coa = @$this->coas->where("coa", $bank->coa)->get()->getResult()[0];
                $bank_detail[$bank->id]["coa"] = @$coa->coa . " -- " . @$coa->description;
                $bank_detail[$bank->id]["currency"] = $this->currencies->where("id", $bank->currency_id)->get()->getResult()[0]->name;
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["banks"] = $banks;
        $data["bank_detail"] = @$bank_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('banks/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $bank = [
                "code" => @$_POST["code"],
                "coa" => @$_POST["coa"],
                "name" => @$_POST["name"],
                "norek" => @$_POST["norek"],
                "currency_id" => @$_POST["currency_id"],
                "is_debt" => @$_POST["is_debt"],
                "description" => @$_POST["description"],
            ];
            $bank = $bank + $this->created_values() + $this->updated_values();
            if ($this->banks->save($bank))
                $this->session->setFlashdata("flash_message", ["success", "Success adding bank"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding bank"]);
            return redirect()->to(base_url() . '/bank');
        }

        $data["__modulename"] = "Add Bank";
        $data["currencies"] = $this->currencies->where("is_deleted", 0)->findAll();
        $data["coas"] = $this->coas->where("is_deleted", 0)->findAll();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('banks/v_edit');
        echo view('v_footer');
        echo view('banks/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $bank = [
                "code" => @$_POST["code"],
                "coa" => @$_POST["coa"],
                "name" => @$_POST["name"],
                "norek" => @$_POST["norek"],
                "currency_id" => @$_POST["currency_id"],
                "is_debt" => @$_POST["is_debt"],
                "description" => @$_POST["description"],
            ];
            $bank = $bank + $this->updated_values();
            if ($this->banks->update($id, $bank))
                $this->session->setFlashdata("flash_message", ["success", "Success editing bank"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing bank"]);
            return redirect()->to(base_url() . '/bank');
        }

        $data["__modulename"] = "Edit Bank";
        $data["currencies"] = $this->currencies->where("is_deleted", 0)->findAll();
        $data["coas"] = $this->coas->where("is_deleted", 0)->findAll();
        $data["bank"] = $this->banks->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('banks/v_edit');
        echo view('v_footer');
        echo view('banks/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->banks->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting bank"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting bank"]);
        return redirect()->to(base_url() . '/bank');
    }
}
