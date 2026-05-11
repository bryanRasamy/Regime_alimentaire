<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeModel extends Model
{
    protected $table = 'code';
    protected $primaryKey = 'id_code';
    protected $allowedFields = ['libelle', 'montant', 'date_expiration'];
}
