<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class m_item_costing extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'item_costings';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
