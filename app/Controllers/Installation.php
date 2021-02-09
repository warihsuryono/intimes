<?php

namespace App\Controllers;

use App\Models\m_installation;
use App\Models\m_tire_position;
use App\Models\m_tire_type;

class Installation extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $installations;
    protected $tire_positions;
    protected $tire_types;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "installations";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
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
        return $data;
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Installation";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["spk_no"]) && $_GET["spk_no"] != "")
            $wherclause .= "AND spk_no LIKE '%" . $_GET["spk_no"] . "%'";

        if (isset($_GET["spk_at"]) && $_GET["spk_at"] != "")
            $wherclause .= "AND spk_at = '" . $_GET["spk_at"] . "'";

        if (isset($_GET["installed_at"]) && $_GET["installed_at"] != "")
            $wherclause .= "AND installed_at = '" . $_GET["installed_at"] . "'";

        if (isset($_GET["vehicle_registration_plate"]) && $_GET["vehicle_registration_plate"] != "")
            $wherclause .= "AND vehicle_registration_plate LIKE '%" . $_GET["vehicle_registration_plate"] . "%'";

        if (isset($_GET["tire_qr_code"]) && $_GET["tire_qr_code"] != "")
            $wherclause .= "AND tire_qr_code LIKE '%" . $_GET["tire_qr_code"] . "%'";

        if (isset($_GET["tire_is_retread"]) && $_GET["tire_is_retread"] != "")
            $wherclause .= "AND tire_is_retread = '" . $_GET["tire_is_retread"] . "'";

        if ($installations = $this->installations->where($wherclause)->findAll(MAX_ROW, $startrow)) {
            $numrow = count($this->installations->where($wherclause)->findAll());
            foreach ($installations as $installation) {
                $installation_detail[$installation->id]["tire_position"] = @$this->tire_positions->where("id", $installation->tire_position_id)->findAll()[0];
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["installations"] = $installations;
        $data["installation_detail"] = @$installation_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('installations/v_list');
        echo view('v_footer');
    }

    public function saving_data($mode)
    {
        if ($mode == "add") {
            $data = [
                "tire_id"                       => @$_POST["tire_id"],
                "tire_qr_code"                  => @$_POST["tire_qr_code"],
            ];
        }
        $data = [
            "spk_no"                        => @$_POST["spk_no"],
            "spk_at"                        => @$_POST["spk_at"],
            "po_price"                      => @$_POST["po_price"],
            "installed_at"                  => @$_POST["installed_at"],
            "vehicle_id"                    => @$_POST["vehicle_id"],
            "vehicle_registration_plate"    => @$_POST["vehicle_registration_plate"],
            "tire_position_id"              => @$_POST["tire_position_id"],
            "tire_type_id "                 => @$_POST["tire_type_id"],
            "km_install"                    => @$_POST["km_install"],
            "original_tread_depth"          => @$_POST["original_tread_depth"],
            "is_flap"                       => @$_POST["is_flap"],
            "flap_price"                    => @$_POST["flap_price"],
            "is_tube"                       => @$_POST["is_tube"],
            "tube_price"                    => @$_POST["tube_price"],
        ];

        return $data;
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $installation = $this->saving_data("add");
            $installation = $installation + $this->created_values() + $this->updated_values();
            if ($this->installations->save($installation)) {
                $id = $this->installations->insertID();
                $this->session->setFlashdata("flash_message", ["success", "Success adding Installation"]);
                return redirect()->to(base_url() . '/installation/edit/' . $id);
            } else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding Installation"]);
        }

        $data["__modulename"] = "Add Installation";
        $data["__mode"] = "add";
        $data["tire_positions"] = $this->tire_positions->where("is_deleted", "0")->findAll();
        $data["tire_types"] = $this->tire_types->where("is_deleted", "0")->findAll();
        $data["installations_office_only"] = false;
        $data = $data + $this->common();
        $data = $data + $this->get_reference_data();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('installations/v_edit');
        echo view('v_footer');
        echo view('installations/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $installation = $this->saving_data("edit");
            $installation = $installation + $this->updated_values();
            if ($this->installations->update($id, $installation)) {
                $this->session->setFlashdata("flash_message", ["success", "Success editing Installation"]);
                return redirect()->to(base_url() . '/installation/edit/' . $id);
            } else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing Installation"]);
        }

        $data["__modulename"] = "Edit Installation";
        $data["__mode"] = "edit";
        $data["tire_positions"] = $this->tire_positions->where("is_deleted", "0")->findAll();
        $data["installation"] = $this->installations->where("is_deleted", "0")->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('installations/v_edit');
        echo view('v_footer');
        echo view('installations/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->installations->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting installation"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting installation"]);
        return redirect()->to(base_url() . '/installations');
    }

    public function get_item($id)
    {
        return json_encode($this->installations->where("is_deleted", 0)->find([$id]));
    }

    public function get_item_by_qrcode($qrcode)
    {
        $installation = $this->installations->where(["is_deleted" => 0, "tire_qr_code" => $qrcode])->findAll()[0];
        $installation->tire_position = @$this->tire_positions->where("id", $installation->tire_position_id)->findAll()[0];
        $installation->spk_at = $this->format_tanggal($installation->spk_at);
        $installation->installed_at = $this->format_tanggal($installation->installed_at);
        return json_encode($installation);
    }

    public function subwindow()
    {
        $wherclause = "is_deleted = '0'";

        if (isset($_GET["keyword"]) && $_GET["keyword"] != "") {
            $wherclause .= "AND (registration_plate LIKE '%" . $_GET["keyword"] . "%'";
            $wherclause .= "OR model LIKE '%" . $_GET["keyword"] . "%')";
        }

        $installations = $this->installations->where($wherclause)->findAll(LIMIT_SUBWINDOW, 0);

        $data["installations"]       = @$installations;
        $data                       = $data + $this->common();
        echo view('installations/v_subwindow', $data);
    }
}
