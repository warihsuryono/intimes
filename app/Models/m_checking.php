<?php

namespace App\Models;

use CodeIgniter\Model;

class m_checking extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'checkings';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
