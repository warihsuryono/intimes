<?php

namespace App\Models;

use CodeIgniter\Model;

class m_installation_picture extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'installation_pictures';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
