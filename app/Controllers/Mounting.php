<?php

namespace App\Controllers;

use App\Models\m_checking;
use App\Models\m_checking_detail;
use App\Models\m_customer;
use App\Models\m_mounting;
use App\Models\m_demounting;
use App\Models\m_mounting_detail;
use App\Models\m_demounting_detail;
use App\Models\m_mounting_photo;
use App\Models\m_demounting_photo;
use App\Models\m_vehicle;
use App\Models\m_vehicle_brand;
use App\Models\m_vehicle_type;

class Mounting extends BaseController
{
    protected $menu_ids;
    protected $mountings;
    protected $demountings;
    protected $mounting_details;
    protected $demounting_details;
    protected $mounting_photos;
    protected $demounting_photos;
    protected $vehicles;
    protected $vehicle_types;
    protected $vehicle_brands;
    protected $customers;
    protected $checkings;
    protected $checking_details;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "mountings";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->mountings =  new m_mounting();
        $this->demountings =  new m_demounting();
        $this->mounting_details =  new m_mounting_detail();
        $this->demounting_details =  new m_demounting_detail();
        $this->mounting_photos =  new m_mounting_photo();
        $this->demounting_photos =  new m_demounting_photo();
        $this->vehicles =  new m_vehicle();
        $this->vehicle_types =  new m_vehicle_type();
        $this->vehicle_brands =  new m_vehicle_brand();
        $this->customers =  new m_customer();
        $this->checkings =  new m_checking();
        $this->checking_details =  new m_checking_detail();
    }

    public function get_reference_data($id = 0)
    {
        $data = [];
        @$data["yesnooption"][0]->id = 0;
        @$data["yesnooption"][0]->name = "No";
        @$data["yesnooption"][1]->id = 1;
        @$data["yesnooption"][1]->name = "Yes";

        $data["tire_positions"] = $this->tire_positions->where("is_deleted", "0")->findAll();
        $data["tire_sizes"] = $this->tire_sizes->where("is_deleted", "0")->findAll();
        $data["tire_brands"] = $this->tire_brands->where("is_deleted", "0")->findAll();
        $data["tire_types"] = $this->tire_types->where("is_deleted", "0")->findAll();
        $data["tire_patterns"] = $this->tire_patterns->where("is_deleted", "0")->findAll();

        if ($this->request->getPost("tire_position_id"))
            $data["tire_position"] = $this->tire_positions->where(["is_deleted" => "0", "id" => $this->request->getPost("tire_position_id")])->findAll()[0];

        return $data;
    }

    public function get_saved_data($id)
    {
        $data["mounting"] = @$this->mountings->where(["is_deleted" => 0, "id" => $id])->findAll()[0];
        $data["demounting"] = @$this->demountings->where(["is_deleted" => 0, "mounting_id" => $id])->findAll()[0];
        $data["mounting_details"] = @$this->mounting_details->where(["is_deleted" => 0, "mounting_id" => $id])->findAll();
        $data["demounting_details"] = @$this->demounting_details->where(["is_deleted" => 0, "demounting_id" => @$data["demounting"]->id])->findAll();
        $data["vehicle"] = $this->vehicles->where(["is_deleted" => "0", "id" => $data["mounting"]->vehicle_id])->findAll()[0];
        $data["tires_map"] = $this->get_tires_map($data["vehicle"]->vehicle_type_id);
        $data["vehicle_type"] = $this->vehicle_types->where(["is_deleted" => "0", "id" => $data["vehicle"]->vehicle_type_id])->findAll()[0]->name;
        $data["vehicle_brand"] = $this->vehicle_brands->where(["is_deleted" => "0", "id" => $data["vehicle"]->vehicle_brand_id])->findAll()[0]->name;
        if (isset($data["mounting_details"]))
            foreach ($data["mounting_details"] as $key => $mounting_detail) {
                $data["mounting_details"][$key]->tire_type = @$this->tire_types->where(["is_deleted" => 0, "id" => $mounting_detail->tire_type_id])->findAll()[0];
                $data["mounting_details"][$key]->tire_position = @$this->tire_positions->where(["is_deleted" => 0, "id" => $mounting_detail->tire_position_id])->findAll()[0];
            }

        if (isset($data["demounting_details"]))
            foreach ($data["demounting_details"] as $key => $demounting_detail) {
                $data["demounting_details"][$key]->tire_type = @$this->tire_types->where(["is_deleted" => 0, "id" => $demounting_detail->tire_type_id])->findAll()[0];
                $data["demounting_details"][$key]->tire_position = @$this->tire_positions->where(["is_deleted" => 0, "id" => $demounting_detail->tire_position_id])->findAll()[0];
            }

        return $data;
    }

    public function index($mode = "")
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        if ($mode == "")
            $data["__modulename"] = "Mounting";
        if ($mode == "mounted")
            $data["__modulename"] = "Checking";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["customer_id"]) && $_GET["customer_id"] != "")
            $wherclause .= " AND customer_id = '" . $_GET["customer_id"] . "'";

        if (isset($_GET["spk_no"]) && $_GET["spk_no"] != "")
            $wherclause .= " AND spk_no LIKE '%" . $_GET["spk_no"] . "%'";

        if (isset($_GET["spk_at"]) && $_GET["spk_at"] != "")
            $wherclause .= " AND spk_at = '" . $_GET["spk_at"] . "'";

        if (isset($_GET["mounting_at"]) && $_GET["mounting_at"] != "")
            $wherclause .= " AND mounting_at = '" . $_GET["mounting_at"] . "'";

        if (isset($_GET["customer_name"]) && $_GET["customer_name"] != "")
            $wherclause .= " AND customer_name LIKE '%" . $_GET["customer_name"] . "%'";

        if (isset($_GET["vehicle_registration_plate"]) && $_GET["vehicle_registration_plate"] != "")
            $wherclause .= " AND vehicle_registration_plate LIKE '%" . $_GET["vehicle_registration_plate"] . "%'";

        if (isset($_GET["code"]) && $_GET["code"] != "")
            $wherclause .= " AND id IN (SELECT mounting_id FROM mounting_details WHERE code LIKE '%" . $_GET["code"] . "%')";

        if ($mode == "mounted")
            if ($mountings = $this->mountings->where($wherclause)->findAll(MAX_ROW, $startrow)) {
                $numrow = count($this->mountings->where($wherclause)->findAll());
                foreach ($mountings as $mounting) {
                    $mounting_detail[$mounting->id]["mounting_details"] = @$this->mounting_details->where("mounting_id", $mounting->id)->findAll();
                    $mounting_detail[$mounting->id]["customer"] = @$this->customers->where("id", $mounting->customer_id)->findAll()[0];
                    $data["checking"][$mounting->id] = @$this->checkings->where(["is_deleted" => 0, "mounting_id" => $mounting->id])->orderBy("checking_at DESC")->findAll()[0];
                    if (@$data["checking"][$mounting->id]->id > 0)
                        $data["checking_detail"][$mounting->id] = @$this->checking_details->where(["is_deleted" => 0, "checking_id" => @$data["checking"][$mounting->id]->id])->orderBy("id DESC")->findAll()[0];
                }
            } else {
                $numrow = 0;
            }
        if ($mode == "")
            if ($mounting_details = $this->mounting_details->where("mounting_id IN (SELECT id FROM mountings WHERE " . $wherclause . ")")->findAll(MAX_ROW, $startrow)) {
                $numrow = count($this->mounting_details->where("mounting_id IN (SELECT id FROM mountings WHERE " . $wherclause . ")")->findAll());
                foreach ($mounting_details as $_mounting_detail) {
                    $mountings[$_mounting_detail->mounting_id] = @$this->mountings->where("id", $_mounting_detail->mounting_id)->findAll()[0];
                    $mounting_detail[$_mounting_detail->id]["tire_position"] = @$this->tire_positions->where("id", $_mounting_detail->tire_position_id)->findAll()[0];
                    $mounting_detail[$_mounting_detail->id]["tire_size"] = @$this->tire_sizes->where("id", $_mounting_detail->tire_size_id)->findAll()[0];
                    $mounting_detail[$_mounting_detail->id]["tire_brand"] = @$this->tire_brands->where("id", $_mounting_detail->tire_brand_id)->findAll()[0];
                    $mounting_detail[$_mounting_detail->id]["tire_type"] = @$this->tire_types->where("id", $_mounting_detail->tire_type_id)->findAll()[0];
                    $mounting_detail[$_mounting_detail->id]["tire_pattern"] = @$this->tire_patterns->where("id", $_mounting_detail->tire_pattern_id)->findAll()[0];
                }
            } else {
                $numrow = 0;
            }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["mountings"] = @$mountings;
        $data["mounting_details"] = @$mounting_details;
        $data["mounting_detail"] = @$mounting_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        if ($mode == "")
            echo view('mountings/v_list');
        if ($mode == "mounted")
            echo view('mountings/v_mounted');
        echo view('v_footer');
    }

    public function saving_data($masterdetail = "master", $id = null)
    {
        if ($masterdetail == "master" || $masterdetail == "demounting") {
            if ($id > 0) $mounting = @$this->mountings->where(["is_deleted" => 0, "id" => $id])->findAll()[0];

            if ($masterdetail == "master") $vehicle_id = $this->request->getPost("vehicle_id");
            else $vehicle_id = $mounting->vehicle_id;

            $vehicle = @$this->vehicles->where(["is_deleted" => 0, "id" => $vehicle_id])->findAll()[0];
            $customer = @$this->customers->where(["is_deleted" => 0, "id" => $vehicle->customer_id])->findAll()[0];
            $notes = $this->request->getPost("notes");
            if ($notes == "") $notes = $mounting->notes;

            $return  = [
                "customer_id"                   => @$customer->id,
                "customer_name"                 => @$customer->company_name,
                "vehicle_id"                    => $vehicle_id,
                "vehicle_registration_plate"    => $vehicle->registration_plate,
                "notes"                         => $notes,
            ];

            if ($masterdetail == "master")
                $return = $return + [
                    "spk_no"                    => $this->request->getPost("spk_no"),
                    "spk_at"                    => $this->request->getPost("spk_at"),
                    "mounting_at"               => $this->request->getPost("mounting_at"),
                ];

            if ($masterdetail == "demounting") {
                $return = $return + [
                    "mounting_id"               => $id,
                    "spk_no"                    => @$mounting->spk_no,
                    "spk_at"                    => @$mounting->spk_at,
                    "demounting_at"             => @$mounting->mounting_at,
                ];
            }

            return $return;
        }

        if ($masterdetail == "detail" || $masterdetail == "demounting_detail") {
            $return =  [
                "tire_id"           => $this->request->getPost("tire_id"),
                "code"              => $this->request->getPost("tire_qr_code"),
                "tire_type_id"      => $this->request->getPost("tire_type_id"),
                "tire_position_id"  => $this->request->getPost("tire_position_id"),
                "tire_size_id"      => $this->request->getPost("tire_size_id"),
                "tire_brand_id"     => $this->request->getPost("tire_brand_id"),
                "tire_pattern_id"   => $this->request->getPost("tire_pattern_id"),
                "km"                => $this->request->getPost("km"),
                "remark"            => $this->request->getPost("remark"),
            ];

            if ($masterdetail == "detail")
                $return = $return +  [
                    "mounting_id"       => $id,
                    "otd"               => $this->request->getPost("otd"),
                    "price"             => 0,
                ];

            if ($masterdetail == "demounting_detail")
                $return = $return +  [
                    "demounting_id"       => $id,
                    "rtd1"              => $this->request->getPost("rtd1"),
                    "rtd2"              => $this->request->getPost("rtd2"),
                    "rtd3"              => $this->request->getPost("rtd3"),
                    "rtd4"              => $this->request->getPost("rtd4"),
                ];

            return $return;
        }
    }

    public function add($id = 0, $page = 1)
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if ($this->request->getPost("saving_page_1")) {
            //cari kesamaan data
            $identic_id = @$this->mountings->where([
                "is_deleted" => 0,
                "spk_no" => $this->request->getPost("spk_no"),
                "mounting_at" => $this->request->getPost("mounting_at"),
                "vehicle_id" => $this->request->getPost("vehicle_id")
            ])->findAll()[0]->id;
            if (@$identic_id > 0) {
                return redirect()->to(base_url() . '/mounting/add/' . $identic_id);
                exit();
            }
            $mounting = $this->saving_data();
            $mounting = $mounting + $this->created_values() + $this->updated_values();
            if ($this->mountings->save($mounting)) {
                $id = $this->mountings->insertID();
                return redirect()->to(base_url() . '/mounting/add/' . $id);
            } else
                $this->session->setFlashdata("flash_message", ["error", "Failed adding Mounting"]);
        }

        if ($this->request->getPost("saving_page_2")) {
            if ($this->request->getPost("tire_position_id") == "") {
                $this->session->setFlashdata("flash_message", ["error", "Please choose tire position"]);
                return redirect()->to(base_url() . '/mounting/add/' . $id);
            }
            if ($this->request->getPost("km") == "") {
                $this->session->setFlashdata("flash_message", ["error", "Please fill km"]);
                return redirect()->to(base_url() . '/mounting/add/' . $id);
            }

            if ($this->request->getPost("save_mode") == "mounting") {
                $mounting_detail = $this->saving_data("detail", $id) + $this->created_values() + $this->updated_values();
                if ($this->mounting_details->save($mounting_detail))
                    return redirect()->to(base_url() . '/mounting/add/' . $id);
                else
                    $this->session->setFlashdata("flash_message", ["error", "Failed adding Mounting detail"]);
            }

            if ($this->request->getPost("save_mode") == "demounting") {
                $demounting = @$this->demountings->where(["is_deleted" => 0, "mounting_id" => $id])->findAll()[0];
                if (@$demounting->id > 0)
                    $demounting_id = $demounting->id;
                else {
                    $this->demountings->save($this->saving_data("demounting", $id) + $this->created_values() + $this->updated_values());
                    $demounting_id = $this->demountings->insertID();
                    $demounting = @$this->demountings->find($demounting_id);
                }

                $demounting_detail = $this->saving_data("demounting_detail", $demounting_id) + $this->created_values() + $this->updated_values();
                if ($this->demounting_details->save($demounting_detail))
                    return redirect()->to(base_url() . '/mounting/add/' . $id);
                else
                    $this->session->setFlashdata("flash_message", ["error", "Failed adding Demounting detail"]);
            }
        }

        $data["__modulename"] = "Mounting";
        $data["__mode"] = "add";
        if ($id > 0 && $page == 1) $page = 2;
        $data = $data + $this->common();
        $data = $data + $this->get_reference_data($id);
        if ($id > 0)
            $data = $data + $this->get_saved_data($id);

        echo view('v_header', $data);
        echo view('v_menu');
        if ($page == 1)
            echo view('mountings/v_edit1');
        if ($page == 2)
            echo view('mountings/v_edit2');
        echo view('v_footer');
        echo view('mountings/v_js');
    }

    public function photos($id, $mode = "mounting")
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);

        $data["__modulename"] = "Take Photos";
        $data["__mode"] = "takephotos";
        $data["_mode"] = $mode;
        $data["id"] = $id;
        if ($mode == "mounting") {
            $data["mounting_detail"] = $this->mounting_details->where(["is_deleted" => 0])->find($id);
            $data["mountings"] = $this->mountings->where("is_deleted", "0")->find($data["mounting_detail"]->mounting_id);
            $data["mounting_photos"] = $this->mounting_photos->where(["is_deleted" => 0, "mounting_detail_id" => $id])->findAll();
        }
        if ($mode == "demounting") {
            $data["demounting_detail"] = $this->demounting_details->where(["is_deleted" => 0])->find($id);
            $data["demountings"] = $this->demountings->where("is_deleted", "0")->find($data["demounting_detail"]->demounting_id);
            $data["demounting_photos"] = $this->demounting_photos->where(["is_deleted" => 0, "demounting_detail_id" => $id])->findAll();
            $data["mountings"] = $this->mountings->where("is_deleted", "0")->find($data["demountings"]->mounting_id);
        }
        $data = $data + $this->common();
        $data = $data + $this->get_reference_data();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('mountings/v_photos');
        echo view('v_footer');
    }

    public function put_photo($id, $mode = "mounting")
    {
        if ($mode == "mounting")
            $mounting_detail = $this->mounting_details->where(["is_deleted" => 0])->find($id);
        if ($mode == "demounting")
            $demounting_detail = $this->demounting_details->where(["is_deleted" => 0])->find($id);

        $img = file_get_contents('php://input');
        $img = explode(";base64,", $img);
        $ext = explode("/", $img[0])[1];
        $img = base64_decode(str_replace(' ', '+', $img[1]));
        $filename = date("ymdhis") . "_" . rand(0, 9) . rand(0, 9) . rand(0, 9) . "_" . $id . "." . $ext;
        if (file_put_contents('dist/upload/' . $mode . 's/' . $filename, $img)) {
            $this->resizeImage('dist/upload/' . $mode . 's/' . $filename);
            if ($mode == "mounting") {
                $data = ["mounting_id" => $mounting_detail->mounting_id, "mounting_detail_id" => $id, "tire_type_id" => $mounting_detail->tire_type_id, "filename" => $filename]  + $this->created_values() + $this->updated_values();
                $this->mounting_photos->save($data);
                echo json_encode($this->mounting_photos->where(["is_deleted" => 0, "mounting_detail_id" => $id])->findAll());
            }
            if ($mode == "demounting") {
                $data = ["demounting_id" => $demounting_detail->demounting_id, "demounting_detail_id" => $id, "tire_type_id" => $demounting_detail->tire_type_id, "filename" => $filename]  + $this->created_values() + $this->updated_values();
                $this->demounting_photos->save($data);
                echo json_encode($this->demounting_photos->where(["is_deleted" => 0, "demounting_detail_id" => $id])->findAll());
            }
        } else {
            echo "0";
        }
    }

    public function delete_detail($id, $mode = "mounting")
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if ($mode == "mounting") {
            $mounting_id = @$this->mounting_details->where(["is_deleted" => 0])->find($id)->mounting_id;
            if ($this->mounting_details->update($id, ["is_deleted " => 1] + $this->deleted_values()))
                $this->session->setFlashdata("flash_message", ["success", "Success deleting mounting"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Success deleting mounting"]);
        }

        if ($mode == "demounting") {
            $demounting_id = @$this->demounting_details->where(["is_deleted" => 0])->find($id)->demounting_id;
            $mounting_id = @$this->demountings->where(["is_deleted" => 0])->find($demounting_id)->mounting_id;
            if ($this->demounting_details->update($id, ["is_deleted " => 1] + $this->deleted_values()))
                $this->session->setFlashdata("flash_message", ["success", "Success deleting demounting"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Success deleting demounting"]);
        }

        return redirect()->to(base_url() . '/mounting/add/' . $mounting_id);
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->mountings->update($id, ["is_deleted " => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting mounting"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting mounting"]);
        return redirect()->to(base_url() . '/mountings');
    }

    public function delete_photo($mode = "mounting")
    {
        $filename = file_get_contents('php://input');
        return unlink('dist/upload/' . $mode . '/' . basename($filename));
    }

    public function get_tires_map($vehicle_type_id)
    {
        $vehicle_type = @$this->vehicle_types->where(["is_deleted" => 0, "id" => $vehicle_type_id])->findAll()[0];
        if (@$vehicle_type->tire_position_ids != "") {
            $tire_positions = @$this->tire_positions->where("is_deleted", 0)->where("id IN (" . @$vehicle_type->tire_position_ids . ")")->findAll();
            $tires_map = "";
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
                    $tires_map .= "<div class='btn btn-info btn-tire' id=\"tires_map_" . $tire_position->id . "\" style='" . $tire_position->styles . "' onclick=\"tire_position_clicked('" . $tire_position->id . "');\"></div>";
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
