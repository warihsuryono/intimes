<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class m_customer extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}