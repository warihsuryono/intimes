<?php

namespace App\Controllers;

use App\Models\m_quotation;
use App\Models\m_quotation_detail;
use App\Models\m_customer;
use App\Models\m_item;
use App\Models\m_currency;
use App\Models\m_unit;
use App\Models\m_item_type;
use App\Models\m_item_scope;

class Quotation extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $quotation_;
    protected $quotation_details;
    protected $customers;
    protected $items;
    protected $currencies;
    protected $units;
    protected $item_types;
    protected $item_scopes;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "quotation";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->quotations =  new m_quotation();
        $this->quotation_details =  new m_quotation_detail();
        $this->customers =  new m_customer();
        $this->items =  new m_item();
        $this->currencies =  new m_currency();
        $this->units =  new m_unit();
        $this->item_types =  new m_item_type();
        $this->item_scopes =  new m_item_scope();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Quotations";
        $data["_this"] = $this;
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["quotation_no"]) && $_GET["quotation_no"] != "")
            $wherclause .= "AND quotation_no LIKE '%" . $_GET["quotation_no"] . "%'";

        if (isset($_GET["customer_id"]) && $_GET["customer_id"] != "")
            $wherclause .= "AND customer_id = '" . $_GET["customer_id"] . "'";

        if (isset($_GET["request_no"]) && $_GET["request_no"] != "")
            $wherclause .= "AND request_no LIKE '%" . $_GET["request_no"] . "%'";

        if (isset($_GET["request_at"]) && $_GET["request_at"] != "")
            $wherclause .= "AND request_at LIKE '%" . $_GET["request_at"] . "%'";

        if (isset($_GET["description"]) && $_GET["description"] != "")
            $wherclause .= "AND description LIKE '%" . $_GET["description"] . "%'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        if (isset($_GET["is_approved"]) && $_GET["is_approved"] != "")
            $wherclause .= "AND is_approved = '" . $_GET["is_approved"] . "'";

        if (isset($_GET["is_so"]) && $_GET["is_so"] != "")
            $wherclause .= "AND is_so = '" . $_GET["is_so"] . "'";

        $quotations = $this->quotations->where($wherclause)->orderBy("id DESC")->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        $numrow = count($this->quotations->where($wherclause)->findAll());

        foreach ($quotations as $quotation) {
            $quotation_detail[$quotation->id]["customer"] = @$this->customers->where("id", $quotation->customer_id)->get()->getResult()[0]->company_name;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["customers"] = $this->customers->where("is_deleted", 0)->findAll();
        $data["quotations"] = $quotations;
        $data["quotation_detail"] = @$quotation_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('quotations/v_list');
        echo view('v_footer');
    }

    public function get_quotation_no()
    {
        $quotation_no = $this->letter_no_template("letter_quotation_temp");
        $quotation_seqno = @$this->quotations->where("quotation_no LIKE '" . $quotation_no . "'")->where("is_deleted", 0)->orderBy("id DESC")->findAll()[0]->quotation_no;
        if ($quotation_seqno == "")
            $quotation_no = str_replace("%", "001", $quotation_no);
        else {
            $quotation_temp = str_replace("%", "", $quotation_no);
            $seqno = str_replace($quotation_temp, "", $quotation_seqno) * 1;
            $seqno++;
            $quotation_no = str_replace("%", $this->numberpad($seqno, 3), $quotation_no);
        }
        return $quotation_no;
    }

    public function saving_data($mode)
    {
        return [
            "quotation_no" => @$_POST["quotation_no"],
            "revisi" => @$_POST["revisi"],
            "quotation_at" => @$_POST["quotation_at"],
            "customer_id" => @$_POST["customer_id"],
            "attn" => @$_POST["attn"],
            "request_no" => @$_POST["request_no"],
            "request_at" => @$_POST["request_at"],
            "currency_id" => @$_POST["currency_id"],
            "is_tax" => @$_POST["is_tax"],
            "description" => @$_POST["description"],
            "price_notes" => @$_POST["price_notes"],
            "payment_notes" => @$_POST["payment_notes"],
            "execution_time" => @$_POST["execution_time"],
            "execution_at" => @$_POST["execution_at"],
            "validation_notes" => @$_POST["validation_notes"],
            "dp" => str_replace(",", "", @$_POST["dp"]),
            "disc" => str_replace(",", "", @$_POST["disc"]),
            "subtotal" => str_replace(",", "", @$_POST["subtotal"]),
            "after_disc" => str_replace(",", "", @$_POST["after_disc"]),
            "tax" => str_replace(",", "", @$_POST["tax"]),
            "total" => str_replace(",", "", @$_POST["total"]),
            "total_to_say" => $this->number_to_words(@$_POST["total"]),
        ];
    }

    public function saving_add_revision()
    {
        if (isset($_POST["Save"])) {
            $quotation = $this->saving_data($_POST["mode"]);
            if ($_POST["mode"] == "revision") {
                $created = $this->quotations->where("quotation_no", $_POST["quotation_no"])->where("revisi", 0)->findAll()[0];
                $created_at = $created->created_at;
                $created_by = $created->created_by;
                $created_ip = $created->created_ip;
                $quotation = $quotation + ["created_at" => $created_at, "created_by" => $created_by, "created_ip" => $created_ip];
                $quotation = $quotation + ["revised_at" => date("Y-m-d H:i:s"), "revised_by" => $this->session->get("username"), "revised_ip" => $_SERVER["REMOTE_ADDR"]];
            } else $quotation = $quotation + $this->created_values();

            $quotation = $quotation + $this->updated_values();

            $this->quotations->save($quotation);
            $id = $this->quotations->insertID();
            foreach ($_POST["item_id"] as $key => $item_id) {
                $item_scope_ids = "";
                if (is_array($_POST["item_scope_ids"][$key])) {
                    foreach ($_POST["item_scope_ids"][$key] as $item_scope_id) {
                        $item_scope_ids .= "|" . $item_scope_id . "|";
                    }
                }
                $quotation_detail = [
                    "quotation_id" => $id,
                    "item_id" => $item_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "item_scope_ids" => $item_scope_ids,
                    "qty" => str_replace(",", "", @$_POST["qty"][$key]),
                    "price" => str_replace(",", "", @$_POST["price"][$key]),
                    "notes" => @$_POST["notes"][$key],
                ];
                $quotation_detail = $quotation_detail + $this->created_values() + $this->updated_values();
                $this->quotation_details->save($quotation_detail);
            }

            $this->session->setFlashdata("flash_message", ["success", "Success adding Quotation"]);
            echo "<script> window.location='" . base_url() . "/quotation/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function saving_edit($id)
    {
        if (isset($_POST["Save"])) {
            $quotation = $this->saving_data($_POST["mode"]);
            $quotation = $quotation + $this->updated_values();
            $this->quotations->update($id, $quotation);
            $this->quotation_details->where('quotation_id', $id)->delete();
            foreach ($_POST["item_id"] as $key => $item_id) {
                $item_scope_ids = "";
                if (is_array($_POST["item_scope_ids"][$key])) {
                    foreach (@$_POST["item_scope_ids"][$key] as $item_scope_id) {
                        $item_scope_ids .= "|" . $item_scope_id . "|";
                    }
                }
                $quotation_detail = [
                    "quotation_id" => $id,
                    "item_id" => $item_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "item_scope_ids" => $item_scope_ids,
                    "qty" => str_replace(",", "", @$_POST["qty"][$key]),
                    "price" => str_replace(",", "", @$_POST["price"][$key]),
                    "notes" => @$_POST["notes"][$key],
                ];
                $quotation_detail = $quotation_detail + $this->created_values() + $this->updated_values();
                $this->quotation_details->save($quotation_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success editing Quotation"]);
            echo "<script> window.location='" . base_url() . "/quotation/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function get_reference_data()
    {
        $data["customers"] = $this->customers->where("is_deleted", 0)->findAll();
        $data["items"] = $this->items->where("is_deleted", 0)->findAll();
        $data["currencies"] = $this->currencies->where("is_deleted", 0)->findAll();
        $data["units"] = $this->units->where("is_deleted", 0)->findAll();
        $data["item_scopes"] = [];
        return $data;
    }

    public function get_saved_data($id)
    {
        $data["quotation"] = $this->quotations->where("is_deleted", 0)->find([$id])[0];
        $data["quotation_details"] = $this->quotation_details->where(["is_deleted" => 0, "quotation_id" => $id])->findAll();
        $data["customer"] = @$this->customers->where("id", $data["quotation"]->customer_id)->where("is_deleted", 0)->findAll()[0];
        $data["currency"] = @$this->currencies->where("id", $data["quotation"]->currency_id)->where("is_deleted", 0)->findAll()[0];
        $data["created_user"] = @$this->users->where("email", $data["quotation"]->created_by)->where("is_deleted", 0)->findAll()[0];
        $data["approved_user"] = @$this->users->where("email", $data["quotation"]->approved_by)->where("is_deleted", 0)->findAll()[0];
        $quotation_detail_item = [];
        $quotation_detail_item_type = [];
        $quotation_detail_unit = [];
        foreach ($data["quotation_details"] as $quotation_detail) {
            $item_type_id = @$this->items->where("is_deleted", 0)->find([$quotation_detail->item_id])[0]->item_type_id;
            $quotation_detail_item[$quotation_detail->item_id] = @$this->items->where("id", $quotation_detail->item_id)->where("is_deleted", 0)->findAll()[0];
            $quotation_detail_item_type[$quotation_detail->item_id] = @$this->item_types->where("id", $item_type_id)->where("is_deleted", 0)->findAll()[0];
            $quotation_detail_unit[$quotation_detail->item_id] = @$this->units->where("id", $quotation_detail->unit_id)->where("is_deleted", 0)->findAll()[0];
            $item_scopes = "";
            $xx = 0;
            foreach (explode("|", $quotation_detail->item_scope_ids) as $item_scope_id) {
                if ($item_scope_id != "") {
                    $item_scope = $this->item_scopes->where("id", $item_scope_id)->get()->getResult()[0];
                    if ($xx > 7) {
                        $item_scopes .= "<br>";
                        $xx = 0;
                    }
                    $item_scopes .= $item_scope->name . " " . $this->units->where("id", $item_scope->unit_id)->get()->getResult()[0]->name . ", ";
                    $xx++;
                }
            }
            $quotation_detail_item_scopes[$quotation_detail->item_id] = substr($item_scopes, 0, -2);
        }
        $data["quotation_detail_item"] = $quotation_detail_item;
        $data["quotation_detail_item_type"] = $quotation_detail_item_type;
        $data["quotation_detail_unit"] = $quotation_detail_unit;
        $data["quotation_detail_item_scopes"] = $quotation_detail_item_scopes;
        return $data;
    }

    public function approve($id)
    {
        if (@$_GET["approving"] == 1) {
            $this->quotations->update($id, ["is_approved" => 1, "approved_at" => date("Y-m-d H:i:s"), "approved_by" => $this->session->get("username"), "approved_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Quotation"]);
            echo "<script> window.location='" . base_url() . "/quotation/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        $_POST["quotation_no"] = $this->get_quotation_no();
        $this->saving_add_revision();

        $data["__modulename"] = "Add Quotation";
        $data["__mode"] = "add";

        $data["quotation_no"] = $_POST["quotation_no"];
        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('quotations/v_edit');
        echo view('v_footer');
        echo view('quotations/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        $this->saving_edit($id);
        $data["__modulename"] = "Edit Quotation";
        $data["__mode"] = "edit";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        if ($data["quotation"]->is_approved > 0) {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/quotation');
        }
        $data = $data + ["revisi" => @$this->quotations->where("quotation_no", $data["quotation"]->quotation_no)->where("is_deleted", 0)->orderBy("revisi DESC")->findAll()[0]->revisi];
        if ($data["quotation"]->is_so > 0) {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/quotation');
        }
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('quotations/v_edit');
        echo view('v_footer');
        echo view('quotations/v_js');
    }

    public function revision($id)
    {
        $this->saving_add_revision();

        $data["__modulename"] = "Revision Quotation";
        $data["__mode"] = "revision";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + ["revisi" => @$this->quotations->where("quotation_no", $data["quotation"]->quotation_no)->where("is_deleted", 0)->orderBy("revisi DESC")->findAll()[0]->revisi + 1];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('quotations/v_edit');
        echo view('v_footer');
        echo view('quotations/v_js');
    }

    public function view($id)
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);
        $this->approve($id);

        $data["__modulename"] = "Quotation";
        $data["_this"] = $this;
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + ["revisi" => @$this->quotations->where("quotation_no", $data["quotation"]->quotation_no)->where("is_deleted", 0)->orderBy("revisi DESC")->findAll()[0]->revisi];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('quotations/v_view');
        echo view('v_footer');
        echo view('quotations/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->quotations->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting Quotation"]);
        return redirect()->to(base_url() . '/quotation');
    }

    public function get_quotation()
    {
        $quotation_no = $_GET["quotation_no"];
        $return = [];
        $quotation = @$this->quotations->where("is_deleted", 0)->where(["quotation_no" => $quotation_no])->findAll()[0];
        $customer = @$this->customers->where("id", $quotation->customer_id)->where("is_deleted", 0)->findAll()[0];
        $quotation->customer_name = $customer->company_name;
        $return = $quotation;
        return json_encode($return);
    }

    public function get_quotation_detail($id)
    {
        $return = [];
        $quotation_details = $this->quotation_details->where("quotation_id", $id)->where("is_deleted", 0)->findAll();
        foreach ($quotation_details as $key => $quotation_detail) {
            $item = @$this->items->where("id", $quotation_detail->item_id)->where("is_deleted", 0)->findAll()[0];
            $item_type = @$this->item_types->where("id", @$item->item_type_id)->where("is_deleted", 0)->findAll()[0]->name;
            $return[$key]["id"] = $quotation_detail->id;
            $return[$key]["quotation_id"] = $quotation_detail->quotation_id;
            $return[$key]["item_id"] = $quotation_detail->item_id;
            $return[$key]["item_name"] = @$item->name;
            $return[$key]["unit_id"] = $quotation_detail->unit_id;
            $return[$key]["item_type"] = @$item_type;
            $return[$key]["item_scope_ids"] = str_replace("|", "", str_replace("||", ",", $quotation_detail->item_scope_ids));
            $return[$key]["qty"] = $quotation_detail->qty;
            $return[$key]["price"] = $quotation_detail->price;
            $return[$key]["notes"] = $quotation_detail->notes;
        }
        return json_encode($return);
    }
}
