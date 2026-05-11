<?php

namespace App\Models;

use CodeIgniter\Model;

class NiveauIntensiteModel extends Model
{
    protected $table = 'niveau_intensite';
    protected $primaryKey = 'id_niveau';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['libelle'];
}
