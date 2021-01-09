<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class m_calibration_certificate_detail extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'calibration_certificate_details';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
