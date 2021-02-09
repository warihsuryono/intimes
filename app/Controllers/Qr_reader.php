<?php

namespace App\Controllers;

use App\Models\m_installation;

class Qr_reader extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $installations;
    public function __construct()
    {
        parent::__construct();
        $this->route_name = "qrcode";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->installations =  new m_installation();
    }

    public function index()
    {
        echo view('v_qrcode_reader');
    }

    public function qrcode_menu($qrcode)
    {
        $this->privilege_check($this->menu_ids);
        $data["__modulename"] = "QR Code Result";
        $data["qrcode"] = $qrcode;
        $data["installation"] = @$this->installations->where(["is_deleted" => 0, "tire_qr_code" => $qrcode])->orderBy("installed_at DESC")->findAll()[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('qr_readers/v_menu');
        echo view('v_footer');
    }
}
