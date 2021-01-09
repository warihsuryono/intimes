<?php

namespace App\Controllers;

use App\Models\m_so;
use App\Models\m_so_detail;
use App\Models\m_customer;
use App\Models\m_item;
use App\Models\m_currency;
use App\Models\m_payment_type;
use App\Models\m_quotation;
use App\Models\m_unit;
use App\Models\m_item_type;
use App\Models\m_item_scope;
use App\Models\m_so_file;

class So extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $so_;
    protected $so_details;
    protected $quotations;
    protected $customers;
    protected $items;
    protected $currencies;
    protected $payment_types;
    protected $units;
    protected $item_types;
    protected $item_scopes;
    protected $so_files;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "so";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->so_ =  new m_so();
        $this->so_details =  new m_so_detail();
        $this->quotations =  new m_quotation();
        $this->customers =  new m_customer();
        $this->items =  new m_item();
        $this->currencies =  new m_currency();
        $this->payment_types =  new m_payment_type();
        $this->units =  new m_unit();
        $this->item_types =  new m_item_type();
        $this->item_scopes =  new m_item_scope();
        $this->so_files =  new m_so_file();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Sales Order";
        $data["_this"] = $this;
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["so_no"]) && $_GET["so_no"] != "")
            $wherclause .= "AND so_no LIKE '%" . $_GET["so_no"] . "%'";

        if (isset($_GET["quotation_no"]) && $_GET["quotation_no"] != "")
            $wherclause .= "AND quotation_no LIKE '%" . $_GET["quotation_no"] . "%'";

        if (isset($_GET["customer_id"]) && $_GET["customer_id"] != "")
            $wherclause .= "AND customer_id = '" . $_GET["customer_id"] . "'";

        if (isset($_GET["description"]) && $_GET["description"] != "")
            $wherclause .= "AND description LIKE '%" . $_GET["description"] . "%'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        if (isset($_GET["is_approved"]) && $_GET["is_approved"] != "")
            $wherclause .= "AND is_approved = '" . $_GET["is_approved"] . "'";

        $so_ = $this->so_->where($wherclause)->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        $numrow = count($this->so_->where($wherclause)->findAll());

        foreach ($so_ as $so) {
            $so_detail[$so->id]["customer"] = @$this->customers->where("id", $so->customer_id)->get()->getResult()[0]->company_name;
            $so_detail[$so->id]["payment_type"] = @$this->payment_types->where("id", $so->payment_type_id)->get()->getResult()[0]->name;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["customers"] = $this->customers->where("is_deleted", 0)->findAll();
        $data["so_"] = $so_;
        $data["so_detail"] = @$so_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('so_/v_list');
        echo view('v_footer');
    }

    public function saving_data($mode)
    {
        if (@$_POST["quotation_no"] != "") $quotation_id = @$this->quotations->where("quotation_no", @$_POST["quotation_no"])->get()->getResult()[0]->id;
        else $quotation_id = "";
        if (@$_POST["total_to_say_lang"] == "en") $total_to_say = $this->number_to_words(@$_POST["total"]);
        else $total_to_say = $this->angka_kalimat(@$_POST["total"]);
        return [
            "quotation_id" => $quotation_id,
            "quotation_no" => @$_POST["quotation_no"],
            "so_no" => @$_POST["so_no"],
            "so_at" => @$_POST["so_at"],
            "customer_id" => @$_POST["customer_id"],
            "currency_id" => @$_POST["currency_id"],
            "is_tax" => @$_POST["is_tax"],
            "description" => @$_POST["description"],
            "shipment_company" => @$_POST["shipment_company"],
            "shipment_pic" => @$_POST["shipment_pic"],
            "shipment_phone" => @$_POST["shipment_phone"],
            "shipment_address" => @$_POST["shipment_address"],
            "shipment_at" => @$_POST["shipment_at"],
            "dp" => str_replace(",", "", @$_POST["dp"]),
            "payment_type_id" => @$_POST["payment_type_id"],
            "disc" => str_replace(",", "", @$_POST["disc"]),
            "subtotal" => str_replace(",", "", @$_POST["subtotal"]),
            "after_disc" => str_replace(",", "", @$_POST["after_disc"]),
            "tax" => str_replace(",", "", @$_POST["tax"]),
            "total" => str_replace(",", "", @$_POST["total"]),
            "total_to_say" => $total_to_say,
            "total_to_say_lang" => @$_POST["total_to_say_lang"],
        ];
    }

    public function get_so_no()
    {
        $so_no = $this->letter_no_template("letter_so_temp");
        $so_seqno = @$this->so_->where("so_no LIKE '" . $so_no . "'")->where("is_deleted", 0)->orderBy("id DESC")->findAll()[0]->so_no;
        if ($so_seqno == "")
            $so_no = str_replace("%", "001", $so_no);
        else {
            $so_temp = str_replace("%", "", $so_no);
            $seqno = str_replace($so_temp, "", $so_seqno) * 1;
            $seqno++;
            $so_no = str_replace("%", $this->numberpad($seqno, 3), $so_no);
        }
        return $so_no;
    }

    public function saving_add()
    {
        if (isset($_POST["Save"])) {
            $so = $this->saving_data($_POST["mode"]);
            $so = $so + $this->created_values() + $this->updated_values();

            $this->so_->save($so);
            $id = $this->so_->insertID();
            foreach ($_POST["item_id"] as $key => $item_id) {
                $item_scope_ids = "";
                if (is_array($_POST["item_scope_ids"][$key])) {
                    foreach ($_POST["item_scope_ids"][$key] as $item_scope_id) {
                        $item_scope_ids .= "|" . $item_scope_id . "|";
                    }
                }
                $so_detail = [
                    "so_id" => $id,
                    "item_id" => $item_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "item_scope_ids" => $item_scope_ids,
                    "qty" => str_replace(",", "", @$_POST["qty"][$key]),
                    "price" => str_replace(",", "", @$_POST["price"][$key]),
                    "notes" => @$_POST["notes"][$key],
                ];
                $so_detail = $so_detail + $this->created_values() + $this->updated_values();
                $this->so_details->save($so_detail);
            }

            if ($_files = $this->request->getFiles("files")) {
                foreach ($_files["files"] as $key => $files) {
                    if ($files->isValid() && !$files->hasMoved()) {
                        $filename = $id . "_" . $files->getRandomName();
                        if (@$_POST["file_types"][$key] == "") $_POST["file_types"][$key] = @$_POST["file_types_other"][$key];
                        $so_files = [
                            "so_id" => $id,
                            "file_types" => @$_POST["file_types"][$key],
                            "dok_no"    => @$_POST["dok_no"][$key],
                            "files"     => $filename,
                            "notes"     => @$_POST["filenotes"][$key],
                        ];
                        if ($files->move(WRITEPATH . 'uploads', $filename)) {
                            $so_files = $so_files + $this->created_values() + $this->updated_values();
                            $this->so_files->save($so_files);
                        }
                    }
                }
            }

            if ($_POST["mode"] == "add" && $so["quotation_id"] != "")
                $this->quotations->update($so["quotation_id"], ["is_so" => 1, "so_at" => date("Y-m-d H:i:s"), "so_by" => $this->session->get("username"), "so_ip" => $_SERVER["REMOTE_ADDR"]]);

            $this->session->setFlashdata("flash_message", ["success", "Success adding Sales Order"]);
            echo "<script> window.location='" . base_url() . "/so/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function saving_edit($id)
    {
        if (isset($_POST["Save"])) {
            $so = $this->saving_data($_POST["mode"]);
            $so = $so + $this->updated_values();
            $this->so_->update($id, $so);
            $this->so_details->where('so_id', $id)->delete();
            foreach ($_POST["item_id"] as $key => $item_id) {
                $item_scope_ids = "";
                if (is_array($_POST["item_scope_ids"][$key])) {
                    foreach ($_POST["item_scope_ids"][$key] as $item_scope_id) {
                        $item_scope_ids .= "|" . $item_scope_id . "|";
                    }
                }
                $so_detail = [
                    "so_id" => $id,
                    "item_id" => $item_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "item_scope_ids" => $item_scope_ids,
                    "qty" => str_replace(",", "", @$_POST["qty"][$key]),
                    "price" => str_replace(",", "", @$_POST["price"][$key]),
                    "notes" => @$_POST["notes"][$key],
                ];
                $so_detail = $so_detail + $this->created_values() + $this->updated_values();
                $this->so_details->save($so_detail);
            }

            $this->so_files->where('so_id', $id)->delete();
            if ($_files = $this->request->getFiles("files")) {
                foreach ($_files["files"] as $key => $files) {
                    if ($files->isValid() && !$files->hasMoved()) {
                        $filename = $id . "_" . $files->getRandomName();
                        if (@$_POST["file_types"][$key] == "") $_POST["file_types"][$key] = @$_POST["file_types_other"][$key];
                        $so_files = [
                            "so_id" => $id,
                            "file_types" => @$_POST["file_types"][$key],
                            "dok_no"    => @$_POST["dok_no"][$key],
                            "files"     => $filename,
                            "notes"     => @$_POST["filenotes"][$key],
                        ];
                        if ($files->move(WRITEPATH . 'uploads', $filename)) {
                            $so_files = $so_files + $this->created_values() + $this->updated_values();
                            $this->so_files->save($so_files);
                        }
                    }
                }
            }

            $this->session->setFlashdata("flash_message", ["success", "Success editing Sales Order"]);
            echo "<script> window.location='" . base_url() . "/so/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function get_reference_data()
    {
        $data["items"] = $this->items->where("is_deleted", 0)->findAll();
        $data["currencies"] = $this->currencies->where("is_deleted", 0)->findAll();
        $data["payment_types"] = $this->payment_types->where("is_deleted", 0)->findAll();
        $data["units"] = $this->units->where("is_deleted", 0)->findAll();
        $data["item_scopes"] = [];
        return $data;
    }

    public function get_saved_data($id)
    {
        $data["so"] = $this->so_->where("is_deleted", 0)->find([$id])[0];
        $data["so_details"] = $this->so_details->where(["is_deleted" => 0, "so_id" => $id])->findAll();
        $data["so_files"] = $this->so_files->where(["is_deleted" => 0, "so_id" => $id])->findAll();
        $data["customer"] = @$this->customers->where("id", $data["so"]->customer_id)->where("is_deleted", 0)->findAll()[0];
        $data["payment_type"] = @$this->payment_types->where("id", $data["so"]->payment_type_id)->where("is_deleted", 0)->findAll()[0];
        $data["currency"] = @$this->currencies->where("id", $data["so"]->currency_id)->where("is_deleted", 0)->findAll()[0];
        $data["created_user"] = @$this->users->where("email", $data["so"]->created_by)->where("is_deleted", 0)->findAll()[0];
        $data["approved_user"] = @$this->users->where("email", $data["so"]->approved_by)->where("is_deleted", 0)->findAll()[0];
        $so_detail_item = [];
        $so_detail_item_type = [];
        $so_detail_unit = [];
        foreach ($data["so_details"] as $so_detail) {
            $item_type_id = @$this->items->where("is_deleted", 0)->find([$so_detail->item_id])[0]->item_type_id;
            $so_detail_item[$so_detail->item_id] = @$this->items->where("id", $so_detail->item_id)->where("is_deleted", 0)->findAll()[0];
            $so_detail_item_type[$so_detail->item_id] = @$this->item_types->where("id", $item_type_id)->where("is_deleted", 0)->findAll()[0];
            $so_detail_unit[$so_detail->item_id] = @$this->units->where("id", $so_detail->unit_id)->where("is_deleted", 0)->findAll()[0];
            $item_scopes = "";
            $xx = 0;
            foreach (explode("|", $so_detail->item_scope_ids) as $item_scope_id) {
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
            $so_detail_item_scopes[$so_detail->item_id] = substr($item_scopes, 0, -2);
        }
        $data["so_detail_item"] = $so_detail_item;
        $data["so_detail_item_type"] = $so_detail_item_type;
        $data["so_detail_unit"] = $so_detail_unit;
        $data["so_detail_item_scopes"] = $so_detail_item_scopes;
        return $data;
    }

    public function approve($id)
    {
        if (@$_GET["approving"] == 1) {
            $this->so_->update($id, ["is_approved" => 1, "approved_at" => date("Y-m-d H:i:s"), "approved_by" => $this->session->get("username"), "approved_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Sales Order"]);
            echo "<script> window.location='" . base_url() . "/so/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_GET["quotation_no"]) && $_GET["quotation_no"] != "") {
            $this->session->setFlashdata("reload_quotation", $_GET["quotation_no"]);
            echo "<script> window.location='" . base_url() . "/so/add'; </script>";
            exit();
        }
        $_POST["so_no"] = $this->get_so_no();
        $this->saving_add();

        $data["__modulename"] = "Add Sales Order";
        $data["__mode"] = "add";

        $data["so_no"] = $_POST["so_no"];
        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('so_/v_edit');
        echo view('v_footer');
        echo view('so_/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        $this->saving_edit($id);
        $data["__modulename"] = "Edit Sales Order";
        $data["__mode"] = "edit";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        if ($data["so"]->is_approved > 0) {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/so');
        }
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('so_/v_edit');
        echo view('v_footer');
        echo view('so_/v_js');
    }

    public function view($id)
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);
        $this->approve($id);

        $data["__modulename"] = "Sales Order";
        $data["_this"] = $this;
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('so_/v_view');
        echo view('v_footer');
        echo view('so_/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->so_->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting Sales Order"]);
        return redirect()->to(base_url() . '/so');
    }

    public function get_so($id)
    {
        $return = [];
        $so = @$this->so_->where("is_deleted", 0)->find([$id])[0];
        $customer = @$this->customers->where("id", $so->customer_id)->where("is_deleted", 0)->findAll()[0];
        $so->customer_name = $customer->company_name;
        $return = $so;
        return json_encode($return);
    }

    public function get_so_detail($id)
    {
        $return = [];
        $so_details = $this->so_details->where("so_id", $id)->where("is_deleted", 0)->findAll();
        foreach ($so_details as $key => $so_detail) {
            $item = @$this->items->where("id", $so_detail->item_id)->where("is_deleted", 0)->findAll()[0];
            $return[$key]["id"] = $so_detail->id;
            $return[$key]["so_id"] = $so_detail->so_id;
            $return[$key]["item_id"] = $so_detail->item_id;
            $return[$key]["item_name"] = @$item->name;
            $return[$key]["unit_id"] = $so_detail->unit_id;
            $return[$key]["qty"] = $so_detail->qty;
            $return[$key]["price"] = $so_detail->price;
            $return[$key]["notes"] = $so_detail->notes;
        }
        return json_encode($return);
    }
}
