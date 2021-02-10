<?php

namespace App\Models;

use CodeIgniter\Model;

class m_installation extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'installations';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
