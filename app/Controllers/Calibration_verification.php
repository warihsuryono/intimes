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

class Calibration_verification extends BaseController
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
        $this->route_name = "calibration_verifications";
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
        $data["__modulename"] = "Verifikasi Kalibrasi";
        $data["_this"] = $this;
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["calibrated_at"]) && $_GET["calibrated_at"] != "")
            $wherclause .= "AND calibrated_at LIKE '" . $_GET["calibrated_at"] . "%'";

        if (isset($_GET["calculated_at"]) && $_GET["calculated_at"] != "")
            $wherclause .= "AND calculated_at LIKE '" . $_GET["calculated_at"] . "%'";

        if (isset($_GET["verified_at"]) && $_GET["verified_at"] != "")
            $wherclause .= "AND verified_at LIKE '" . $_GET["verified_at"] . "%'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        if (isset($_GET["is_calibration_certificated"]) && $_GET["is_calibration_certificated"] != "")
            $wherclause .= "AND instrument_acceptance_id IN (SELECT instrument_acceptance_id FROM calibration_certificates WHERE  is_deleted = 0 AND issued_by <> '')";

        if (isset($_GET["is_instrument_released"]) && $_GET["is_instrument_released"] != "")
            $wherclause .= "AND instrument_acceptance_id IN (SELECT instrument_acceptance_id FROM instrument_releases WHERE  is_deleted = 0 AND release_by <> '')";

        $calibration_verifications = $this->calibration_verifications->where($wherclause)->orderBy("id DESC")->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        $numrow = count($this->calibration_verifications->where($wherclause)->findAll());

        foreach ($calibration_verifications as $calibration_verification) {
            $calibration_verification_detail[$calibration_verification->id]["calibration_form"] = $this->calibration_forms->where(["is_deleted" => 0, "id" => $calibration_verification->calibration_form_id])->findAll()[0];
            $calibration_verification_detail[$calibration_verification->id]["instrument_acceptance"] = @$this->instrument_acceptances->where(["is_deleted" => 0, "id" => $calibration_verification->instrument_acceptance_id])->findAll()[0];
            $calibration_verification_detail[$calibration_verification->id]["is_calibration_certificated"]    = count($this->calibration_certificates->where(["is_deleted" => 0,  "instrument_acceptance_id" => $calibration_verification->instrument_acceptance_id])->where("issued_by <> ''")->findAll());
            $calibration_verification_detail[$calibration_verification->id]["is_instrument_released"]         = count($this->instrument_releases->where(["is_deleted" => 0,       "instrument_acceptance_id" => $calibration_verification->instrument_acceptance_id])->where("release_by <> ''")->findAll());
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["calibration_verifications"] = $calibration_verifications;
        $data["calibration_verification_detail"] = @$calibration_verification_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('calibration_verifications/v_list');
        echo view('v_footer');
    }

    public function saving_data()
    {
        $instrument_acceptance_id = @$this->calibration_forms->where(["is_deleted" => 0, "id" => $_POST["calibration_form_id"]])->findAll()[0]->instrument_acceptance_id;
        $_POST["brand"] = $this->item_brands->where(["is_deleted" => 0, "id" => $_POST["brand_id"]])->findAll()[0]->name;
        return [
            "instrument_acceptance_id" => $instrument_acceptance_id,
            "calibration_form_id" => @$_POST["calibration_form_id"],
            "sample_no" => @$_POST["sample_no"],
            "brand_id" => @$_POST["brand_id"],
            "brand" => @$_POST["brand"],
            "instrument_type" => @$_POST["instrument_type"],
            "partno" => @$_POST["partno"],
            "serialnumber" => @$_POST["serialnumber"],
            "notes" => @$_POST["notes"],
        ];
    }

    public function saving_add()
    {
        if (isset($_POST["Save"])) {
            $calibration_verification = $this->saving_data() + $this->created_values() + $this->updated_values();
            $this->calibration_verifications->save($calibration_verification);
            $id = $this->calibration_verifications->insertID();
            $this->session->setFlashdata("flash_message", ["success", "Success adding Verifikasi Kalibrasi"]);
            echo "<script> window.location='" . base_url() . "/calibration_verification/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function saving_edit($id)
    {
        if (isset($_POST["Save"])) {
            $calibration_verification = $this->saving_data() + $this->updated_values();
            $this->calibration_verifications->update($id, $calibration_verification);
            $this->session->setFlashdata("flash_message", ["success", "Success editing Verifikasi Kalibrasi"]);
            echo "<script> window.location='" . base_url() . "/calibration_verification/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function get_reference_data()
    {
        $data["item_types"] = $this->item_types->where("is_deleted", 0)->findAll();
        $data["item_scopes"] = $this->item_scopes->where("is_deleted", 0)->findAll();
        $data["item_brands"] = $this->item_brands->where("is_deleted", 0)->findAll();
        return $data;
    }

    public function get_saved_data($id)
    {
        $data["calibration_verification"] = $this->calibration_verifications->where("is_deleted", 0)->find([$id])[0];
        $data["created_user"] = @$this->users->where("email", $data["calibration_verification"]->created_by)->where("is_deleted", 0)->findAll()[0];
        $data["calibrated_user"] = @$this->users->where("email", $data["calibration_verification"]->calibrated_by)->where("is_deleted", 0)->findAll()[0];
        $data["calculated_user"] = @$this->users->where("email", $data["calibration_verification"]->calculated_by)->where("is_deleted", 0)->findAll()[0];
        $data["verified_user"] = @$this->users->where("email", $data["calibration_verification"]->verified_by)->where("is_deleted", 0)->findAll()[0];
        return $data;
    }

    public function approve($id)
    {
        if (@$_GET["calibrated_approving"] == 1) {
            $this->calibration_verifications->update($id, ["calibrated_at" => date("Y-m-d H:i:s"), "calibrated_by" => $this->session->get("username"), "calibrated_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Verifikasi Kalibrasi"]);
            echo "<script> window.location='" . base_url() . "/calibration_verification/view/" . $id . "'; </script>";
            exit();
        }
        if (@$_GET["calculated_approving"] == 1) {
            $this->calibration_verifications->update($id, ["calculated_at" => date("Y-m-d H:i:s"), "calculated_by" => $this->session->get("username"), "calculated_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Verifikasi Kalibrasi"]);
            echo "<script> window.location='" . base_url() . "/calibration_verification/view/" . $id . "'; </script>";
            exit();
        }
        if (@$_GET["verified_approving"] == 1) {
            $this->calibration_verifications->update($id, ["verified_at" => date("Y-m-d H:i:s"), "verified_by" => $this->session->get("username"), "verified_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Verifikasi Kalibrasi"]);
            echo "<script> window.location='" . base_url() . "/calibration_verification/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        $calibration_form = @$this->calibration_forms->where(["is_deleted" => 0, "id" => @$_GET["calibration_form_id"]])->findAll()[0];
        if (@$calibration_form->id > 0) {
            $calibration_form = @$this->calibration_forms->where(["is_deleted" => 0, "id" => $_GET["calibration_form_id"]])->findAll()[0];
        } else {
            $this->session->setFlashdata("flash_message", ["error", "Dokumen pengecekan dan pengerjaan alat tidak dikenal"]);
            echo "<script> window.location='" . base_url() . "/calibration_verifications'; </script>";
            exit();
        }

        $this->saving_add();

        $data["__modulename"] = "Add Verifikasi Kalibrasi";
        $data["__mode"] = "add";

        $data["calibration_verification"] = (object) [
            "calibration_form_id" => $_GET["calibration_form_id"],
            "sample_no" => $calibration_form->sample_no,
            "brand_id" => $calibration_form->brand_id,
            "instrument_type" => $calibration_form->instrument_type,
            "serialnumber" => $calibration_form->serialnumber,
            "notes" => "*pemasukan data kalibrasi sudah sesuai,\n*pemasukan nilai uncertainty yang berpengaruh sudah sesuai,\n*satuan uncertainty cocok,\n*hasil perhitungan sudah sesuai.",
        ];

        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('calibration_verifications/v_edit');
        echo view('v_footer');
        echo view('calibration_verifications/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        $this->saving_edit($id);
        $data["__modulename"] = "Edit Verifikasi Kalibrasi";
        $data["__mode"] = "edit";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        if ($data["calibration_verification"]->calibrated_by != "" || $data["calibration_verification"]->calculated_by != "" || $data["calibration_verification"]->verified_by != "") {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/calibration_verifications');
        }
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('calibration_verifications/v_edit');
        echo view('v_footer');
        echo view('calibration_verifications/v_js');
    }

    public function view($id)
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);
        $this->approve($id);

        $data["__modulename"] = "Verifikasi Kalibrasi";
        $data["_this"] = $this;
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('calibration_verifications/v_view');
        echo view('v_footer');
        echo view('calibration_verifications/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->calibration_verifications->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting Verifikasi Kalibrasi"]);
        return redirect()->to(base_url() . '/calibration_verifications');
    }

    public function get_calibration_verification()
    {
        return json_encode(@$this->calibration_verifications->where("is_deleted", 0)->where(["id" => $_GET["calibration_verification_id"]])->findAll()[0]);
    }
}
