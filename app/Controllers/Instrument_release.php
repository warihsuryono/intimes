<?php

namespace App\Controllers;

use App\Models\m_instrument_acceptance;
use App\Models\m_instrument_acceptance_detail;
use App\Models\m_request_review;
use App\Models\m_request_review_detail;
use App\Models\m_instrument_process;
use App\Models\m_instrument_process_detail;
use App\Models\m_calibration_form;
use App\Models\m_calibration_form_detail;
use App\Models\m_calibration_verification;
use App\Models\m_calibration_certificate;
use App\Models\m_calibration_certificate_detail;
use App\Models\m_calibration_result;
use App\Models\m_instrument_release;
use App\Models\m_instrument_release_detail;
use App\Models\m_item;
use App\Models\m_item_brand;
use App\Models\m_currency;
use App\Models\m_unit;
use App\Models\m_item_type;
use App\Models\m_item_scope;

class Instrument_release extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $instrument_acceptances;
    protected $instrument_acceptance_details;
    protected $request_reviews;
    protected $request_review_details;
    protected $instrument_processes;
    protected $instrument_process_details;
    protected $calibration_forms;
    protected $calibration_form_details;
    protected $calibration_verifications;
    protected $calibration_certificates;
    protected $calibration_certificate_details;
    protected $calibration_results;
    protected $instrument_releases;
    protected $instrument_release_details;
    protected $items;
    protected $item_brands;
    protected $currencies;
    protected $units;
    protected $item_types;
    protected $item_scopes;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "instrument_releases";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->instrument_acceptances           = new m_instrument_acceptance();
        $this->instrument_acceptance_details    = new m_instrument_acceptance_detail();
        $this->request_reviews                  = new m_request_review();
        $this->request_review_details           = new m_request_review_detail();
        $this->instrument_processes             = new m_instrument_process();
        $this->instrument_process_details       = new m_instrument_process_detail();
        $this->calibration_forms                = new m_calibration_form();
        $this->calibration_form_details         = new m_calibration_form_detail();
        $this->calibration_verifications        = new m_calibration_verification();
        $this->calibration_certificates         = new m_calibration_certificate();
        $this->calibration_certificate_details  = new m_calibration_certificate_detail();
        $this->calibration_results              = new m_calibration_result();
        $this->instrument_releases              = new m_instrument_release();
        $this->instrument_release_details       = new m_instrument_release_detail();
        $this->items                            = new m_item();
        $this->item_brands                      = new m_item_brand();
        $this->currencies                       = new m_currency();
        $this->units                            = new m_unit();
        $this->item_types                       = new m_item_type();
        $this->item_scopes                      = new m_item_scope();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Pengeluaran Alat";
        $data["_this"] = $this;
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["release_at"]) && $_GET["release_at"] != "")
            $wherclause .= "AND release_at LIKE '" . $_GET["release_at"] . "%'";

        if (isset($_GET["received_at"]) && $_GET["received_at"] != "")
            $wherclause .= "AND received_at LIKE '" . $_GET["received_at"] . "%'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        if (isset($_GET["customer_name"]) && $_GET["customer_name"] != "")
            $wherclause .= "AND customer_name  LIKE '%" . $_GET["customer_name"] . "%'";

        $instrument_releases = $this->instrument_releases->where($wherclause)->orderBy("id DESC")->orderBy("id DESC")->findAll(MAX_ROW, $startrow);
        foreach ($instrument_releases as $instrument_release) {
            $instrument_release_detail[$instrument_release->id]["instrument_acceptance"] = @$this->instrument_acceptances->where(["is_deleted" => 0, "id" => $instrument_release->instrument_acceptance_id])->findAll()[0];
        }

        $numrow = count($this->instrument_releases->where($wherclause)->findAll());

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["instrument_releases"] = $instrument_releases;
        $data["instrument_release_detail"] = @$instrument_release_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('instrument_releases/v_list');
        echo view('v_footer');
    }

    public function saving_data()
    {
        $instrument_acceptance = $this->instrument_acceptances->where(["is_deleted" => 0, "id" => @$_POST["instrument_acceptance_id"]])->findAll()[0];
        $received_at = $instrument_acceptance->accepted_at;
        $received_by = $instrument_acceptance->accepted_by;
        return [
            "instrument_acceptance_id" => @$_POST["instrument_acceptance_id"],
            "customer_id" => @$_POST["customer_id"],
            "customer_name" => @$_POST["customer_name"],
            "address" => @$_POST["address"],
            "received_at" => $received_at,
            "received_by" => $received_by,
            "release_at" => @$_POST["release_at"]
        ];
    }

    public function saving_add()
    {
        if (isset($_POST["Save"])) {
            $instrument_release = $this->saving_data() + $this->created_values() + $this->updated_values();
            $this->instrument_releases->save($instrument_release);
            $id = $this->instrument_releases->insertID();
            foreach ($_POST["partno"] as $key => $partno) {
                $instrument_release_detail = [
                    "instrument_release_id" => $id,
                    "partno" => $partno,
                    "serialnumber" => @$_POST["serialnumber"][$key],
                    "description" => @$_POST["description"][$key],
                    "qty" => @$_POST["qty"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $instrument_release_detail = $instrument_release_detail + $this->created_values() + $this->updated_values();
                $this->instrument_release_details->save($instrument_release_detail);
            }

            $this->session->setFlashdata("flash_message", ["success", "Success adding Pengeluaran Alat"]);
            echo "<script> window.location='" . base_url() . "/instrument_release/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function saving_edit($id)
    {
        if (isset($_POST["Save"])) {
            $instrument_release = $this->saving_data() + $this->updated_values();
            $this->instrument_releases->update($id, $instrument_release);
            $this->instrument_release_details->where('instrument_release_id', $id)->delete();
            foreach ($_POST["partno"] as $key => $partno) {
                $instrument_release_detail = [
                    "instrument_release_id" => $id,
                    "partno" => $partno,
                    "serialnumber" => @$_POST["serialnumber"][$key],
                    "description" => @$_POST["description"][$key],
                    "qty" => @$_POST["qty"][$key],
                    "notes" => @$_POST["notes"][$key],
                ];
                $instrument_release_detail = $instrument_release_detail + $this->created_values() + $this->updated_values();
                $this->instrument_release_details->save($instrument_release_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success editing Pengeluaran Alat"]);
            echo "<script> window.location='" . base_url() . "/instrument_release/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function get_reference_data()
    {
        return [];
    }

    public function get_saved_data($id)
    {
        $data["instrument_release"] = $this->instrument_releases->where("is_deleted", 0)->find([$id])[0];
        $data["instrument_release_details"] = $this->instrument_release_details->where(["is_deleted" => 0, "instrument_release_id" => $id])->findAll();
        $data["created_user"] = @$this->users->where("email", $data["instrument_release"]->created_by)->where("is_deleted", 0)->findAll()[0];
        $data["received_user"] = @$this->users->where("email", $data["instrument_release"]->received_by)->where("is_deleted", 0)->findAll()[0];
        $data["release_user"] = @$this->users->where("email", $data["instrument_release"]->release_by)->where("is_deleted", 0)->findAll()[0];
        return $data;
    }

    public function approve($id)
    {
        if (@$_GET["release_approving"] == 1) {
            $this->instrument_releases->update($id, ["release_at" => date("Y-m-d H:i:s"), "dorelease_by" => $this->session->get("username"), "release_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Pengeluaran Alat"]);
            echo "<script> window.location='" . base_url() . "/instrument_release/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        $this->saving_add();

        $data["__modulename"] = "Add Pengeluaran Alat";
        $data["__mode"] = "add";

        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('instrument_releases/v_edit');
        echo view('v_footer');
        echo view('instrument_releases/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        $this->saving_edit($id);
        $data["__modulename"] = "Edit Pengeluaran Alat";
        $data["__mode"] = "edit";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        if ($data["instrument_release"]->release_by != "") {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/instrument_releases');
        }
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('instrument_releases/v_edit');
        echo view('v_footer');
        echo view('instrument_releases/v_js');
    }

    public function view($id)
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);
        $this->approve($id);

        $data["__modulename"] = "Pengeluaran Alat";
        $data["_this"] = $this;
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('instrument_releases/v_view');
        echo view('v_footer');
        echo view('instrument_releases/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->instrument_releases->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting Pengeluaran Alat"]);
        return redirect()->to(base_url() . '/instrument_releases');
    }

    public function get_instrument_release()
    {
        return json_encode(@$this->instrument_releases->where("is_deleted", 0)->where(["id" => $_GET["instrument_release_id"]])->findAll()[0]);
    }

    public function get_instrument_release_detail($id)
    {
        $return = [];
        $instrument_release_details = $this->instrument_release_details->where("instrument_release_id", $id)->where("is_deleted", 0)->findAll();
        foreach ($instrument_release_details as $key => $instrument_release_detail) {
            $return[$key]["id"] = $instrument_release_detail->id;
            $return[$key]["instrument_release_id"] = $instrument_release_detail->instrument_release_id;
            $return[$key]["partno"] = $instrument_release_detail->partno;
            $return[$key]["serialnumber"] = $instrument_release_detail->serialnumber;
            $return[$key]["description"] = $instrument_release_detail->description;
            $return[$key]["qty"] = $instrument_release_detail->qty;
            $return[$key]["notes"] = $instrument_release_detail->notes;
        }
        return json_encode($return);
    }
}
