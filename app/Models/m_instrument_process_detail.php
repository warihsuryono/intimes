<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class m_instrument_process_detail extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'instrument_process_details';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
