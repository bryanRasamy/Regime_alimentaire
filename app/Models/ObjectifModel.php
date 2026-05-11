<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectifModel extends Model
{
    protected $table = 'objectif';
    protected $primaryKey = 'id_objectif';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['libelle'];

    protected $validationRules = [
        'libelle' => 'required|min_length[2]|max_length[50]'
    ];

    protected $validationMessages = [
        'libelle' => [
            'required' => 'Le libelle est obligatoire.',
            'min_length' => 'Le libelle doit contenir au moins 2 caracteres.',
            'max_length' => 'Le libelle ne doit pas depasser 50 caracteres.',
        ],
    ];
}
