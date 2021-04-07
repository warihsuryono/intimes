<?php

namespace App\Controllers;

use App\Models\m_checking;
use App\Models\m_checking_detail;
use App\Models\m_checking_photo;
use App\Models\m_mounting;
use App\Models\m_mounting_detail;
use App\Models\m_tire_position;
use App\Models\m_tire_type;
use App\Models\m_vehicle;
use App\Models\m_vehicle_type;

class Checking extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $checkings;
    protected $checking_details;
    protected $checking_photos;
    protected $mountings;
    protected $mounting_details;
    protected $tire_positions;
    protected $tire_types;
    protected $vehicles;
    protected $vehicle_types;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "checkings";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->checkings =  new m_checking();
        $this->checking_details =  new m_checking_detail();
        $this->checking_photos =  new m_checking_photo();
        $this->mountings =  new m_mounting();
        $this->mounting_details =  new m_mounting_detail();
        $this->tire_positions =  new m_tire_position();
        $this->tire_types =  new m_tire_type();
        $this->vehicles =  new m_vehicle();
        $this->vehicle_types =  new m_vehicle_type();
    }

    public function get_reference_data()
    {
        $data = [];
        @$data["yesnooption"][0]->id = 0;
        @$data["yesnooption"][0]->name = "No";
        @$data["yesnooption"][1]->id = 1;
        @$data["yesnooption"][1]->name = "Yes";

        $data["tire_positions"] = $this->tire_positions->where("is_deleted", "0")->findAll();
        $data["tire_types"] = $this->tire_types->where("is_deleted", "0")->findAll();
        $data["checkings_office_only"] = false;

        return $data;
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Checking";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["checking_at"]) && $_GET["checking_at"] != "")
            $wherclause .= "AND checking_at = '" . $_GET["checking_at"] . "'";

        if (isset($_GET["tire_qr_code"]) && $_GET["tire_qr_code"] != "")
            $wherclause .= "AND id IN (SELECT checking_id FROM checking_details WHERE code LIKE '%" . $_GET["tire_qr_code"] . "%')";

        if ($checkings = $this->checkings->where($wherclause)->orderBy("id DESC")->findAll(MAX_ROW, $startrow)) {
            $numrow = count($this->checkings->where($wherclause)->findAll());
            foreach ($checkings as $checking) {
                $checking_detail[$checking->id] = @$this->checking_details->where(["is_deleted" => 0, "checking_id" => $checking->id])->findAll()[0];
                $checking_detail[$checking->id]->tire_position = @$this->tire_positions->where(["is_deleted" => 0, "id" => $checking_detail[$checking->id]->tire_position_id])->findAll()[0];
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["checkings"] = $checkings;
        $data["checking_detail"] = @$checking_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('checkings/v_list');
        echo view('v_footer');
    }

    public function saving_data($mode, $masterdetail = "master", $id = null)
    {
        if ($masterdetail == "master") {
            $data = [];
            if ($mode == "add")
                $data = ["mounting_id"   => @$_POST["mounting_id"]];

            $data = $data + [
                "spk_no"                        => @$_POST["spk_no"],
                "spk_at"                        => @$_POST["spk_at"],
                "customer_id"                   => @$_POST["customer_id"],
                "customer_name"                 => @$_POST["customer_name"],
                "checking_at"                   => @$_POST["checking_at"],
                "vehicle_id"                    => @$_POST["vehicle_id"],
                "vehicle_registration_plate"    => @$_POST["vehicle_registration_plate"],
                "notes"                         => @$_POST["notes"],
            ];
            return $data;
        }

        if ($masterdetail == "detail")
            return [
                "checking_id"           => $id,
                "tire_id"               => @$_POST["tire_id"],
                "code"                  => @$_POST["tire_qr_code"],
                "tire_type_id"          => @$_POST["tire_type_id"],
                "tire_position_id"      => @$_POST["tire_position_id"],
                "old_tire_position_id"  => @$_POST["old_tire_position_id"],
                "km"                    => @$_POST["km"],
                "rtd1"                  => @$_POST["rtd1"],
                "rtd2"                  => @$_POST["rtd2"],
                "rtd3"                  => @$_POST["rtd3"],
                "rtd4"                  => @$_POST["rtd4"],
                "psi_before"            => @$_POST["psi_before"],
                "psi"                   => @$_POST["psi"],
                "remark"                => @$_POST["remark"],
            ];
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        $mounting = @$this->mountings->where("is_deleted", 0)->where("id IN (SELECT mounting_id FROM mounting_details WHERE code LIKE '" . $_POST["tire_qr_code"] . "')")->orderBy("mounting_at DESC")->findAll();
        if (count($mounting) <= 0 && @$_POST["tire_qr_code"] != "") {
            $this->session->setFlashdata("flash_message", ["error", "Sorry, tire with code `" . $_POST["tire_qr_code"] . "` has never been installed"]);
            return redirect()->to(base_url() . '/checkings');
            exit();
        }
        $data["mounting"] = @$mounting[0];

        if (isset($_POST["Save"])) {
            $mounting = @$this->mountings->where("is_deleted", 0)->where("id IN (SELECT mounting_id FROM mounting_details WHERE code LIKE '" . $_POST["tire_qr_code"] . "')")->orderBy("mounting_at DESC")->findAll()[0];
            if (@$mounting->id <= 0) {
                $this->session->setFlashdata("flash_message", ["error", "Sorry, tire with code `" . @$_POST["tire_qr_code"] . "` has never been installed"]);
                return redirect()->to(base_url() . '/checking/add');
                exit();
            }
            $mounting_detail = @$this->mounting_details->where(["mounting_id" => $mounting->id, "code" => @$_POST["tire_qr_code"]])->findAll()[0];
            $_POST["mounting_id"] = $mounting->id;
            $_POST["customer_id"] = $mounting->customer_id;
            $_POST["customer_name"] = $mounting->customer_name;
            $_POST["vehicle_id"] = $mounting->vehicle_id;
            $_POST["vehicle_registration_plate"] = $mounting->vehicle_registration_plate;
            $_POST["old_tire_position_id"] = $mounting_detail->tire_position_id;
            $_POST["tire_id"] = $mounting_detail->tire_id;
            $_POST["tire_qr_code"] = $mounting_detail->code;
            $_POST["tire_type_id"] = $mounting_detail->tire_type_id;

            $_POST["spk_no"] = "";
            $_POST["spk_at"] = "0000-00-00";

            $checking = @$this->checkings->where(["is_deleted" => 0, "mounting_id" => $mounting->id])->orderBy("id DESC")->findAll()[0];
            if (@$checking->id > 0) {
                $checking_detail = @$this->checking_details->where(["checking_id" => $checking->id, "code" => $_POST["tire_qr_code"]])->findAll()[0];
                $_POST["old_tire_position_id"] = $checking_detail->tire_position_id;
            }
            $checking = $this->saving_data("add") + $this->created_values() + $this->updated_values();
            if ($this->checkings->save($checking)) {
                $id = $this->checkings->insertID();
                $checking_detail = $this->saving_data("add", "detail", $id) + $this->created_values() + $this->updated_values();
                $this->checking_details->save($checking_detail);
                $this->session->setFlashdata("flash_message", ["success", "Success adding checking"]);
                return redirect()->to(base_url() . '/checking/edit/' . $id);
            } else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding checking"]);
        }

        $data["__modulename"] = "Add Checking";
        $data["__mode"] = "add";
        $data = $data + $this->common();
        $data = $data + $this->get_reference_data();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('checkings/v_edit');
        echo view('v_footer');
        echo view('checkings/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $checking = $this->saving_data("edit");
            $checking = $checking + $this->updated_values();
            if ($this->checkings->update($id, $checking)) {
                $this->session->setFlashdata("flash_message", ["success", "Success editing checking"]);
                return redirect()->to(base_url() . '/checking/edit/' . $id);
            } else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing checking"]);
        }

        $data["__modulename"] = "Edit Checking";
        $data["__mode"] = "edit";
        $data["id"] = $id;
        $data["checking"] = $this->checkings->where("is_deleted", "0")->find([$id])[0];
        $data = $data + $this->common();
        $data = $data + $this->get_reference_data();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('checkings/v_edit');
        echo view('v_footer');
        echo view('checkings/v_js');
    }

    public function takepictures($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);

        $data["__modulename"] = "Take Pictures of Tire Checkings";
        $data["__mode"] = "takepictures";
        $data["id"] = $id;
        $data["checking"] = $this->checkings->where("is_deleted", "0")->find([$id])[0];
        $data = $data + $this->common();
        $data = $data + $this->get_reference_data();
        $data["checking_pictures"]["km"] = $this->checking_pictures->where(["is_deleted" => 0, "checking_id" => $id, "mode" => "km"])->findAll();
        $data["checking_pictures"]["tire"] = $this->checking_pictures->where(["is_deleted" => 0, "checking_id" => $id, "mode" => "tire"])->findAll();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('checkings/v_takepictures');
        echo view('v_footer');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->checkings->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting checking"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting checking"]);
        return redirect()->to(base_url() . '/checkings');
    }

    public function get_item($id)
    {
        return json_encode($this->checkings->where("is_deleted", 0)->find([$id]));
    }

    public function get_item_by_qrcode($qrcode)
    {
        $checking = $this->checkings->where(["is_deleted" => 0, "tire_qr_code" => $qrcode])->findAll()[0];
        $checking->old_tire_position = @$this->tire_positions->where("id", $checking->old_tire_position_id)->findAll()[0];
        $checking->tire_position = @$this->tire_positions->where("id", $checking->tire_position_id)->findAll()[0];
        $checking->check_at = $this->format_tanggal($checking->check_at);
        return json_encode($checking);
    }

    public function subwindow()
    {
        $wherclause = "is_deleted = '0'";

        if (isset($_GET["keyword"]) && $_GET["keyword"] != "") {
            $wherclause .= "AND (registration_plate LIKE '%" . $_GET["keyword"] . "%'";
            $wherclause .= "OR model LIKE '%" . $_GET["keyword"] . "%')";
        }

        $checkings = $this->checkings->where($wherclause)->findAll(LIMIT_SUBWINDOW, 0);

        $data["checkings"]       = @$checkings;
        $data                       = $data + $this->common();
        echo view('checkings/v_subwindow', $data);
    }

    public function put_image($id, $mode)
    {
        $img = file_get_contents('php://input');
        $img = explode(";base64,", $img);
        $ext = explode("/", $img[0])[1];
        $img = base64_decode(str_replace(' ', '+', $img[1]));
        $filename = date("ymdhis") . "_" . rand(0, 9) . rand(0, 9) . rand(0, 9) . "_" . $id . "_" . $mode . "." . $ext;
        if (file_put_contents('dist/upload/checkings/' . $filename, $img)) {
            $this->resizeImage('dist/upload/checkings/' . $filename);
            $data = ["checking_id" => $id, "mode" => $mode, "filename" => $filename]  + $this->created_values() + $this->updated_values();
            $this->checking_pictures->save($data);
            echo json_encode($this->checking_pictures->where(["is_deleted" => 0, "checking_id" => $id, "mode" => $mode])->findAll());
        } else {
            echo "0";
        }
    }

    public function get_last_checking($tire_id)
    {
        $data = [];
        $checking_detail = @$this->checking_details->join("checkings", "checking_details.checking_id = checkings.id")->where(["checkings.is_deleted" => 0, "tire_id" => $tire_id])->orderBy("checking_at DESC")->findAll()[0];
        $mounting_detail = @$this->mounting_details->join("mountings", "mounting_details.mounting_id = mountings.id")->where(["mountings.is_deleted" => 0, "tire_id" => $tire_id])->orderBy("mounting_at DESC")->findAll()[0];
        if (@$checking_detail->id > 0) {
            $data["tire_position"] = @$this->tire_positions->where(["is_deleted" => 0, "id" => $checking_detail->tire_position_id])->findAll()[0];
            $data["mount_km"] = @$mounting_detail->km;
            $data["check_km"] = @$checking_detail->km;
            $data["remain_tread_depth"] = @$checking_detail->rtd1 . "," . @$checking_detail->rtd2 . "," . @$checking_detail->rtd3 . "," . @$checking_detail->rtd4;
        } else {
            $data["tire_position"] = @$this->tire_positions->where(["is_deleted" => 0, "id" => $mounting_detail->tire_position_id])->findAll()[0];
            $data["mount_km"] = @$mounting_detail->km;
            $data["check_km"] = 0;
            $data["remain_tread_depth"] = @$mounting_detail->otd;
        }
        echo json_encode($data);
    }

    public function get_tires_map($qrcode)
    {
        $tires_map = "";
        $mounting = @$this->mountings->where("is_deleted", 0)->where("id IN (SELECT mounting_id FROM mounting_details WHERE code LIKE '" . $qrcode . "')")->orderBy("mounting_at DESC")->findAll()[0];
        if (@$mounting->id <= 0) return $tires_map;

        $checking = @$this->checkings->where(["is_deleted" => 0, "mounting_id" => $mounting->id])->orderBy("id DESC")->findAll()[0];
        if (@$checking->id > 0)
            $mounted_tire_position_id = @$this->checking_details->where(["checking_id" => $checking->id, "code" => $qrcode])->findAll()[0]->tire_position_id;
        else
            $mounted_tire_position_id = @$this->mounting_details->where(["mounting_id" => $mounting->id, "code" => $qrcode])->findAll()[0]->tire_position_id;

        $vehicle = @$this->vehicles->where(["is_deleted" => 0, "id" => $mounting->vehicle_id])->findAll()[0];
        $vehicle_type = @$this->vehicle_types->where(["is_deleted" => 0, "id" => $vehicle->vehicle_type_id])->findAll()[0];
        if (@$vehicle_type->tire_position_ids != "") {
            $tire_positions = @$this->tire_positions->where("is_deleted", 0)->where("id IN (" . @$vehicle_type->tire_position_ids . ")")->findAll();
            if (isset($tire_positions)) {
                $tire_position_ids = [];
                $tires_map = "
                    <style>
                        .btn-tire {
                            position: absolute;
                            height: 70px;
                            width: 40px;
                        }
                    </style>";

                foreach ($tire_positions as $tire_position) {
                    $btn_color = "btn-info";
                    if ($mounted_tire_position_id == $tire_position->id) $btn_color = "btn-danger";
                    $tires_map .= "<div class='btn " . $btn_color . " btn-tire' id=\"tires_map_" . $tire_position->id . "\" style='" . $tire_position->styles . "' onclick=\"tire_position_clicked('" . $tire_position->id . "');\"></div>";
                    $tire_position_ids[] = $tire_position->id;
                }
                if (in_array(1, $tire_position_ids) || in_array(2, $tire_position_ids)) {
                    $tires_map .= "<div class='btn-info' style='position:absolute;width:65px;height:3px;top:32px;left:85px;'></div>";
                    $tiresrow = 1;
                }
                if (in_array(3, $tire_position_ids) || in_array(4, $tire_position_ids) || in_array(5, $tire_position_ids) || in_array(6, $tire_position_ids)) {
                    $tires_map .= "<div class='btn-info' style='position:absolute;width:65px;height:3px;top:132px;left:85px;'></div>";
                    $tiresrow = 2;
                }
                if (in_array(7, $tire_position_ids) || in_array(8, $tire_position_ids) || in_array(9, $tire_position_ids) || in_array(10, $tire_position_ids)) {
                    $tires_map .= "<div class='btn-info' style='position:absolute;width:65px;height:3px;top:232px;left:85px;'></div>";
                    $tiresrow = 3;
                }
                if (in_array(11, $tire_position_ids) || in_array(12, $tire_position_ids) || in_array(13, $tire_position_ids) || in_array(14, $tire_position_ids)) {
                    $tires_map .= "<div class='btn-info' style='position:absolute;width:65px;height:3px;top:382px;left:85px;'></div>";
                    $tiresrow = 4;
                }
                if (in_array(15, $tire_position_ids) || in_array(16, $tire_position_ids) || in_array(17, $tire_position_ids) || in_array(18, $tire_position_ids)) {
                    $tires_map .= "<div class='btn-info' style='position:absolute;width:65px;height:3px;top:482px;left:85px;'></div>";
                    $tiresrow = 5;
                }
                if (in_array(19, $tire_position_ids) || in_array(20, $tire_position_ids) || in_array(21, $tire_position_ids) || in_array(22, $tire_position_ids)) {
                    $tires_map .= "<div class='btn-info' style='position:absolute;width:65px;height:3px;top:582px;left:85px;'></div>";
                    $tiresrow = 6;
                }
                $tires_map .= "<input type='hidden' id='tiresrow' value='" . $tiresrow . "'>";
            }
        }
        return $tires_map;
    }
}
