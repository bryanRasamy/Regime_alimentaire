<?php
namespace App\Models;

use CodeIgniter\Model;

class ActiviteUserModel extends Model{
    protected $table = 'activite_user';
    protected $primaryKey = 'id_activite_user';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_selection',
        'id_activite'
    ];
}