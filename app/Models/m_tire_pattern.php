<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class m_tire_pattern extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'tire_patterns';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
