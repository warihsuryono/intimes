<?php

namespace App\Models;

use CodeIgniter\Model;

class m_flap_brand extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'flap_brands';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
