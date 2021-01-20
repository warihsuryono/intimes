<?php

namespace App\Controllers;

class Qr_reader extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->route_name = "qrcode";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
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
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('qr_readers/v_menu');
        echo view('v_footer');
    }
}
