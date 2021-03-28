<?php
    namespace App\Controllers;

use App\Models\m_mounting;

class Mounting extends BaseController{
        protected $menu_ids;
        protected $mountings;
        public function __construct()
        {
            parent::__construct();
            $this->route_name = "mountings";
            $this->menu_ids = $this->get_menu_ids($this->route_name);
            $this->mountings =  new m_mounting();
        }
    }