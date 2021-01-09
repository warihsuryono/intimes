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

class Calibration_form extends BaseController
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
        $this->route_name = "calibration_forms";
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
        $data["__modulename"] = "Laporan Sementara";
        $data["_this"] = $this;
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["done_at"]) && $_GET["done_at"] != "")
            $wherclause .= "AND done_at LIKE '" . $_GET["done_at"] . "%'";

        if (isset($_GET["checked_at"]) && $_GET["checked_at"] != "")
            $wherclause .= "AND checked_at LIKE '" . $_GET["checked_at"] . "%'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        if (isset($_GET["sample_no"]) && $_GET["sample_no"] != "")
            $wherclause .= "AND sample_no LIKE '%" . $_GET["sample_no"] . "%'";

        if (isset($_GET["is_calibration_verificated"]) && $_GET["is_calibration_verificated"] != "")
            $wherclause .= "AND instrument_acceptance_id IN (SELECT instrument_acceptance_id FROM calibration_verifications WHERE  is_deleted = 0 AND (calibrated_by <> '' OR calculated_by <> '' OR verified_by <> ''))";

        if (isset($_GET["is_calibration_certificated"]) && $_GET["is_calibration_certificated"] != "")
            $wherclause .= "AND instrument_acceptance_id IN (SELECT instrument_acceptance_id FROM calibration_certificates WHERE  is_deleted = 0 AND issued_by <> '')";

        if (isset($_GET["is_instrument_released"]) && $_GET["is_instrument_released"] != "")
            $wherclause .= "AND instrument_acceptance_id IN (SELECT instrument_acceptance_id FROM instrument_releases WHERE  is_deleted = 0 AND release_by <> '')";

        $calibration_forms = $this->calibration_forms->where($wherclause)->orderBy("id DESC")->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        $numrow = count($this->calibration_forms->where($wherclause)->findAll());

        foreach ($calibration_forms as $calibration_form) {
            $calibration_form_detail[$calibration_form->id]["is_calibration_verificated"]     = count($this->calibration_verifications->where(["is_deleted" => 0, "instrument_acceptance_id" => $calibration_form->instrument_acceptance_id])->where("(calibrated_by <> '' OR calculated_by <> '' OR verified_by <> '')")->findAll());
            $calibration_form_detail[$calibration_form->id]["is_calibration_certificated"]    = count($this->calibration_certificates->where(["is_deleted" => 0,  "instrument_acceptance_id" => $calibration_form->instrument_acceptance_id])->where("issued_by <> ''")->findAll());
            $calibration_form_detail[$calibration_form->id]["is_instrument_released"]         = count($this->instrument_releases->where(["is_deleted" => 0,       "instrument_acceptance_id" => $calibration_form->instrument_acceptance_id])->where("release_by <> ''")->findAll());
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["calibration_forms"] = $calibration_forms;
        $data["calibration_form_detail"] = @$calibration_form_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('calibration_forms/v_list');
        echo view('v_footer');
    }

    public function saving_data()
    {
        $instrument_acceptance_id = @$this->instrument_processes->where(["is_deleted" => 0, "id" => $_POST["instrument_process_id"]])->findAll()[0]->instrument_acceptance_id;
        $_POST["brand"] = $this->item_brands->where(["is_deleted" => 0, "id" => $_POST["brand_id"]])->findAll()[0]->name;
        $item_type_ids = "";
        $scope_ids = "";
        foreach ($_POST["item_type_id"] as $key => $item_type_id) {
            $item_type_ids .= "|" . $item_type_id . "|";
            $scope_ids .= "|" . $_POST["scope_id"][$key] . "|";
        }
        return [
            "instrument_acceptance_id" => @$instrument_acceptance_id,
            "instrument_process_id" => @$_POST["instrument_process_id"],
            "sample_no" => @$_POST["sample_no"],
            "brand_id" => @$_POST["brand_id"],
            "brand" => @$_POST["brand"],
            "instrument_type" => @$_POST["instrument_type"],
            "partno" => @$_POST["partno"],
            "serialnumber" => @$_POST["serialnumber"],
            "calibration_at" => @$_POST["calibration_at"],
            "temperature" => @$_POST["temperature"],
            "humidity" => @$_POST["humidity"],
            "item_type_ids" => $item_type_ids,
            "scope_ids" => $scope_ids,
        ];
    }

    public function saving_add()
    {
        if (isset($_POST["Save"])) {
            $calibration_form = $this->saving_data() + $this->created_values() + $this->updated_values();
            $this->calibration_forms->save($calibration_form);
            $id = $this->calibration_forms->insertID();
            foreach ($_POST["item_type_id"] as $key => $item_type_id) {
                if ($item_type_id > 0) {
                    $data_array = "";
                    if (isset($_POST["data"][$key])) {
                        foreach ($_POST["data"][$key] as $data) {
                            $data_array .= $data . ";";
                        }
                    }
                    $calibration_form_detail = [
                        "calibration_form_id" => $id,
                        "item_type_id" => $item_type_id,
                        "unit_id" => @$_POST["unit_id"][$key],
                        "scope_id" => @$_POST["scope_id_detail"][$key],
                        "data_array" => $data_array,
                    ];
                    $calibration_form_detail = $calibration_form_detail + $this->created_values() + $this->updated_values();
                    $this->calibration_form_details->save($calibration_form_detail);
                }
            }

            $this->session->setFlashdata("flash_message", ["success", "Success adding Laporan Sementara"]);
            echo "<script> window.location='" . base_url() . "/calibration_form/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function saving_edit($id)
    {
        if (isset($_POST["Save"])) {
            $calibration_form = $this->saving_data() + $this->updated_values();
            $this->calibration_forms->update($id, $calibration_form);
            $this->calibration_form_details->where('calibration_form_id', $id)->delete();
            foreach ($_POST["item_type_id"] as $key => $item_type_id) {
                if ($item_type_id > 0) {
                    $data_array = "";
                    if (isset($_POST["data"][$key])) {
                        foreach ($_POST["data"][$key] as $data) {
                            $data_array .= $data . ";";
                        }
                    }
                    $calibration_form_detail = [
                        "calibration_form_id" => $id,
                        "item_type_id" => $item_type_id,
                        "unit_id" => @$_POST["unit_id"][$key],
                        "scope_id" => @$_POST["scope_id_detail"][$key],
                        "data_array" => $data_array,
                    ];
                    $calibration_form_detail = $calibration_form_detail + $this->created_values() + $this->updated_values();
                    $this->calibration_form_details->save($calibration_form_detail);
                }
            }
            $this->session->setFlashdata("flash_message", ["success", "Success editing Laporan Sementara"]);
            echo "<script> window.location='" . base_url() . "/calibration_form/view/" . $id . "'; </script>";
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
        $data["calibration_form"] = $this->calibration_forms->where("is_deleted", 0)->find([$id])[0];
        $data["calibration_form_details"] = $this->calibration_form_details->where(["is_deleted" => 0, "calibration_form_id" => $id])->findAll();
        $data["created_user"] = @$this->users->where("email", $data["calibration_form"]->created_by)->where("is_deleted", 0)->findAll()[0];
        $data["done_user"] = @$this->users->where("email", $data["calibration_form"]->done_by)->where("is_deleted", 0)->findAll()[0];
        $data["checked_user"] = @$this->users->where("email", $data["calibration_form"]->checked_by)->where("is_deleted", 0)->findAll()[0];
        return $data;
    }

    public function approve($id)
    {
        if (@$_GET["done_approving"] == 1) {
            $this->calibration_forms->update($id, ["done_at" => date("Y-m-d H:i:s"), "done_by" => $this->session->get("username"), "done_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Laporan Sementara"]);
            echo "<script> window.location='" . base_url() . "/calibration_form/view/" . $id . "'; </script>";
            exit();
        }
        if (@$_GET["checked_approving"] == 1) {
            $this->calibration_forms->update($id, ["checked_at" => date("Y-m-d H:i:s"), "checked_by" => $this->session->get("username"), "checked_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Laporan Sementara"]);
            echo "<script> window.location='" . base_url() . "/calibration_form/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        $instrument_process = @$this->instrument_processes->where(["is_deleted" => 0, "id" => @$_GET["instrument_process_id"]])->findAll()[0];
        if (@$instrument_process->id > 0) {
            $instrument_process = @$this->instrument_processes->where(["is_deleted" => 0, "id" => $_GET["instrument_process_id"]])->findAll()[0];
            $request_review_id = $instrument_process->request_review_id;
            $request_review = @$this->request_reviews->where(["is_deleted" => 0, "id" => $request_review_id])->findAll()[0];
            $request_review_details = @$this->request_review_details->where(["is_deleted" => 0, "request_review_id" => $request_review_id])->findAll();
        } else {
            $this->session->setFlashdata("flash_message", ["error", "Dokumen pengecekan dan pengerjaan alat tidak dikenal"]);
            echo "<script> window.location='" . base_url() . "/calibration_forms'; </script>";
            exit();
        }


        $this->saving_add();

        $data["__modulename"] = "Add Laporan Sementara";
        $data["__mode"] = "add";
        $data["request_review"] = $request_review;
        $data["request_review_details"] = $request_review_details;

        $data["calibration_form"] = (object) [
            "instrument_process_id" => $_GET["instrument_process_id"],
            "sample_no" => $request_review->sample_no,
            "brand_id" => $instrument_process->brand_id,
            "instrument_type" => $instrument_process->instrument_type,
            "partno" => $instrument_process->partno,
            "serialnumber" => $instrument_process->serialnumber,
            "calibration_at" => date("Y-m-d"),
        ];
        foreach ($request_review_details as $key => $request_review_detail) {
            $item_scope = $this->item_scopes->where(["is_deleted" => 0, "id" => $request_review_detail->scope_id])->findAll()[0];
            $data["calibration_form_details"][$key] = (object) [
                "item_type_id" => $request_review_detail->item_type_id,
                "scope_id" => $item_scope->id,
                "unit_id" => $item_scope->unit_id,
                "item_type" => $this->item_types->where(["is_deleted" => 0, "id" => $request_review_detail->item_type_id])->findAll()[0]->name,
                "unit" => $this->units->where(["is_deleted" => 0, "id" => $item_scope->unit_id])->findAll()[0]->name,
                "item_scope" => $item_scope,
            ];
        }

        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('calibration_forms/v_edit');
        echo view('v_footer');
        echo view('calibration_forms/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        $this->saving_edit($id);
        $data["__modulename"] = "Edit Laporan Sementara";
        $data["__mode"] = "edit";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);

        if ($data["calibration_form"]->done_by != "" || $data["calibration_form"]->checked_by != "") {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/calibration_forms');
        }

        foreach ($data["calibration_form_details"] as $key => $calibration_form_details) {
            $item_scope = $this->item_scopes->where(["is_deleted" => 0, "id" => $calibration_form_details->scope_id])->findAll()[0];
            $data["calibration_form_details"][$key]->item_type = $this->item_types->where(["is_deleted" => 0, "id" => $calibration_form_details->item_type_id])->findAll()[0]->name;
            $data["calibration_form_details"][$key]->unit = $this->units->where(["is_deleted" => 0, "id" => $item_scope->unit_id])->findAll()[0]->name;
            $data["calibration_form_details"][$key]->item_scope = $item_scope;
        }

        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('calibration_forms/v_edit');
        echo view('v_footer');
        echo view('calibration_forms/v_js');
    }

    public function view($id)
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);
        $this->approve($id);

        $data["__modulename"] = "Laporan Sementara";
        $data["_this"] = $this;
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('calibration_forms/v_view');
        echo view('v_footer');
        echo view('calibration_forms/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->calibration_forms->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting Laporan Sementara"]);
        return redirect()->to(base_url() . '/calibration_forms');
    }

    public function get_calibration_form()
    {
        return json_encode(@$this->calibration_forms->where("is_deleted", 0)->where(["id" => $_GET["calibration_form_id"]])->findAll()[0]);
    }

    public function get_calibration_form_detail($id)
    {
        $return = [];
        $calibration_form_details = $this->calibration_form_details->where("calibration_form_id", $id)->where("is_deleted", 0)->findAll();
        foreach ($calibration_form_details as $key => $calibration_form_detail) {
            $return[$key]["id"] = $calibration_form_detail->id;
            $return[$key]["calibration_form_id"] = $calibration_form_detail->calibration_form_id;
            $return[$key]["item_type_id"] = $calibration_form_detail->item_type_id;
            $return[$key]["item_type"] = @$this->item_types->where(["is_deleted" => 0, "id" => $calibration_form_detail->item_type_id])->findAll()[0]->name;
            $return[$key]["unit_id"] = $calibration_form_detail->unit_id;
            $return[$key]["unit"] = @$this->units->where(["is_deleted" => 0, "id" => $calibration_form_detail->unit_id])->findAll()[0]->name;
            $return[$key]["scope_id"] = $calibration_form_detail->scope_id;
            $return[$key]["scope"] = @$this->item_scopes->where(["is_deleted" => 0, "id" => $calibration_form_detail->scope_id])->findAll()[0]->name;
            $return[$key]["data_array"] = $calibration_form_detail->data_array;
        }
        return json_encode($return);
    }
}
