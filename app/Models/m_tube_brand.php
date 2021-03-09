<?php

namespace App\Models;

use CodeIgniter\Model;

class m_tube_brand extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'tube_brands';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
