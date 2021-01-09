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

class Instrument_acceptance extends BaseController
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
        $this->route_name = "instrument_acceptances";
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
        $data["__modulename"] = "Penerimaan Alat";
        $data["_this"] = $this;
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["accepted_at"]) && $_GET["accepted_at"] != "")
            $wherclause .= "AND accepted_at LIKE '" . $_GET["accepted_at"] . "%'";

        if (isset($_GET["customer_name"]) && $_GET["customer_name"] != "")
            $wherclause .= "AND customer_name  LIKE '%" . $_GET["customer_name"] . "%'";

        if (isset($_GET["instrument_name"]) && $_GET["instrument_name"] != "")
            $wherclause .= "AND id IN (SELECT instrument_acceptance_id FROM instrument_acceptance_details WHERE is_deleted = 0 AND brand LIKE '%" . $_GET["instrument_name"] . "%' OR instrument_type LIKE '%" . $_GET["instrument_name"] . "%' OR partno LIKE '%" . $_GET["instrument_name"] . "%' OR serialnumber LIKE '%" . $_GET["instrument_name"] . "%')";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        if (isset($_GET["is_request_reviewed"]) && $_GET["is_request_reviewed"] != "")
            $wherclause .= "AND id IN (SELECT instrument_acceptance_id FROM request_reviews WHERE is_deleted = 0 AND (adm_approved_by <> '' OR tech_approved_by <> ''))";

        if (isset($_GET["is_instrument_processed"]) && $_GET["is_instrument_processed"] != "")
            $wherclause .= "AND id IN (SELECT instrument_acceptance_id FROM instrument_processes WHERE  is_deleted = 0 AND (tech_before_by <> '' OR mgrtech_before_by <> ''))";

        if (isset($_GET["is_calibration_form"]) && $_GET["is_calibration_form"] != "")
            $wherclause .= "AND id IN (SELECT instrument_acceptance_id FROM calibration_forms WHERE  is_deleted = 0 AND (done_by <> '' OR checked_by <> ''))";

        if (isset($_GET["is_calibration_verificated"]) && $_GET["is_calibration_verificated"] != "")
            $wherclause .= "AND id IN (SELECT instrument_acceptance_id FROM calibration_verifications WHERE  is_deleted = 0 AND (calibrated_by <> '' OR calculated_by <> '' OR verified_by <> ''))";

        if (isset($_GET["is_calibration_certificated"]) && $_GET["is_calibration_certificated"] != "")
            $wherclause .= "AND id IN (SELECT instrument_acceptance_id FROM calibration_certificates WHERE  is_deleted = 0 AND issued_by <> '')";

        if (isset($_GET["is_instrument_released"]) && $_GET["is_instrument_released"] != "")
            $wherclause .= "AND id IN (SELECT instrument_acceptance_id FROM instrument_releases WHERE  is_deleted = 0 AND release_by <> '')";

        $instrument_acceptances = $this->instrument_acceptances->where($wherclause)->orderBy("id DESC")->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        $numrow = count($this->instrument_acceptances->where($wherclause)->findAll());

        foreach ($instrument_acceptances as $instrument_acceptance) {
            $instruments = "";
            $instrument_acceptance_details =  $this->instrument_acceptance_details->where(["is_deleted" => 0, "instrument_acceptance_id" => $instrument_acceptance->id])->findAll();
            foreach ($instrument_acceptance_details as $_instrument_acceptance_detail) {
                $instruments .= $_instrument_acceptance_detail->brand . " " . $_instrument_acceptance_detail->instrument_type . "<br>";
            }
            $instrument_acceptance_detail[$instrument_acceptance->id]["instruments"]                    = substr($instruments, 0, -4);
            $instrument_acceptance_detail[$instrument_acceptance->id]["is_request_reviewed"]            = count($this->request_reviews->where(["is_deleted" => 0,           "instrument_acceptance_id" => $instrument_acceptance->id])->where("(adm_approved_by <> '' OR tech_approved_by <> '')")->findAll());
            $instrument_acceptance_detail[$instrument_acceptance->id]["is_instrument_processed"]        = count($this->instrument_processes->where(["is_deleted" => 0,      "instrument_acceptance_id" => $instrument_acceptance->id])->where("(tech_before_by <> '' OR mgrtech_before_by <> '')")->findAll());
            $instrument_acceptance_detail[$instrument_acceptance->id]["is_calibration_form"]            = count($this->calibration_forms->where(["is_deleted" => 0,         "instrument_acceptance_id" => $instrument_acceptance->id])->where("(done_by <> '' OR checked_by <> '')")->findAll());
            $instrument_acceptance_detail[$instrument_acceptance->id]["is_calibration_verificated"]     = count($this->calibration_verifications->where(["is_deleted" => 0, "instrument_acceptance_id" => $instrument_acceptance->id])->where("(calibrated_by <> '' OR calculated_by <> '' OR verified_by <> '')")->findAll());
            $instrument_acceptance_detail[$instrument_acceptance->id]["is_calibration_certificated"]    = count($this->calibration_certificates->where(["is_deleted" => 0,  "instrument_acceptance_id" => $instrument_acceptance->id])->where("issued_by <> ''")->findAll());
            $instrument_acceptance_detail[$instrument_acceptance->id]["is_instrument_released"]         = count($this->instrument_releases->where(["is_deleted" => 0,       "instrument_acceptance_id" => $instrument_acceptance->id])->where("release_by <> ''")->findAll());
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["instrument_acceptances"] = $instrument_acceptances;
        $data["instrument_acceptance_detail"] = @$instrument_acceptance_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('instrument_acceptances/v_list');
        echo view('v_footer');
    }

    public function saving_data()
    {
        return [
            "customer_id" => @$_POST["customer_id"],
            "customer_name" => @$_POST["customer_name"],
            "submitted_by" => @$_POST["submitted_by"],
            "deadlines" => @$_POST["deadlines"],
            "action_id" => @$_POST["action_id"],
            "action_etc" => @$_POST["action_etc"],
        ];
    }

    public function saving_add()
    {
        if (isset($_POST["Save"])) {
            $instrument_acceptance = $this->saving_data() + $this->created_values() + $this->updated_values();
            $this->instrument_acceptances->save($instrument_acceptance);
            $id = $this->instrument_acceptances->insertID();
            foreach ($_POST["sample_no"] as $key => $sample_no) {
                $_POST["brand"][$key] = @$this->item_brands->where(["is_deleted" => 0, "id" => @$_POST["brand_id"][$key]])->findAll()[0]->name;
                $instrument_acceptance_detail = [
                    "instrument_acceptance_id" => $id,
                    "sample_no" => $sample_no,
                    "brand_id" => @$_POST["brand_id"][$key],
                    "brand" => @$_POST["brand"][$key],
                    "instrument_type" => @$_POST["instrument_type"][$key],
                    "partno" => @$_POST["partno"][$key],
                    "serialnumber" => @$_POST["serialnumber"][$key],
                    "notes" => @$_POST["notes"][$key],
                    "instrument_condition" => @$_POST["instrument_condition"][$key],
                ];
                $instrument_acceptance_detail = $instrument_acceptance_detail + $this->created_values() + $this->updated_values();
                $this->instrument_acceptance_details->save($instrument_acceptance_detail);
            }

            $this->session->setFlashdata("flash_message", ["success", "Success adding Instrument Acceptance"]);
            echo "<script> window.location='" . base_url() . "/instrument_acceptance/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function saving_edit($id)
    {
        if (isset($_POST["Save"])) {
            $instrument_acceptance = $this->saving_data() + $this->updated_values();
            $this->instrument_acceptances->update($id, $instrument_acceptance);
            $this->instrument_acceptance_details->where('instrument_acceptance_id', $id)->delete();
            foreach ($_POST["sample_no"] as $key => $sample_no) {
                $_POST["brand"][$key] = @$this->item_brands->where(["is_deleted" => 0, "id" => @$_POST["brand_id"][$key]])->findAll()[0]->name;
                $instrument_acceptance_detail = [
                    "instrument_acceptance_id" => $id,
                    "sample_no" => $sample_no,
                    "brand_id" => @$_POST["brand_id"][$key],
                    "brand" => @$_POST["brand"][$key],
                    "instrument_type" => @$_POST["instrument_type"][$key],
                    "partno" => @$_POST["partno"][$key],
                    "serialnumber" => @$_POST["serialnumber"][$key],
                    "notes" => @$_POST["notes"][$key],
                    "instrument_condition" => @$_POST["instrument_condition"][$key],
                ];
                $instrument_acceptance_detail = $instrument_acceptance_detail + $this->created_values() + $this->updated_values();
                $this->instrument_acceptance_details->save($instrument_acceptance_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success editing Instrument Acceptance"]);
            echo "<script> window.location='" . base_url() . "/instrument_acceptance/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function get_reference_data()
    {
        $data["item_brands"] = $this->item_brands->where("is_deleted", 0)->findAll();
        return $data;
    }

    public function get_saved_data($id)
    {
        $data["instrument_acceptance"] = $this->instrument_acceptances->where("is_deleted", 0)->find([$id])[0];
        $data["instrument_acceptance_details"] = $this->instrument_acceptance_details->where(["is_deleted" => 0, "instrument_acceptance_id" => $id])->findAll();
        $data["created_user"] = @$this->users->where("email", $data["instrument_acceptance"]->created_by)->where("is_deleted", 0)->findAll()[0];
        $data["accepted_user"] = @$this->users->where("email", $data["instrument_acceptance"]->accepted_by)->where("is_deleted", 0)->findAll()[0];
        return $data;
    }

    public function accept($id)
    {
        if (@$_GET["accepting"] == 1) {
            $this->instrument_acceptances->update($id, ["accepted_at" => date("Y-m-d H:i:s"), "accepted_by" => $this->session->get("username"), "accepted_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Instrument Acceptance"]);
            echo "<script> window.location='" . base_url() . "/instrument_acceptance/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        $this->saving_add();

        $data["__modulename"] = "Add Instrument Acceptance";
        $data["__mode"] = "add";

        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('instrument_acceptances/v_edit');
        echo view('v_footer');
        echo view('instrument_acceptances/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        $this->saving_edit($id);
        $data["__modulename"] = "Edit Instrument Acceptance";
        $data["__mode"] = "edit";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        if ($data["instrument_acceptance"]->accepted_by != "") {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/instrument_acceptances');
        }
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('instrument_acceptances/v_edit');
        echo view('v_footer');
        echo view('instrument_acceptances/v_js');
    }

    public function view($id)
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);
        $this->accept($id);

        $data["__modulename"] = "Instrument Acceptance";
        $data["_this"] = $this;
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('instrument_acceptances/v_view');
        echo view('v_footer');
        echo view('instrument_acceptances/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->instrument_acceptances->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting Instrument Acceptance"]);
        return redirect()->to(base_url() . '/instrument_acceptances');
    }

    public function get_instrument_acceptance()
    {
        return json_encode(@$this->instrument_acceptances->where("is_deleted", 0)->where(["id" => $_GET["instrument_acceptance_id"]])->findAll()[0]);
    }

    public function get_instrument_acceptance_details($id)
    {
        $return = [];
        $instrument_acceptance_details = $this->instrument_acceptance_details->where("instrument_acceptance_id", $id)->where("is_deleted", 0)->findAll();
        foreach ($instrument_acceptance_details as $key => $instrument_acceptance_detail) {
            $return[$key]["id"] = $instrument_acceptance_detail->id;
            $return[$key]["sample_no"] = $instrument_acceptance_detail->sample_no;
            $return[$key]["brand_id"] = $instrument_acceptance_detail->brand_id;
            $return[$key]["brand"] = $instrument_acceptance_detail->brand;
            $return[$key]["instrument_type"] = $instrument_acceptance_detail->instrument_type;
            $return[$key]["partno"] = $instrument_acceptance_detail->partno;
            $return[$key]["serialnumber"] = $instrument_acceptance_detail->serialnumber;
            $return[$key]["notes"] = $instrument_acceptance_detail->notes;
            $return[$key]["instrument_condition"] = $instrument_acceptance_detail->instrument_condition;
        }
        return json_encode($return);
    }

    public function get_instrument_acceptance_detail()
    {
        return json_encode(@$this->instrument_acceptance_details->where("is_deleted", 0)->where(["id" => $_GET["instrument_acceptance_detail_id"]])->findAll()[0]);
    }

    public function subwindow()
    {
        $wherclause = "is_deleted = '0'";

        if (isset($_GET["keyword"]) && $_GET["keyword"] != "") {
            $wherclause .= " AND (customer_name LIKE '%" . $_GET["keyword"] . "%' ";
            $wherclause .= "OR submitted_by LIKE '%" . $_GET["keyword"] . "%' ";
            $wherclause .= "OR id IN (SELECT instrument_acceptance_id FROM instrument_acceptance_details WHERE sample_no LIKE '%" . $_GET["keyword"] . "%') ";
            $wherclause .= "OR id IN (SELECT instrument_acceptance_id FROM instrument_acceptance_details WHERE brand LIKE '%" . $_GET["keyword"] . "%') ";
            $wherclause .= "OR id IN (SELECT instrument_acceptance_id FROM instrument_acceptance_details WHERE instrument_type LIKE '%" . $_GET["keyword"] . "%') ";
            $wherclause .= "OR id IN (SELECT instrument_acceptance_id FROM instrument_acceptance_details WHERE serialnumber LIKE '%" . $_GET["keyword"] . "%') )";
        }
        $data["instrument_acceptances"]      = $this->instrument_acceptances->where($wherclause)->findAll(LIMIT_SUBWINDOW, 0);

        foreach ($data["instrument_acceptances"] as $instrument_acceptance) {
            $instrument_acceptance_details[$instrument_acceptance->id] = @$this->instrument_acceptance_details->where("instrument_acceptance_id", $instrument_acceptance->id)->findAll();
        }
        $data["instrument_acceptance_details"]    = @$instrument_acceptance_details;

        $data                   = $data + $this->common();
        echo view('instrument_acceptances/v_subwindow', $data);
    }
}
