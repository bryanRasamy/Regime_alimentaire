<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeUserModel extends Model
{
    protected $table = 'code_user';
    protected $primaryKey = 'id_code_user';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_code', 'id_user', 'date'];
}
