<?php
namespace App\Models;

use CodeIgniter\Model;

class RegimeSelection extends Model{
    protected $table = 'regime_selection';
    protected $primaryKey = 'id_selection';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_user',
        'objectif',
        'valeur_cible',
        'somme_obtenue'
    ];

    public function getSelectionByUserId($id_user) {
        return $this->where('id_user', $id_user)->first();
    }
}