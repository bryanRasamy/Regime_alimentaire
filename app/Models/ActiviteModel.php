<?php
namespace App\Models;

use CodeIgniter\Model;

class ActiviteModel extends Model {
    protected $table      = 'activite_sportive';
    protected $primaryKey = 'id_activite';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_sport',
        'id_objectif',
        'description',
        'variation_poids',
        'id_niveau'
    ];
}