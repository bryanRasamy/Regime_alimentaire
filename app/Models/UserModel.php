<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'nom',
        'email',
        'password',
        'id_statut',
        'porte_monnaie',
        'option_gold'
    ];

    protected $validationRules = [
        'nom' => 'required|min_length[3]',
        'email' => 'required|valid_email|is_unique[user.email]',
        'password' => 'required|min_length[6]',
        'id_statut' => 'required|integer|in_list[1,2]',
        'porte_monnaie' => 'required|decimal[10,2]',
        'option_gold' => 'required|decimal[5,2]'
    ];

    protected $validationMessages = [
        'nom' => [
            'required' => 'Le nom est obligatoire.',
            'min_length' => 'Le nom doit contenir au moins 3 caractères.',
        ],
        'email' => [
            'required' => 'L\'email est obligatoire.',
            'valid_email' => 'L\'email doit être valide.',
            'is_unique' => 'Cet email est déjà utilisé.',
        ],
        'password' => [
            'required' => 'Le mot de passe est obligatoire.',
            'min_length' => 'Le mot de passe doit contenir au moins 6 caractères.',
        ],
        'id_statut' => [
            'required' => 'Le statut est obligatoire.',
            'integer' => 'Le statut doit être un nombre entier.',
            'in_list' => 'Le statut doit être 1 ou 2.',
        ],
        'porte_monnaie' => [
            'required' => 'Le porte-monnaie est obligatoire.',
            'decimal' => 'Le porte-monnaie doit être un nombre décimal avec 2 décimales.',
        ],
        'option_gold' => [
            'required' => 'L\'option gold est obligatoire.',
            'decimal' => 'L\'option gold doit être un nombre décimal avec 2 décimales.',
        ],
    ];
}

