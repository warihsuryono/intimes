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

class Request_review extends BaseController
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
        $this->route_name = "request_reviews";
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
        $data["__modulename"] = "Kaji Ulang Kontrak";
        $data["_this"] = $this;
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["adm_approved_at"]) && $_GET["adm_approved_at"] != "")
            $wherclause .= "AND adm_approved_at LIKE '" . $_GET["adm_approved_at"] . "%'";

        if (isset($_GET["tech_approved_at"]) && $_GET["tech_approved_at"] != "")
            $wherclause .= "AND tech_approved_at LIKE '" . $_GET["tech_approved_at"] . "%'";

        if (isset($_GET["customer_name"]) && $_GET["customer_name"] != "")
            $wherclause .= "AND customer_request_1  LIKE '%" . $_GET["customer_name"] . "%'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        if (isset($_GET["sample_no"]) && $_GET["sample_no"] != "")
            $wherclause .= "AND sample_no LIKE '%" . $_GET["sample_no"] . "%'";

        if (isset($_GET["is_instrument_processed"]) && $_GET["is_instrument_processed"] != "")
            $wherclause .= "AND instrument_acceptance_id IN (SELECT instrument_acceptance_id FROM instrument_processes WHERE  is_deleted = 0 AND (tech_before_by <> '' OR mgrtech_before_by <> ''))";

        if (isset($_GET["is_calibration_form"]) && $_GET["is_calibration_form"] != "")
            $wherclause .= "AND instrument_acceptance_id IN (SELECT instrument_acceptance_id FROM calibration_forms WHERE  is_deleted = 0 AND (done_by <> '' OR checked_by <> ''))";

        if (isset($_GET["is_calibration_verificated"]) && $_GET["is_calibration_verificated"] != "")
            $wherclause .= "AND instrument_acceptance_id IN (SELECT instrument_acceptance_id FROM calibration_verifications WHERE  is_deleted = 0 AND (calibrated_by <> '' OR calculated_by <> '' OR verified_by <> ''))";

        if (isset($_GET["is_calibration_certificated"]) && $_GET["is_calibration_certificated"] != "")
            $wherclause .= "AND instrument_acceptance_id IN (SELECT instrument_acceptance_id FROM calibration_certificates WHERE  is_deleted = 0 AND issued_by <> '')";

        if (isset($_GET["is_instrument_released"]) && $_GET["is_instrument_released"] != "")
            $wherclause .= "AND instrument_acceptance_id IN (SELECT instrument_acceptance_id FROM instrument_releases WHERE  is_deleted = 0 AND release_by <> '')";

        $request_reviews = $this->request_reviews->where($wherclause)->orderBy("id DESC")->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        $numrow = count($this->request_reviews->where($wherclause)->findAll());

        foreach ($request_reviews as $request_review) {
            $request_review_detail[$request_review->id]["instrument_acceptance"]   = @$this->instrument_acceptances->where(["is_deleted" => 0, "id" => $request_review->instrument_acceptance_id])->findAll()[0];
            $request_review_detail[$request_review->id]["instrument_acceptance_detail"]   = @$this->instrument_acceptance_details->where(["is_deleted" => 0, "id" => $request_review->instrument_acceptance_detail_id, "instrument_acceptance_id" => $request_review->instrument_acceptance_id])->findAll()[0];
            $request_review_detail[$request_review->id]["is_instrument_processed"]        = count($this->instrument_processes->where(["is_deleted" => 0,      "instrument_acceptance_id" => $request_review->instrument_acceptance_id])->where("(tech_before_by <> '' OR mgrtech_before_by <> '')")->findAll());
            $request_review_detail[$request_review->id]["is_calibration_form"]            = count($this->calibration_forms->where(["is_deleted" => 0,         "instrument_acceptance_id" => $request_review->instrument_acceptance_id])->where("(done_by <> '' OR checked_by <> '')")->findAll());
            $request_review_detail[$request_review->id]["is_calibration_verificated"]     = count($this->calibration_verifications->where(["is_deleted" => 0, "instrument_acceptance_id" => $request_review->instrument_acceptance_id])->where("(calibrated_by <> '' OR calculated_by <> '' OR verified_by <> '')")->findAll());
            $request_review_detail[$request_review->id]["is_calibration_certificated"]    = count($this->calibration_certificates->where(["is_deleted" => 0,  "instrument_acceptance_id" => $request_review->instrument_acceptance_id])->where("issued_by <> ''")->findAll());
            $request_review_detail[$request_review->id]["is_instrument_released"]         = count($this->instrument_releases->where(["is_deleted" => 0,       "instrument_acceptance_id" => $request_review->instrument_acceptance_id])->where("release_by <> ''")->findAll());
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["request_reviews"] = $request_reviews;
        $data["request_review_detail"] = @$request_review_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('request_reviews/v_list');
        echo view('v_footer');
    }

    public function saving_data()
    {
        return [
            "instrument_acceptance_id" => @$_POST["instrument_acceptance_id"],
            "instrument_acceptance_detail_id" => @$_POST["instrument_acceptance_detail_id"],
            "sample_no" => @$_POST["sample_no"],
            "customer_request_1" => @$_POST["customer_request_1"],
            "customer_request_1_is" => @$_POST["customer_request_1_is"],
            "customer_request_2" => @$_POST["customer_request_2"],
            "customer_request_2_is" => @$_POST["customer_request_2_is"],
            "customer_request_3" => @$_POST["customer_request_3"],
            "customer_request_3_is" => @$_POST["customer_request_3_is"],
            "notes" => @$_POST["notes"],
            "summary_id" => @$_POST["summary_id"],
            "summary" => @$_POST["summary"],
        ];
    }

    public function saving_add()
    {
        if (isset($_POST["Save"])) {
            $request_review = $this->saving_data() + $this->created_values() + $this->updated_values();
            $this->request_reviews->save($request_review);
            $id = $this->request_reviews->insertID();
            foreach ($_POST["item_type_id"] as $key => $item_type_id) {
                $request_review_detail = [
                    "request_review_id" => $id,
                    "instrument_acceptance_id" => @$_POST["instrument_acceptance_id"],
                    "item_type_id" => $item_type_id,
                    "scope_id" => @$_POST["scope_id"][$key],
                    "unit_id" => @$_POST["unit_id"][$key],
                    "method" => @$_POST["method"][$key],
                    "is_instrument" => @$_POST["is_instrument"][$key],
                    "is_personel" => @$_POST["is_personel"][$key],
                    "is_acomodation" => @$_POST["is_acomodation"][$key],
                    "is_gas" => @$_POST["is_gas"][$key],
                ];
                $request_review_detail = $request_review_detail + $this->created_values() + $this->updated_values();
                $this->request_review_details->save($request_review_detail);
            }

            $this->session->setFlashdata("flash_message", ["success", "Success adding Kaji Ulang Kontrak"]);
            echo "<script> window.location='" . base_url() . "/request_review/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function saving_edit($id)
    {
        if (isset($_POST["Save"])) {
            $request_review = $this->saving_data() + $this->updated_values();
            $this->request_reviews->update($id, $request_review);
            $this->request_review_details->where('request_review_id', $id)->delete();
            foreach ($_POST["item_type_id"] as $key => $item_type_id) {
                $request_review_detail = [
                    "request_review_id" => $id,
                    "instrument_acceptance_id" => @$_POST["instrument_acceptance_id"],
                    "item_type_id" => $item_type_id,
                    "scope_id" => @$_POST["scope_id"][$key],
                    "unit_id" => @$_POST["unit_id"][$key],
                    "method" => @$_POST["method"][$key],
                    "is_instrument" => @$_POST["is_instrument"][$key],
                    "is_personel" => @$_POST["is_personel"][$key],
                    "is_acomodation" => @$_POST["is_acomodation"][$key],
                    "is_gas" => @$_POST["is_gas"][$key],
                ];
                $request_review_detail = $request_review_detail + $this->created_values() + $this->updated_values();
                $this->request_review_details->save($request_review_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success editing Kaji Ulang Kontrak"]);
            echo "<script> window.location='" . base_url() . "/request_review/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function get_reference_data()
    {
        $data["item_types"] = $this->item_types->where("is_deleted", 0)->findAll();
        $data["item_scopes"] = $this->item_scopes->where("is_deleted", 0)->findAll();
        return $data;
    }

    public function get_saved_data($id)
    {
        $data["request_review"] = $this->request_reviews->where("is_deleted", 0)->find([$id])[0];
        $data["request_review_details"] = $this->request_review_details->where(["is_deleted" => 0, "request_review_id" => $id])->findAll();
        $data["created_user"] = @$this->users->where("email", $data["request_review"]->created_by)->where("is_deleted", 0)->findAll()[0];
        $data["adm_approved_user"] = @$this->users->where("email", $data["request_review"]->adm_approved_by)->where("is_deleted", 0)->findAll()[0];
        $data["tech_approved_user"] = @$this->users->where("email", $data["request_review"]->tech_approved_by)->where("is_deleted", 0)->findAll()[0];
        return $data;
    }

    public function approve($id)
    {
        if (@$_GET["adm_approving"] == 1) {
            $this->request_reviews->update($id, ["adm_approved_at" => date("Y-m-d H:i:s"), "adm_approved_by" => $this->session->get("username"), "adm_approved_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Kaji Ulang Kontrak"]);
            echo "<script> window.location='" . base_url() . "/request_review/view/" . $id . "'; </script>";
            exit();
        }
        if (@$_GET["tech_approving"] == 1) {
            $this->request_reviews->update($id, ["tech_approved_at" => date("Y-m-d H:i:s"), "tech_approved_by" => $this->session->get("username"), "tech_approved_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Kaji Ulang Kontrak"]);
            echo "<script> window.location='" . base_url() . "/request_review/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        $this->saving_add();

        $data["__modulename"] = "Add Kaji Ulang Kontrak";
        $data["__mode"] = "add";

        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('request_reviews/v_edit');
        echo view('v_footer');
        echo view('request_reviews/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        $this->saving_edit($id);
        $data["__modulename"] = "Edit Kaji Ulang Kontrak";
        $data["__mode"] = "edit";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        if ($data["request_review"]->adm_approved_by != "" || $data["request_review"]->tech_approved_by != "") {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/request_reviews');
        }
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('request_reviews/v_edit');
        echo view('v_footer');
        echo view('request_reviews/v_js');
    }

    public function view($id)
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);
        $this->approve($id);

        $data["__modulename"] = "Kaji Ulang Kontrak";
        $data["_this"] = $this;
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('request_reviews/v_view');
        echo view('v_footer');
        echo view('request_reviews/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->request_reviews->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting Kaji Ulang Kontrak"]);
        return redirect()->to(base_url() . '/request_reviews');
    }

    public function get_request_review()
    {
        return json_encode(@$this->request_reviews->where("is_deleted", 0)->where(["id" => $_GET["request_review_id"]])->findAll()[0]);
    }

    public function get_request_review_detail($id)
    {
        $return = [];
        $request_review_details = $this->request_review_details->where("instrument_acceptance_id", $id)->where("is_deleted", 0)->findAll();
        foreach ($request_review_details as $key => $request_review_detail) {
            $return[$key]["id"] = $request_review_detail->id;
            $return[$key]["instrument_acceptance_id"] = $request_review_detail->instrument_acceptance_id;
            $return[$key]["request_review_id"] = $request_review_detail->request_review_id;
            $return[$key]["item_type_id"] = $request_review_detail->item_type_id;
            $return[$key]["item_type"] = @$this->item_types->where(["is_deleted" => 0, "id" => $request_review_detail->item_type_id])->findAll()[0]->name;
            $return[$key]["scope_id"] = $request_review_detail->scope_id;
            $return[$key]["scope"] = @$this->item_scopes->where(["is_deleted" => 0, "id" => $request_review_detail->scope_id])->findAll()[0]->name;
            $return[$key]["unit_id"] = $request_review_detail->unit_id;
            $return[$key]["unit"] = @$this->units->where(["is_deleted" => 0, "id" => $request_review_detail->unit_id])->findAll()[0]->name;
            $return[$key]["method"] = $request_review_detail->method;
            $return[$key]["is_instrument"] = $request_review_detail->is_instrument;
            $return[$key]["is_personel"] = $request_review_detail->is_personel;
            $return[$key]["is_acomodation"] = $request_review_detail->is_acomodation;
            $return[$key]["is_gas"] = $request_review_detail->is_gas;
        }
        return json_encode($return);
    }

    public function subwindow()
    {
        $wherclause = "is_deleted = '0'";

        if (isset($_GET["keyword"]) && $_GET["keyword"] != "") {
            $wherclause .= " AND (customer_request_1 LIKE '%" . $_GET["keyword"] . "%' ";
            $wherclause .= "OR sample_no LIKE '%" . $_GET["keyword"] . "%' ";
            $wherclause .= "OR notes LIKE '%" . $_GET["keyword"] . "%' )";
        }
        $data["request_reviews"]      = $this->request_reviews->where($wherclause)->findAll(LIMIT_SUBWINDOW, 0);

        foreach ($data["request_reviews"] as $request_review) {
            $request_review_details[$request_review->id] = @$this->request_review_details->where("request_review_id", $request_review->id)->findAll();
            $request_review_detail[$request_review->id]["instrument_acceptance"]   = @$this->instrument_acceptances->where(["is_deleted" => 0, "id" => $request_review->instrument_acceptance_id])->findAll()[0];
            $request_review_detail[$request_review->id]["instrument_acceptance_detail"]   = @$this->instrument_acceptance_details->where(["is_deleted" => 0, "id" => $request_review->instrument_acceptance_detail_id, "instrument_acceptance_id" => $request_review->instrument_acceptance_id])->findAll()[0];
        }
        $data["request_review_details"]    = @$request_review_details;
        $data["request_review_detail"]    = @$request_review_detail;

        $data                   = $data + $this->common();
        echo view('request_reviews/v_subwindow', $data);
    }
}
