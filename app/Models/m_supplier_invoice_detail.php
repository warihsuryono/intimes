<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class m_supplier_invoice_detail extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'supplier_invoice_details';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
