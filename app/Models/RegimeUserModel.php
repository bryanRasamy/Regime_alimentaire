<?php
namespace App\Models;

use CodeIgniter\Model;

class RegimeUserModel extends Model{
    protected $table = 'regime_user';
    protected $primaryKey = 'id_regime_user';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_selection',
        'id_regime'
    ];
}