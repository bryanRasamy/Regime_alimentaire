<?php
namespace App\Models;

use CodeIgniter\Model;

class InfoUserModel extends Model{
    protected $table = 'info_user';
    protected $primaryKey = 'id_info';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_user',
        'genre',
        'taille',
        'poids',
        'IMC',
    ];

    protected $validationRules = [
        'genre' => 'required|in_list[Homme,Femme]',
        'taille' => 'required|decimal',
        'poids' => 'required|decimal',
    ];

    protected $validationMessages = [
        'genre' => [
            'required' => 'Le genre est obligatoire.',
            'in_list' => 'Le genre doit être Homme ou Femme.',
        ],
        'taille' => [
            'required' => 'La taille est obligatoire.',
            'decimal' => 'La taille doit être un nombre décimal.',
        ],
        'poids' => [
            'required' => 'Le poids est obligatoire.',
            'decimal' => 'Le poids doit être un nombre décimal.',
        ],
    ];
}