<?php

namespace App\Models;

use CodeIgniter\Model;

class m_checking_picture extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'checking_pictures';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
