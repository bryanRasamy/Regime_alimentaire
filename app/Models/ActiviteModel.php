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
        'duree_jours',
        'id_niveau'
    ];

    protected $validationRules = [
        'id_sport' => 'required|integer|is_not_unique[sport.id_sport]',
        'id_objectif' => 'required|integer|is_not_unique[objectif.id_objectif]',
        'description' => 'required|min_length[5]',
        'variation_poids' => 'required|decimal',
        'duree_jours' => 'required|integer',
        'id_niveau' => 'required|integer|is_not_unique[niveau_intensite.id_niveau]'
    ];

    protected $validationMessages = [
        'id_sport' => [
            'required' => 'Le sport est obligatoire.',
            'integer' => 'Le sport doit etre un entier.',
            'is_not_unique' => 'Le sport selectionne est invalide.',
        ],
        'id_objectif' => [
            'required' => 'L objectif est obligatoire.',
            'integer' => 'L objectif doit etre un entier.',
            'is_not_unique' => 'L objectif selectionne est invalide.',
        ],
        'description' => [
            'required' => 'La description est obligatoire.',
            'min_length' => 'La description doit contenir au moins 5 caracteres.',
        ],
        'variation_poids' => [
            'required' => 'La variation de poids est obligatoire.',
            'decimal' => 'La variation de poids doit etre un nombre decimal.',
        ],
        'duree_jours' => [
            'required' => 'La duree est obligatoire.',
            'integer' => 'La duree doit etre un entier.',
        ],
        'id_niveau' => [
            'required' => 'Le niveau est obligatoire.',
            'integer' => 'Le niveau doit etre un entier.',
            'is_not_unique' => 'Le niveau selectionne est invalide.',
        ],
    ];
}