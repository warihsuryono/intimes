<?php

namespace App\Models;

use CodeIgniter\Model;

class m_demounting_photo extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'demounting_photos';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
