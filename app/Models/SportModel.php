<?php

namespace App\Models;

use CodeIgniter\Model;

class SportModel extends Model
{
    protected $table = 'sport';
    protected $primaryKey = 'id_sport';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['libelle'];
}
