<?php

namespace App\Models;

use CodeIgniter\Model;

class m_checking_detail extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'checking_details';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
