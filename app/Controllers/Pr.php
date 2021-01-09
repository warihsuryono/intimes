<?php

namespace App\Controllers;

use App\Models\m_po;
use App\Models\m_pr;
use App\Models\m_pr_detail;
use App\Models\m_item;
use App\Models\m_unit;

class Pr extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $po_;
    protected $pr_;
    protected $pr_details;
    protected $items;
    protected $units;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "pr";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->po_ =  new m_po();
        $this->pr_ =  new m_pr();
        $this->pr_details =  new m_pr_detail();
        $this->items =  new m_item();
        $this->units =  new m_unit();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);
        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Purchase Request";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["pr_no"]) && $_GET["pr_no"] != "")
            $wherclause .= "AND pr_no LIKE '%" . $_GET["pr_no"] . "%'";

        if (isset($_GET["description"]) && $_GET["description"] != "")
            $wherclause .= "AND description LIKE '%" . $_GET["description"] . "%'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        if (isset($_GET["is_po"]) && $_GET["is_po"] != "")
            $wherclause .= "AND is_po = '" . $_GET["is_po"] . "'";

        $pr_ = $this->pr_->where($wherclause)->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        $numrow = count($this->pr_->where($wherclause)->findAll());

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["pr_"] = $pr_;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('pr_/v_list');
        echo view('v_footer');
    }

    public function get_pr_no()
    {
        $pr_no = $this->letter_no_template("letter_pr_temp");
        $pr_seqno = @$this->pr_->where("pr_no LIKE '" . $pr_no . "'")->where("is_deleted", 0)->orderBy("id DESC")->findAll()[0]->pr_no;
        if ($pr_seqno == "")
            $pr_no = str_replace("%", "001", $pr_no);
        else {
            $pr_temp = str_replace("%", "", $pr_no);
            $seqno = str_replace($pr_temp, "", $pr_seqno) * 1;
            $seqno++;
            $pr_no = str_replace("%", $this->numberpad($seqno, 3), $pr_no);
        }
        return $pr_no;
    }

    public function saving_data($mode)
    {

        $_POST["pr_no"] = $this->get_pr_no();

        return [
            "pr_no" => $this->get_pr_no(),
            "pr_at" => @$_POST["pr_at"],
            "description" => @$_POST["description"],
        ];
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $pr = $this->saving_data($_POST["mode"]);
            $pr = $pr + $this->created_values();
            $pr = $pr + $this->updated_values();
            $this->pr_->save($pr);
            $id = $this->pr_->insertID();
            foreach ($_POST["item_id"] as $key => $item_id) {
                $pr_detail = [
                    "pr_id" => $id,
                    "item_id" => $item_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "qty" => @$_POST["qty"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $pr_detail = $pr_detail + $this->created_values() + $this->updated_values();
                $this->pr_details->save($pr_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success adding purchase request"]);
            return redirect()->to(base_url() . '/pr/view/' . $id);
        }

        $data["__modulename"] = "Add Purchase Request";
        $data["__mode"] = "add";
        $data["pr_no"] = $this->get_pr_no();
        $data["units"] = $this->units->where("is_deleted", 0)->findAll();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('pr_/v_edit');
        echo view('v_footer');
        echo view('pr_/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $pr = [
                "pr_at" => @$_POST["pr_at"],
                "description" => @$_POST["description"],
            ];
            $pr = $pr + $this->updated_values();
            $this->pr_->update($id, $pr);
            $this->pr_details->where('pr_id', $id)->delete();
            foreach ($_POST["item_id"] as $key => $item_id) {
                $pr_detail = [
                    "pr_id" => $id,
                    "item_id" => $item_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "qty" => @$_POST["qty"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $pr_detail = $pr_detail + $this->created_values() + $this->updated_values();
                $this->pr_details->save($pr_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success editing purchase request"]);
            return redirect()->to(base_url() . '/pr/view/' . $id);
        }
        $data["__modulename"] = "Edit Purchase Request";
        $data["__mode"] = "edit";
        $data["units"] = $this->units->where("is_deleted", 0)->findAll();

        $data["pr"] = $this->pr_->where("is_deleted", 0)->find([$id])[0];
        $data["pr_details"] = $this->pr_details->where(["is_deleted" => 0, "pr_id" => $id])->findAll();
        $data["created_user"] = @$this->users->where("email", $data["pr"]->created_by)->where("is_deleted", 0)->findAll()[0];
        $data["po_user"] = @$this->users->where("email", $data["pr"]->po_by)->where("is_deleted", 0)->findAll()[0];
        $pr_detail_item = [];
        $pr_detail_unit = [];
        foreach ($data["pr_details"] as $pr_detail) {
            $pr_detail_item[$pr_detail->item_id] = @$this->items->where("id", $pr_detail->item_id)->where("is_deleted", 0)->findAll()[0];
            $pr_detail_unit[$pr_detail->item_id] = @$this->units->where("id", $pr_detail->unit_id)->where("is_deleted", 0)->findAll()[0];
        }
        $data["pr_detail_item"] = $pr_detail_item;
        $data["pr_detail_unit"] = $pr_detail_unit;


        if ($data["pr"]->is_po > 0) {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/pr');
        }
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('pr_/v_edit');
        echo view('v_footer');
        echo view('pr_/v_js');
    }

    public function view($id)
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);
        $data["__modulename"] = "Purchase Request";
        $data["__mode"] = "view";
        $data["units"] = $this->units->where("is_deleted", 0)->findAll();

        $data["pr"] = $this->pr_->where("is_deleted", 0)->find([$id])[0];
        $data["pr_details"] = $this->pr_details->where(["is_deleted" => 0, "pr_id" => $id])->findAll();
        $data["created_user"] = @$this->users->where("email", $data["pr"]->created_by)->where("is_deleted", 0)->findAll()[0];
        $data["po_user"] = @$this->users->where("email", $data["pr"]->po_by)->where("is_deleted", 0)->findAll()[0];
        $pr_detail_item = [];
        $pr_detail_unit = [];
        foreach ($data["pr_details"] as $pr_detail) {
            $pr_detail_item[$pr_detail->item_id] = @$this->items->where("id", $pr_detail->item_id)->where("is_deleted", 0)->findAll()[0];
            $pr_detail_unit[$pr_detail->item_id] = @$this->units->where("id", $pr_detail->unit_id)->where("is_deleted", 0)->findAll()[0];
        }
        $data["pr_detail_item"] = $pr_detail_item;
        $data["pr_detail_unit"] = $pr_detail_unit;


        if ($data["pr"]->is_po > 0) {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/pr');
        }
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('pr_/v_view');
        echo view('v_footer');
        echo view('pr_/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->pr_->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting purchase request"]);
        return redirect()->to(base_url() . '/pr');
    }

    public function get_pr()
    {
        $pr_no = urldecode($_GET["pr_no"]);
        return json_encode($this->pr_->where("pr_no", $pr_no)->where("is_deleted", 0)->findAll());
    }

    public function get_pr_detail($id)
    {
        $return = [];
        $pr_details = $this->pr_details->where("pr_id", $id)->where("is_deleted", 0)->findAll();
        foreach ($pr_details as $key => $pr_detail) {
            $item = @$this->items->where("id", $pr_detail->item_id)->where("is_deleted", 0)->findAll()[0];
            $return[$key]["id"] = $pr_detail->id;
            $return[$key]["pr_id"] = $pr_detail->pr_id;
            $return[$key]["item_id"] = $pr_detail->item_id;
            $return[$key]["item_name"] = @$item->name;
            $return[$key]["unit_id"] = $pr_detail->unit_id;
            $return[$key]["qty"] = $pr_detail->qty;
            $return[$key]["notes"] = $pr_detail->notes;
        }
        return json_encode($return);
    }
}
