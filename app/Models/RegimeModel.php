<?php
namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model{
    protected $table = 'regime';
    protected $primaryKey = 'id_regime';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'nom',
        'description',
        'viande',
        'poisson',
        'volaille',
        'id_objectif',
        'duree_jours',
        'variation_poids',
        'prix'
    ];

    protected $validationRules = [
        'nom' => 'required|min_length[3]',
        'description' => 'required|min_length[10]',
        'viande' => 'required|numeric',
        'poisson' => 'required|numeric',
        'volaille' => 'required|numeric',
        'id_objectif' => 'required|integer|is_not_unique[objectif.id_objectif]',
        'duree_jours' => 'required|integer',
        'variation_poids' => 'required|numeric',
        'prix' => 'required|decimal',
    ];

    protected $validationMessages = [
        'nom' => [
            'required' => 'Le nom du régime est obligatoire.',
            'min_length' => 'Le nom du régime doit contenir au moins 3 caractères.',
        ],
        'description' => [
            'required' => 'La description du régime est obligatoire.',
            'min_length' => 'La description du régime doit contenir au moins 10 caractères.',
        ],
        'viande' => [
            'required' => 'La quantité de viande est obligatoire.',
            'numeric' => "La quantité de viande doit être un nombre.",
        ],
        'poisson' => [
            'required' => 'La quantité de poisson est obligatoire.',
            'numeric' => "La quantité de poisson doit être un nombre.",
        ],
        'volaille' => [
            'required' => 'La quantité de volaille est obligatoire.',
            'numeric' => "La quantité de volaille doit être un nombre.",
        ],
        'id_objectif' => [
            'required' => "L'objectif du régime est obligatoire.",
            'integer' => "L'identifiant de l'objectif doit être un nombre entier.",
            'is_not_unique' => "L'objectif sélectionné n'existe pas.",
        ],
        'variation_poids' => [
            'required' => "La variation de poids attendue est obligatoire.",
            'numeric' => "La variation de poids doit être un nombre.",
        ],
        'prix' => [
            'required' => "Le prix du régime est obligatoire.",
            'decimal' => "Le prix du régime doit être un nombre décimal.",
        ],
    ];

    public function getRegimesByObjectif($idObjectif){
        return $this->where('id_objectif', $idObjectif)->findAll();
    }

    public function getListe(){
        $liste = [];

        $activiteModel = new ActiviteModel();
        $objectif = session()->get('objectif');

        $regimes = [];
        $activite = [];

        if($objectif['type'] === 'augmenter_poids'){
            $regimes = $this->where('id_objectif', 2)->findAll();
            $activite = $activiteModel->where('id_objectif', 2)->findAll();
        
        } else if($objectif['type'] === 'reduire_poids'){
            $regimes = $this->where('id_objectif', 1)->findAll();
            $activite = $activiteModel->where('id_objectif', 1)->findAll();
        
        }

        foreach($regimes as $regime){
            $poids = (int) round(abs($regime['variation_poids']) * 1000); //poids en grammes (valeur absolue)
            $liste[] = [
                'id' => $regime['id_regime'],
                'nom' => $regime['nom'],
                'poids' => $poids,
                'type' => 'regime'
            ];
        }

        foreach($activite as $activite){
            $poids = (int) round(abs($activite['variation_poids']) * 1000); //poids en grammes (valeur absolue)
            $liste[] = [
                'id' => $activite['id_activite'],
                'nom' => $activite['description'],
                'poids' => $poids,
                'type' => 'activite'
            ];
        }

        return $liste;
    }

    public function calculerRegime($liste, $cible){
        $dp = array_fill(0, $cible + 1, false);
        $dp[0] = true;

        $choix = array_fill(0, $cible + 1, null);

        foreach ($liste as $i => $lst) {
            $poids = $lst['poids'];
 
            for ($poidsCible = $cible; $poidsCible >= $poids; $poidsCible--) {
                if (!$dp[$poidsCible] && $dp[$poidsCible - $poids]) {
                    $dp[$poidsCible]   = true;
                    $choix[$poidsCible] = ['item_index' => $i, 'prev' => $poidsCible - $poids];
                }
            }
        }

        $best = 0;
        for ($poidsCible = $cible; $poidsCible >= 0; $poidsCible--) {
            if ($dp[$poidsCible]) { 
                $best = $poidsCible; 
                break; 
            }
        }
 
        if ($best === 0) return [];

        $choisis = [];
        $poidsCible = $best;
        while ($poidsCible > 0 && $choix[$poidsCible] !== null) {
            $i         = $choix[$poidsCible]['item_index'];
            $choisis[] = $liste[$i];
            $poidsCible = $choix[$poidsCible]['prev'];
        }
 
        return $choisis;

    }

    public function sauvegarder($choisis){
        $selectionModel = new RegimeSelection();
        $user = session()->get('user');
        $objectif = session()->get('objectif');

        $sommeGrammes = array_sum(array_column($choisis, 'poids'));
        $somme = $sommeGrammes / 1000; // convertir en kg
        
        $selectionModel->insert([
            'id_user' => $user['id'],
            'objectif' => $objectif['type'],
            'valeur_cible' => $objectif['valeur'],
            'somme_obtenue' => $somme
        ]);

        $idSelection = $selectionModel->getInsertID();

        $regimeUserModel = new RegimeUserModel();
        $activiteUserModel = new ActiviteUserModel();

        foreach($choisis as $choix){
            if($choix['type'] === 'regime'){
                $regimeUserModel->insert([
                    'id_selection' => $idSelection,
                    'id_regime' => $choix['id']
                ]);
            } else if($choix['type'] === 'activite'){
                $activiteUserModel->insert([
                    'id_selection' => $idSelection,
                    'id_activite' => $choix['id']
                ]);
            }
        }

        return $idSelection;
    }
}