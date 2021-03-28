<?php

namespace App\Models;

use CodeIgniter\Model;

class m_mounting extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'mountings';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
