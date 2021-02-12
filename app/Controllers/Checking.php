<?php

namespace App\Controllers;

use App\Models\m_checking;
use App\Models\m_checking_picture;
use App\Models\m_installation;
use App\Models\m_tire_position;
use App\Models\m_tire_type;

class Checking extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $checkings;
    protected $checking_pictures;
    protected $installations;
    protected $tire_positions;
    protected $tire_types;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "checkings";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->checkings =  new m_checking();
        $this->checking_pictures =  new m_checking_picture();
        $this->installations =  new m_installation();
        $this->tire_positions =  new m_tire_position();
        $this->tire_types =  new m_tire_type();
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

        if (isset($_GET["check_at"]) && $_GET["check_at"] != "")
            $wherclause .= "AND check_at = '" . $_GET["check_at"] . "'";

        if (isset($_GET["tire_qr_code"]) && $_GET["tire_qr_code"] != "")
            $wherclause .= "AND tire_qr_code LIKE '%" . $_GET["tire_qr_code"] . "%'";

        if ($checkings = $this->checkings->where($wherclause)->findAll(MAX_ROW, $startrow)) {
            $numrow = count($this->checkings->where($wherclause)->findAll());
            foreach ($checkings as $checking) {
                $checking_detail[$checking->id]["old_tire_position"] = @$this->tire_positions->where("id", $checking->old_tire_position_id)->findAll()[0];
                $checking_detail[$checking->id]["tire_position"] = @$this->tire_positions->where("id", $checking->tire_position_id)->findAll()[0];
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

    public function saving_data($mode)
    {
        $data = [];
        if ($mode == "add") {
            $data = [
                "installation_id"   => @$_POST["installation_id"],
                "tire_id"           => @$_POST["tire_id"],
                "tire_qr_code"      => @$_POST["tire_qr_code"],
            ];
        }
        $data = $data + [
            "old_tire_position_id"  => @$_POST["old_tire_position_id"],
            "tire_position_id"      => @$_POST["tire_position_id"],
            "tire_position_changed" => @$_POST["tire_position_changed"],
            "tire_position_remark"  => @$_POST["tire_position_remark"],
            "check_km"              => @$_POST["check_km"],
            "check_at"              => @$_POST["check_at"],
            "remain_tread_depth"    => @$_POST["remain_tread_depth"],
            "psi"                   => @$_POST["psi"],
            "notes"                 => @$_POST["notes"],
        ];

        return $data;
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        $installation = @$this->installations->where(["is_deleted" => 0, "tire_qr_code" => $_GET["qrcode"]])->orderBy("installed_at DESC")->findAll();
        if (count($installation) <= 0 && @$_GET["qrcode"] != "") {
            $this->session->setFlashdata("flash_message", ["error", "Sorry, tire with code `" . $_GET["qrcode"] . "` has never been installed"]);
            return redirect()->to(base_url() . '/checkings');
            exit();
        }
        $data["installation"] = @$installation[0];

        if (isset($_POST["Save"])) {
            $installation = @$this->installations->where(["is_deleted" => 0, "tire_qr_code" => @$_POST["tire_qr_code"]])->orderBy("installed_at DESC")->findAll()[0];
            if (@$installation->id <= 0) {
                $this->session->setFlashdata("flash_message", ["error", "Sorry, tire with code `" . @$_POST["tire_qr_code"] . "` has never been installed"]);
                return redirect()->to(base_url() . '/checking/add');
                exit();
            }
            $_POST["installation_id"] = $installation->id;
            $_POST["old_tire_position_id"] = $installation->tire_position_id;
            $_POST["tire_id"] = $installation->tire_id;
            $_POST["tire_qr_code"] = $installation->tire_qr_code;
            $checking = @$this->checkings->where(["is_deleted" => 0, "tire_qr_code" => @$_POST["tire_qr_code"]])->orderBy("check_at DESC")->findAll()[0];
            if (@$checking->id > 0) $_POST["old_tire_position_id"] = $checking->tire_position_id;
            $checking = $this->saving_data("add");
            $checking = $checking + $this->created_values() + $this->updated_values();
            if ($this->checkings->save($checking)) {
                $id = $this->checkings->insertID();
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
        $checking = @$this->checkings->where(["is_deleted" => 0, "tire_id" => $tire_id])->orderBy("check_at DESC")->findAll()[0];
        $installation = @$this->installations->where(["is_deleted" => 0, "tire_id" => $tire_id])->orderBy("installed_at DESC")->findAll()[0];
        if (@$checking->id > 0) {
            $data["tire_position"] = @$this->tire_positions->where(["is_deleted" => 0, "id" => $checking->tire_position_id])->findAll()[0];
            $data["km_install"] = @$installation->km_install;
            $data["check_km"] = @$checking->check_km;
            $data["remain_tread_depth"] = @$checking->remain_tread_depth;
        } else {
            $data["tire_position"] = @$this->tire_positions->where(["is_deleted" => 0, "id" => $installation->tire_position_id])->findAll()[0];
            $data["km_install"] = @$installation->km_install;
            $data["check_km"] = 0;
            $data["remain_tread_depth"] = @$installation->original_tread_depth;
        }
        echo json_encode($data);
    }
}
