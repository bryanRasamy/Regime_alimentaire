<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeModel extends Model
{
    protected $table = 'code';
    protected $primaryKey = 'id_code';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['libelle', 'montant', 'date_expiration'];

    protected $validationRules = [
        'libelle' => 'required|min_length[2]|max_length[50]',
        'montant' => 'required|decimal',
        'date_expiration' => 'required|valid_date',
    ];

    protected $validationMessages = [
        'libelle' => [
            'required' => 'Le libelle du code est obligatoire.',
            'min_length' => 'Le libelle doit contenir au moins 2 caracteres.',
            'max_length' => 'Le libelle ne doit pas depasser 50 caracteres.',
        ],
        'montant' => [
            'required' => 'Le montant est obligatoire.',
            'decimal' => 'Le montant doit etre un nombre decimal.',
        ],
        'date_expiration' => [
            'required' => 'La date d expiration est obligatoire.',
            'valid_date' => 'La date d expiration est invalide.',
        ],
    ];
}
