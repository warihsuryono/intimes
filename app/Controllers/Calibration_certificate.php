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
use App\Models\m_customer;
use App\Models\m_item;
use App\Models\m_item_brand;
use App\Models\m_currency;
use App\Models\m_unit;
use App\Models\m_item_type;
use App\Models\m_item_scope;

class Calibration_certificate extends BaseController
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
    protected $customers;
    protected $items;
    protected $item_brands;
    protected $currencies;
    protected $units;
    protected $item_types;
    protected $item_scopes;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "calibration_certificates";
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
        $this->customers                        = new m_customer();
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
        $data["__modulename"] = "Calibration Certificate";
        $data["_this"] = $this;
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["accepted_at"]) && $_GET["accepted_at"] != "")
            $wherclause .= "AND accepted_at LIKE '" . $_GET["accepted_at"] . "%'";

        if (isset($_GET["process_start"]) && $_GET["process_start"] != "")
            $wherclause .= "AND process_start LIKE '" . $_GET["process_start"] . "%'";

        if (isset($_GET["issued_at"]) && $_GET["issued_at"] != "")
            $wherclause .= "AND issued_at LIKE '" . $_GET["issued_at"] . "%'";

        if (isset($_GET["created_by"]) && $_GET["created_by"] != "")
            $wherclause .= "AND created_by LIKE '%" . $_GET["created_by"] . "%'";

        if (isset($_GET["is_instrument_released"]) && $_GET["is_instrument_released"] != "")
            $wherclause .= "AND instrument_acceptance_id IN (SELECT instrument_acceptance_id FROM instrument_releases WHERE  is_deleted = 0 AND release_by <> '')";

        $calibration_certificates = $this->calibration_certificates->where($wherclause)->orderBy("id DESC")->orderBy("id DESC")->findAll(MAX_ROW, $startrow);

        $numrow = count($this->calibration_certificates->where($wherclause)->findAll());

        foreach ($calibration_certificates as $calibration_certificate) {
            $calibration_certificate_detail[$calibration_certificate->id]["is_instrument_released"] = count($this->instrument_releases->where(["is_deleted" => 0,       "instrument_acceptance_id" => $calibration_certificate->instrument_acceptance_id])->where("release_by <> ''")->findAll());
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["calibration_certificates"] = $calibration_certificates;
        $data["calibration_certificate_detail"] = @$calibration_certificate_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('calibration_certificates/v_list');
        echo view('v_footer');
    }

    public function saving_data()
    {
        $instrument_acceptance_id = @$this->calibration_verifications->where(["is_deleted" => 0, "id" => $_POST["calibration_verification_id"]])->findAll()[0]->instrument_acceptance_id;
        $_POST["brand"] = $this->item_brands->where(["is_deleted" => 0, "id" => $_POST["brand_id"]])->findAll()[0]->name;
        return [
            "instrument_acceptance_id" => $instrument_acceptance_id,
            "calibration_verification_id" => @$_POST["calibration_verification_id"],
            "customer_id" => @$_POST["customer_id"],
            "customer_name" => @$_POST["customer_name"],
            "address" => str_replace(chr(13) . chr(10), "<br>", @$_POST["address"]),
            "phone" => @$_POST["phone"],
            "fax" => @$_POST["fax"],
            "email" => @$_POST["email"],
            "name" => @$_POST["name"],
            "sample_no" => @$_POST["sample_no"],
            "brand_id" => @$_POST["brand_id"],
            "brand" => @$_POST["brand"],
            "instrument_type" => @$_POST["instrument_type"],
            "partno" => @$_POST["partno"],
            "serialnumber" => @$_POST["serialnumber"],
            "accepted_at" => @$_POST["accepted_at"],
            "process_start" => @$_POST["process_start"],
            "process_place" => @$_POST["process_place"],
            "method" => str_replace(chr(13) . chr(10), "<br>", @$_POST["method"]),
            "relative_humidity" => @$_POST["relative_humidity"],
            "relative_humidity_tolerance" => @$_POST["relative_humidity_tolerance"],
            "temperature" => @$_POST["temperature"],
            "temperature_tolerance" => @$_POST["temperature_tolerance"],
            "traceability" => str_replace(chr(13) . chr(10), "<br>", @$_POST["traceability"]),
            "issued_at" => @$_POST["issued_at"],
            "issued_by" => $this->session->get("username"),
            "issued_ip" => $_SERVER["REMOTE_ADDR"],
        ];
    }

    public function saving_add()
    {
        if (isset($_POST["Save"])) {
            $calibration_certificate = $this->saving_data() + $this->created_values() + $this->updated_values();
            $this->calibration_certificates->save($calibration_certificate);
            $id = $this->calibration_certificates->insertID();
            foreach ($_POST["item_type_id"] as $key => $item_type_id) {
                $calibration_certificate_detail = [
                    "calibration_certificate_id" => $id,
                    "item_type_id" => $item_type_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "scope" => @$_POST["scope"][$key],
                    "resolution" => @$_POST["resolution"][$key],
                    "tolerance" => @$_POST["tolerance"][$key],
                    "standard" => @$_POST["standard"][$key],
                    "measured" => @$_POST["measured"][$key],
                    "correction" => @$_POST["correction"][$key],
                    "uncertainty" => @$_POST["uncertainty"][$key],
                    "cylinder_no" => @$_POST["cylinder_no"][$key],
                ];
                $calibration_certificate_detail = $calibration_certificate_detail + $this->created_values() + $this->updated_values();
                $this->calibration_certificate_details->save($calibration_certificate_detail);
            }

            $this->session->setFlashdata("flash_message", ["success", "Success adding Calibration Certificate"]);
            echo "<script> window.location='" . base_url() . "/calibration_certificate/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function saving_edit($id)
    {
        if (isset($_POST["Save"])) {
            $calibration_certificate = $this->saving_data() + $this->updated_values();
            $this->calibration_certificates->update($id, $calibration_certificate);
            $this->calibration_certificate_details->where('calibration_certificate_id', $id)->delete();
            foreach ($_POST["item_type_id"] as $key => $item_type_id) {
                $calibration_certificate_detail = [
                    "calibration_certificate_id" => $id,
                    "item_type_id" => $item_type_id,
                    "unit_id" => @$_POST["unit_id"][$key],
                    "scope" => @$_POST["scope"][$key],
                    "resolution" => @$_POST["resolution"][$key],
                    "tolerance" => @$_POST["tolerance"][$key],
                    "standard" => @$_POST["standard"][$key],
                    "measured" => @$_POST["measured"][$key],
                    "correction" => @$_POST["correction"][$key],
                    "uncertainty" => @$_POST["uncertainty"][$key],
                    "cylinder_no" => @$_POST["cylinder_no"][$key],
                ];
                $calibration_certificate_detail = $calibration_certificate_detail + $this->created_values() + $this->updated_values();
                $this->calibration_certificate_details->save($calibration_certificate_detail);
            }
            $this->session->setFlashdata("flash_message", ["success", "Success editing Calibration Certificate"]);
            echo "<script> window.location='" . base_url() . "/calibration_certificate/view/" . $id . "'; </script>";
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
        $data["calibration_certificate"] = $this->calibration_certificates->where("is_deleted", 0)->find([$id])[0];
        $data["calibration_certificate_details"] = $this->calibration_certificate_details->where(["is_deleted" => 0, "calibration_certificate_id" => $id])->findAll();
        $data["created_user"] = @$this->users->where("email", $data["calibration_certificate"]->created_by)->where("is_deleted", 0)->findAll()[0];
        $data["issued_user"] = @$this->users->where("email", $data["calibration_certificate"]->issued_by)->where("is_deleted", 0)->findAll()[0];
        return $data;
    }

    public function approve($id)
    {
        if (@$_GET["issued_approving"] == 1) {
            $this->calibration_certificates->update($id, ["issued_at" => date("Y-m-d H:i:s"), "issued_by" => $this->session->get("username"), "issued_ip" => $_SERVER["REMOTE_ADDR"]]);
            $this->session->setFlashdata("flash_message", ["success", "Success approving Calibration Certificate"]);
            echo "<script> window.location='" . base_url() . "/calibration_certificate/view/" . $id . "'; </script>";
            exit();
        }
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);

        $calibration_verification = @$this->calibration_verifications->where(["is_deleted" => 0, "id" => @$_GET["calibration_verification_id"]])->findAll()[0];
        if (@$calibration_verification->id > 0) {
            $calibration_verification = @$this->calibration_verifications->where(["is_deleted" => 0, "id" => $_GET["calibration_verification_id"]])->findAll()[0];
            $calibration_form_id = $calibration_verification->calibration_form_id;
            $calibration_form = @$this->calibration_forms->where(["is_deleted" => 0, "id" => $calibration_form_id])->findAll()[0];
            $calibration_form_details = @$this->calibration_form_details->where(["is_deleted" => 0, "calibration_form_id" => $calibration_form_id])->findAll();
            $instrument_acceptance_id = $calibration_verification->instrument_acceptance_id;
            $instrument_acceptance = @$this->instrument_acceptances->where(["is_deleted" => 0, "id" => $instrument_acceptance_id])->findAll()[0];
        } else {
            $this->session->setFlashdata("flash_message", ["error", "Dokumen pengecekan dan pengerjaan alat tidak dikenal"]);
            echo "<script> window.location='" . base_url() . "/calibration_verifications'; </script>";
            exit();
        }


        $this->saving_add();

        $data["__modulename"] = "Add Calibration Certificate";
        $data["__mode"] = "add";

        $data["calibration_verification"] = $calibration_verification;
        $customer_id = $instrument_acceptance->customer_id;
        $customer_name = $instrument_acceptance->customer_name;
        $customer = @$this->customers->where(["is_deleted" => 0, "id" => $customer_id])->findAll()[0];
        $address = str_replace("<br>", "\n", $customer->address);
        $phone = $customer->phone;
        $fax = $customer->fax;
        $email = $customer->email;
        $name = $calibration_verification->brand . " " . $calibration_verification->instrument_type;
        $accepted_at = $instrument_acceptance->accepted_at;
        $relative_humidity = $calibration_form->humidity;
        $relative_humidity_tolerance = 2;
        $temperature = $calibration_form->temperature;
        $temperature_tolerance = 0.15;
        $data["calibration_certificate"] = (object) [
            "calibration_verification_id" => $_GET["calibration_verification_id"],
            "customer_id" => $customer_id,
            "customer_name" => $customer_name,
            "address" => $address,
            "phone" => $phone,
            "fax" => $fax,
            "email" => $email,
            "name" => $name,
            "sample_no" => $calibration_form->sample_no,
            "brand_id" => $calibration_form->brand_id,
            "instrument_type" => $calibration_form->instrument_type,
            "partno" => $calibration_form->partno,
            "serialnumber" => $calibration_form->serialnumber,
            "accepted_at" => $accepted_at,
            "process_start" => $calibration_form->calibration_at,
            "process_place" => "In Lab",
            "method" => "IK.TüT-01\nDiriectComparation\nto Certified Gas (In House\nMethode)",
            "relative_humidity" => $relative_humidity,
            "relative_humidity_tolerance" => $relative_humidity_tolerance,
            "temperature" => $temperature,
            "temperature_tolerance" => $temperature_tolerance,
            "traceability" => "to SI Units through Calgaz\nCertified",
            "issued_at" => date("Y-m-d"),
        ];
        foreach ($calibration_form_details as $key => $calibration_form_detail) {
            $item_scope = $this->item_scopes->where(["is_deleted" => 0, "id" => $calibration_form_detail->scope_id])->findAll()[0];
            $data["calibration_certificate_details"][$key] = (object) [
                "item_type_id" => $calibration_form_detail->item_type_id,
                "scope_id" => $item_scope->id,
                "unit_id" => $item_scope->unit_id,
                "item_type" => $this->item_types->where(["is_deleted" => 0, "id" => $calibration_form_detail->item_type_id])->findAll()[0]->name,
                "unit" => $this->units->where(["is_deleted" => 0, "id" => $item_scope->unit_id])->findAll()[0]->name,
                "scope" => $item_scope->name,
                "resolution" => explode("||", substr($calibration_form->scope_ids, 1, -1))[$key],
                "standard" => $item_scope->name,
                "measured" => $item_scope->name,
                "correction" => 0,
            ];
        }

        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('calibration_certificates/v_edit');
        echo view('v_footer');
        echo view('calibration_certificates/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        $this->saving_edit($id);
        $data["__modulename"] = "Edit Calibration Certificate";
        $data["__mode"] = "edit";
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);

        if (count($this->instrument_releases->where(["is_deleted" => 0, "instrument_acceptance_id" => $data["calibration_certificate"]->instrument_acceptance_id])->where("release_by <> ''")->findAll()) > 0) {
            $this->session->setFlashdata("flash_message", ["warning", "This document cannot be edited anymore!"]);
            return redirect()->to(base_url() . '/calibration_certificates');
        }

        foreach ($data["calibration_certificate_details"] as $key => $calibration_certificate_detail) {
            $data["calibration_certificate_details"][$key] = (object) [
                "item_type_id" => $calibration_certificate_detail->item_type_id,
                "unit_id" => $calibration_certificate_detail->unit_id,
                "item_type" => $this->item_types->where(["is_deleted" => 0, "id" => $calibration_certificate_detail->item_type_id])->findAll()[0]->name,
                "unit" => $this->units->where(["is_deleted" => 0, "id" => $calibration_certificate_detail->unit_id])->findAll()[0]->name,
                "scope" => $calibration_certificate_detail->scope,
                "resolution" => $calibration_certificate_detail->resolution,
                "tolerance" => $calibration_certificate_detail->tolerance,
                "standard" => $calibration_certificate_detail->standard,
                "measured" => $calibration_certificate_detail->measured,
                "correction" => $calibration_certificate_detail->correction,
                "uncertainty" => $calibration_certificate_detail->uncertainty,
                "cylinder_no" => $calibration_certificate_detail->cylinder_no,
            ];
        }

        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('calibration_certificates/v_edit');
        echo view('v_footer');
        echo view('calibration_certificates/v_js');
    }

    public function view($id)
    {
        $this->privilege_check($this->menu_ids, 4, $this->route_name);
        $this->approve($id);

        $data["__modulename"] = "Calibration Certificate";
        $data["_this"] = $this;
        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('calibration_certificates/v_view');
        echo view('v_footer');
        echo view('calibration_certificates/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        $this->calibration_certificates->update($id, ["is_deleted" => 1] + $this->deleted_values());
        $this->session->setFlashdata("flash_message", ["success", "Success deleting Calibration Certificate"]);
        return redirect()->to(base_url() . '/calibration_certificates');
    }

    public function get_calibration_certificate()
    {
        return json_encode(@$this->calibration_certificates->where("is_deleted", 0)->where(["id" => $_GET["calibration_certificate_id"]])->findAll()[0]);
    }

    public function get_calibration_certificate_detail($id)
    {
        $return = [];
        $calibration_certificate_details = $this->calibration_certificate_details->where("calibration_certificate_id", $id)->where("is_deleted", 0)->findAll();
        foreach ($calibration_certificate_details as $key => $calibration_certificate_detail) {
            $return[$key]["id"] = $calibration_certificate_detail->id;
            $return[$key]["calibration_certificate_id"] = $calibration_certificate_detail->calibration_certificate_id;
            $return[$key]["item_type_id"] = $calibration_certificate_detail->item_type_id;
            $return[$key]["item_type"] = @$this->item_types->where(["is_deleted" => 0, "id" => $calibration_certificate_detail->item_type_id])->findAll()[0]->name;
            $return[$key]["unit_id"] = $calibration_certificate_detail->unit_id;
            $return[$key]["unit"] = @$this->units->where(["is_deleted" => 0, "id" => $calibration_certificate_detail->unit_id])->findAll()[0]->name;
            $return[$key]["resolution"] = $calibration_certificate_detail->resolution;
            $return[$key]["tolerance"] = $calibration_certificate_detail->tolerance;
            $return[$key]["standard"] = $calibration_certificate_detail->standard;
            $return[$key]["measured"] = $calibration_certificate_detail->measured;
            $return[$key]["correction"] = $calibration_certificate_detail->correction;
            $return[$key]["uncertainty"] = $calibration_certificate_detail->uncertainty;
            $return[$key]["cylinder_no"] = $calibration_certificate_detail->cylinder_no;
        }
        return json_encode($return);
    }
}
