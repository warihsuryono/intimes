<?php

namespace App\Controllers;

class Qr_reader extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo view('v_qrcode_reader');
    }

    public function qrcode_menu($qrCodeMessage)
    {
        echo $qrCodeMessage;
    }
}
