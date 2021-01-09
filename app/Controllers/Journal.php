<?php

namespace App\Controllers;

use App\Models\m_bank;
use App\Models\m_coa;
use App\Models\m_currency;
use App\Models\m_journal;
use App\Models\m_journal_detail;

class Journal extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $journals;
    protected $journal_details;
    protected $currencies;
    protected $banks;
    protected $coas;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "journals";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->journals =  new m_journal();
        $this->journal_details =  new m_journal_detail();
        $this->currencies =  new m_currency();
        $this->banks =  new m_bank();
        $this->coas =  new m_coa();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Journals";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["journal_at"]) && $_GET["journal_at"] != "")
            $wherclause .= "AND journal_at = '" . $_GET["journal_at"] . "'";

        if (isset($_GET["invoice_no"]) && $_GET["invoice_no"] != "")
            $wherclause .= "AND invoice_no LIKE '%" . $_GET["invoice_no"] . "%'";

        if (isset($_GET["description"]) && $_GET["description"] != "")
            $wherclause .= "AND description LIKE '%" . $_GET["description"] . "%'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        $journals = $this->journals->where($wherclause)->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        $numrow = count($this->journals->where($wherclause)->findAll());

        foreach ($journals as $journal) {
            $journal_detail[$journal->id]["debit"] = $this->journal_details->selectSum('debit')->where("journal_id", $journal->id)->get()->getResult()[0]->debit;
            $journal_detail[$journal->id]["credit"] = $this->journal_details->selectSum('credit')->where("journal_id", $journal->id)->get()->getResult()[0]->credit;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["journals"] = $journals;
        $data["journal_detail"] = @$journal_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('journals/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $journal = [
                "journal_at" => @$_POST["journal_at"],
                "invoice_no" => @$_POST["invoice_no"],
                "description" => @$_POST["description"],
                "currency_id" => @$_POST["currency_id"],
                "bank_id" => @$_POST["bank_id"],
            ];
            $journal = $journal + $this->created_values() + $this->updated_values();
            $this->journals->save($journal);
            $id = $this->journals->insertID();
            foreach ($_POST["coa"] as $key => $coa) {
                $journal_detail = [
                    "journal_id" => $id,
                    "coa" => $coa,
                    "notes" => @$_POST["notes"][$key],
                    "debit" => @$_POST["debit"][$key],
                    "credit" => @$_POST["credit"][$key],
                ];
                $journal_detail = $journal_detail + $this->created_values() + $this->updated_values();
                $this->journal_details->save($journal_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success adding journal"]);
            return redirect()->to(base_url() . '/journal');
        }

        $data["__modulename"] = "Add Journal";
        $data["currencies"] = $this->currencies->where("is_deleted", 0)->findAll();
        $data["banks"] = $this->banks->where("is_deleted", 0)->findAll();
        $data["coas"] = $this->coas->where("is_deleted", 0)->findAll();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('journals/v_edit');
        echo view('v_footer');
        echo view('journals/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $journal = [
                "journal_at" => @$_POST["journal_at"],
                "invoice_no" => @$_POST["invoice_no"],
                "description" => @$_POST["description"],
                "currency_id" => @$_POST["currency_id"],
                "bank_id" => @$_POST["bank_id"],
            ];
            $journal = $journal + $this->updated_values();
            $this->journals->update($id, $journal);
            $this->journal_details->where('journal_id', $id)->delete();
            foreach ($_POST["coa"] as $key => $coa) {
                $journal_detail = [
                    "journal_id" => $id,
                    "coa" => $coa,
                    "notes" => @$_POST["notes"][$key],
                    "debit" => @$_POST["debit"][$key],
                    "credit" => @$_POST["credit"][$key],
                ];
                $journal_detail = $journal_detail + $this->created_values() + $this->updated_values();
                $this->journal_details->save($journal_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success editing journal"]);
            return redirect()->to(base_url() . '/journal');
        }

        $data["__modulename"] = "Edit Journal";
        $data["currencies"] = $this->currencies->where("is_deleted", 0)->findAll();
        $data["banks"] = $this->banks->where("is_deleted", 0)->findAll();
        $data["coas"] = $this->coas->where("is_deleted", 0)->findAll();
        $data["journal"] = $this->journals->where("is_deleted", 0)->find([$id])[0];
        $data["journal_details"] = $this->journal_details->where(["is_deleted" => 0, "journal_id" => $id])->findAll();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('journals/v_edit');
        echo view('v_footer');
        echo view('journals/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->journals->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting journal"]);
        return redirect()->to(base_url() . '/journal');
    }
}
