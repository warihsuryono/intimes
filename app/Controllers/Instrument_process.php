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

class Instrument_process extends BaseController
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
        $this->route_name = "instrument_processes";
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
        $data["__modulename"] = "Pengecekan dan Pengerjaan";
        $data["_this"] = $this;
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["tech_before_at"]) && $_GET["tech_before_at"] != "")
            $wherclause .= "AND tech_before_at LIKE '" . $_GET["tech_before_at"] . "%'";

        if (isset($_GET["tech_after_at"]) && $_GET["tech_after_at"] != "")
            $wherclause .= "AND tech_after_at LIKE '" . $_GET["tech_after_at"] . "%'";

        if (isset($_GET["mgrtech_before_at"]) && $_GET["mgrtech_before_at"] != "")
            $wherclause .= "AND mgrtech_before_at LIKE '" . $_GET["mgrtech_before_at"] . "%'";

        if (isset($_GET["mgrtech_after_at"]) && $_GET["mgrtech_after_at"] != "")
            $wherclause .= "AND mgrtech_after_at LIKE '" . $_GET["mgrtech_after_at"] . "%'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        if (isset($_GET["sample_no"]) && $_GET["sample_no"] != "")
            $wherclause .= "AND sample_no LIKE '%" . $_GET["sample_no"] . "%'";

        if (isset($_GET["is_calibration_form"]) && $_GET["is_calibration_form"] != "")
            $wherclause .= "AND instrument_acceptance_id IN (SELECT instrument_acceptance_id FROM calibration_forms WHERE  is_deleted = 0 AND (done_by <> '' OR checked_by <> ''))";

        if (isset($_GET["is_calibration_verificated"]) && $_GET["is_calibration_verificated"] != "")
            $wherclause .= "AND instrument_acceptance_id IN (SELECT instrument_acceptance_id FROM calibration_verifications WHERE  is_deleted = 0 AND (calibrated_by <> '' OR calculated_by <> '' OR verified_by <> ''))";

        if (isset($_GET["is_calibration_certificated"]) && $_GET["is_calibration_certificated"] != "")
            $wherclause .= "AND instrument_acceptance_id IN (SELECT instrument_acceptance_id FROM calibration_certificates WHERE  is_deleted = 0 AND issued_by <> '')";

        if (isset($_GET["is_instrument_released"]) && $_GET["is_instrument_released"] != "")
            $wherclause .= "AND instrument_acceptance_id IN (SELECT instrument_acceptance_id FROM instrument_releases WHERE  is_deleted = 0 AND release_by <> '')";

        $instrument_processes = $this->instrument_processes->where($wherclause)->orderBy("id DESC")->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        $numrow = count($this->instrument_processes->where($wherclause)->findAll());

        foreach ($instrument_processes as $instrument_process) {
            $instrument_process_detail[$instrument_process->id]["instrument_acceptance"]              = @$this->instrument_acceptances->where(["is_deleted" => 0, "id" => $instrument_process->instrument_acceptance_id])->findAll()[0];
            $instrument_process_detail[$instrument_process->id]["is_calibration_form"]            = count($this->calibration_forms->where(["is_deleted" => 0,         "instrument_acceptance_id" => $instrument_process->instrument_acceptance_id])->where("(done_by <> '' OR checked_by <> '')")->findAll());
            $instrument_process_detail[$instrument_process->id]["is_calibration_verificated"]     = count($this->calibration_verifications->where(["is_deleted" => 0, "instrument_acceptance_id" => $instrument_process->instrument_acceptance_id])->where("(calibrated_by <> '' OR calculated_by <> '' OR verified_by <> '')")->findAll());
            $instrument_process_detail[$instrument_process->id]["is_calibration_certificated"]    = count($this->calibration_certificates->where(["is_deleted" => 0,  "instrument_acceptance_id" => $instrument_process->instrument_acceptance_id])->where("issued_by <> ''")->findAll());
            $instrument_process_detail[$instrument_process->id]["is_instrument_released"]         = count($this->instrument_releases->where(["is_deleted" => 0,       "instrument_acceptance_id" => $instrument_process->instrument_acceptance_id])->where("release_by <> ''")->findAll());
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["instrument_processes"] = $instrument_processes;
        $data["instrument_process_detail"] = @$instrument_process_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('instrument_processes/v_list');
        echo view('v_footer');
    }

    public function saving_data()
    {
        $_POST["brand"] = $this->item_brands->where(["is_deleted" => 0, "id" => $_POST["brand_id"]])->findAll()[0]->name;
        return [
            "instrument_acceptance_id" => @$_POST["instrument_acceptance_id"],
            "instrument_acceptance_detail_id" => @$_POST["instrument_acceptance_detail_id"],
            "request_review_id" => @$_POST["request_review_id"],
            "sample_no" => @$_POST["sample_no"],
            "brand_id" => @$_POST["brand_id"],
            "brand" => @$_POST["brand"],
            "instrument_type" => @$_POST["instrument_type"],
            "partno" => @$_POST["partno"],
            "serialnumber" => @$_POST["serialnumber"],
            "resolution" => @$_POST["resolution"],
            "accuration" => @$_POST["accuration"],
            "process_start" => @$_POST["process_start"],
            "process_end" => @$_POST["process_end"],
            "is_bcs" => @$_POST["is_bcs"],
            "notes_bcs" => @$_POST["notes_bcs"],
            "is_ipc" => @$_POST["is_ipc"],
            "notes_ipc" => @$_POST["notes_ipc"],
            "is_calibration" => @$_POST["is_calibration"],
            "notes_calibration" => @$_POST["notes_calibration"],
            "is_maintenance" => @$_POST["is_maintenance"],
            "notes_maintenance" => @$_POST["notes_maintenance"],
            "is_contract_service" => @$_POST["is_contract_service"],
            "notes_contract_service" => @$_POST["notes_contract_service"],
        ];
    }

    public function saving_add()
    {
        if (isset($_POST["Save"])) {
            $instrument_process = $this->saving_data() + $this->created_values() + $this->updated_values();
            $this->instrument_processes->save($instrument_process);
            $id = $this->instrument_processes->insertID();
            foreach ($_POST["check_notes"] as $key => $check_notes) {
                $instrument_process_detail = [
                    "instrument_process_id" => $id,
                    "check_notes" => $check_notes,
                    "instrument_condition" => @$_POST["instrument_condition"][$key],
                ];
                $instrument_process_detail = $instrument_process_detail + $this->created_values() + $this->updated_values();
                $this->instrument_process_details->save($instrument_process_detail);
            }

            $this->session->setFlashdata("flash_message", ["success", "Success adding Pengecekan dan Pengerjaan"]);
            echo "<script> window.location='" . base_url() . "/instrument_process/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function saving_edit($id)
    {
        if (isset($_POST["Save"])) {
            $instrument_process = $this->saving_data() + $this->updated_values();
            $this->instrument_processes->update($id, $instrument_process);
            $this->instrument_process_details->where('instrument_process_id', $id)->delete();
            foreach ($_POST["check_notes"] as $key => $check_notes) {
                $instrument_process_detail = [
                    "instrument_process_id" => $id,
                    "check_notes" => $check_notes,
                    "instrument_condition" => @$_POST["instrument_condition"][$key],
                ];
                $instrument_process_detail = $instrument_process_detail + $this->created_values() + $this->updated_values();
                $this->instrument_process_details->save($instrument_process_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success editing Pengecekan dan Pengerjaan"]);
            echo "<script> window.location='" . base_url() . "/instrument_process/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function get_reference_data()
    {
        $data["item_brands"] = $this->item_brands->where("is_deleted", 0)->findAll();
        $data["item_types"] = $this->item_types->where("is_deleted", 0)->findAll();
        $data["item_scopes"] = $this->item_scopes->where("is_deleted", 0)->findAll();
        return $data;
    }

    public function get_saved_data($id)
    {
        $data["instrument_process"] = $this->instrument_processes->where("is_deleted", 0)->find([$id])[0];
        $data["instrument_process_details"] = $this->instrument_process_details->where(["is_deleted" => 0, "instrument_process_id" => $id])->findAll();
        $data["created_user"] = @$this->users->where("email", $data["instrument_process"]->created_by)->where("is_deleted", 0)->findAll()[0];
        $data["tech_before_user"] = @$this->users->where("email", $data["instrument_process"]->tech_before_by)->where("is_deleted", 0)->findAll()[0];
        $data["tech_after_user"] = @$this->users->where("email", $data["instrument_process"]->tech_after_by)->where("is_deleted", 0)->findAll()[0];
        $data["mgrtech_before_user"] = @$this->users->where("email", $data["instrument_process"]->mgrtech_before_by)->where("is_deleted", 0)->findAll()[0];
        $data["mgrtech_after_user"] = @$this->users->where("email", $data["instrument_process"]->mgrtech_after_by)->where("is_deleted", 0)->findAll()[0];
        return $data;
    }

    public function approve($id)
    {
        if (@$_GET["tech_before_approving"] == 1) {
            $this->instrument_processes->update($id, ["tech_before_at" => date("Y-m-d H:i:s"), "tech_before_by" => $this->session->get("username"), "tech_before_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Sebelum Pengecekan dan Pengerjaan"]);
            echo "<script> window.location='" . base_url() . "/instrument_process/view/" . $id . "'; </script>";
            exit();
        }
        if (@$_GET["tech_after_approving"] == 1) {
            $this->instrument_processes->update($id, ["tech_after_at" => date("Y-m-d H:i:s"), "tech_after_by" => $this->session->get("username"), "tech_after_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Sebelum Pengecekan dan Pengerjaan"]);
            echo "<script> window.location='" . base_url() . "/instrument_process/view/" . $id . "'; </script>";
            exit();
        }
        if (@$_GET["mgrtech_before_approving"] == 1) {
            $this->instrument_processes->update($id, ["mgrtech_before_at" => date("Y-m-d H:i:s"), "mgrtech_before_by" => $this->session->get("username"), "mgrtech_before_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Setelah Pengecekan dan Pengerjaan"]);
            echo "<script> window.location='" . base_url() . "/instrument_process/view/" . $id . "'; </script>";
            exit();
        }
        if (@$_GET["mgrtech_after_approving"] == 1) {
            $this->instrument_processes->update($id, ["mgrtech_after_at" => date("Y-m-d H:i:s"), "mgrtech_after_by" => $this->session->get("username"), "mgrtech_after_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Setelah Pengecekan dan Pengerjaan"]);
            echo "<script> window.location='" . base_url() . "/instrument_process/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        $this->saving_add();

        $data["__modulename"] = "Add Pengecekan dan Pengerjaan";
        $data["__mode"] = "add";

        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('instrument_processes/v_edit');
        echo view('v_footer');
        echo view('instrument_processes/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        $this->saving_edit($id);
        $data["__modulename"] = "Edit Pengecekan dan Pengerjaan";
        $data["__mode"] = "edit";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        if ($data["instrument_process"]->tech_after_by != "" || $data["instrument_process"]->mgrtech_after_by != "") {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/instrument_processes');
        }
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('instrument_processes/v_edit');
        echo view('v_footer');
        echo view('instrument_processes/v_js');
    }

    public function view($id)
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);
        $this->approve($id);

        $data["__modulename"] = "Pengecekan dan Pengerjaan";
        $data["_this"] = $this;
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('instrument_processes/v_view');
        echo view('v_footer');
        echo view('instrument_processes/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->instrument_processes->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting Pengecekan dan Pengerjaan"]);
        return redirect()->to(base_url() . '/instrument_processes');
    }

    public function get_instrument_process()
    {
        return json_encode(@$this->instrument_processes->where("is_deleted", 0)->where(["id" => $_GET["instrument_process_id"]])->findAll()[0]);
    }

    public function get_instrument_process_detail($id)
    {
        $return = [];
        $instrument_process_details = $this->instrument_process_details->where("instrument_acceptance_id", $id)->where("is_deleted", 0)->findAll();
        foreach ($instrument_process_details as $key => $instrument_process_detail) {
            $return[$key]["id"] = $instrument_process_detail->id;
            $return[$key]["instrument_process_id"] = $instrument_process_detail->instrument_process_id;
            $return[$key]["check_notes"] = $instrument_process_detail->check_notes;
            $return[$key]["instrument_condition"] = $instrument_process_detail->instrument_condition;
        }
        return json_encode($return);
    }

    public function subwindow()
    {
        $wherclause = "is_deleted = '0'";

        if (isset($_GET["keyword"]) && $_GET["keyword"] != "") {
            $wherclause .= " AND (sample_no LIKE '%" . $_GET["keyword"] . "%' ";
            $wherclause .= "OR brand LIKE '%" . $_GET["keyword"] . "%' ";
            $wherclause .= "OR instrument_type LIKE '%" . $_GET["keyword"] . "%' ";
            $wherclause .= "OR partno LIKE '%" . $_GET["keyword"] . "%' ";
            $wherclause .= "OR serialnumber LIKE '%" . $_GET["keyword"] . "%' ";
            $wherclause .= "OR instrument_acceptance_id IN (SELECT id FROM instrument_acceptances WHERE customer_name LIKE '%" . $_GET["keyword"] . "%') )";
        }
        $data["instrument_processes"]      = $this->instrument_processes->where($wherclause)->findAll(LIMIT_SUBWINDOW, 0);

        foreach ($data["instrument_processes"] as $instrument_process) {
            $instrument_process_details[$instrument_process->id] = @$this->instrument_process_details->where("instrument_process_id", $instrument_process->id)->findAll();
            $instrument_process_detail[$instrument_process->id]["instrument_acceptance"]   = @$this->instrument_acceptances->where(["is_deleted" => 0, "id" => $instrument_process->instrument_acceptance_id])->findAll()[0];
            $instrument_process_detail[$instrument_process->id]["instrument_acceptance_detail"]   = @$this->instrument_acceptance_details->where(["is_deleted" => 0, "id" => $instrument_process->instrument_acceptance_detail_id, "instrument_acceptance_id" => $instrument_process->instrument_acceptance_id])->findAll()[0];
        }
        $data["instrument_process_details"]    = @$instrument_process_details;
        $data["instrument_process_detail"]    = @$instrument_process_detail;

        $data                   = $data + $this->common();
        echo view('instrument_processes/v_subwindow', $data);
    }
}
