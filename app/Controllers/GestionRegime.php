<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\RegimeSelection;
use App\Models\RegimeUserModel;
use App\Models\ActiviteModel;
use App\Models\ActiviteUserModel;

class GestionRegime extends BaseController{
    public function objectif(){
        $data = [
            'title' => 'Objectif',
        ];

        return view('objectif', $data);
    }

    public function sauvegarderObjectif(){
        $isAjax = $this->request->isAJAX();
        $data = $this->request->getJSON(true) ?? $this->request->getPost();
        $user = session()->get('user');

        if (!$user || !isset($user['id'])) {
            $errorMsg = 'Session expirée. Veuillez vous reconnecter.';
            if ($isAjax) {
                return $this->response
                    ->setStatusCode(401)
                    ->setJSON(['success' => false, 'message' => $errorMsg]);
            }

            return redirect()->to('/')->with('error', $errorMsg);
        }

        $objectif = $data['objectif'] ?? '';
        $objectifValue = $data['objectif_value'] ?? '';

        $allowedObjectives = ['augmenter_poids', 'reduire_poids', 'imc_ideale'];

        if ($objectif === '' || !in_array($objectif, $allowedObjectives, true) || $objectifValue === '' || !is_numeric($objectifValue) || $objectifValue <= 0) {
            $errorMsg = 'Veuillez sélectionner un objectif et une valeur valide.';
            if ($isAjax) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON(['success' => false, 'message' => $errorMsg]);
            }

            return redirect()->back()->withInput()->with('error', $errorMsg);
        }

        session()->set('objectif', [
            'type' => $objectif,
            'valeur' => $objectifValue,
        ]);

        if ($isAjax) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Objectif enregistré avec succès.',
                'redirect' => '/regime/calculer',
            ]);
        }

        return redirect()->to('/regime/calculer')->with('success', 'Objectif enregistré avec succès.');
    }

    public function calculerRegime(){
        $isAjax = $this->request->isAJAX();
        $user = session()->get('user');

        if (!$user || !isset($user['id'])) {
            $errorMsg = 'Session expirée. Veuillez vous reconnecter.';
            if ($isAjax) {
                return $this->response->setStatusCode(401)->setJSON(['success' => false, 'message' => $errorMsg]);
            }
            return redirect()->to('/')->with('error', $errorMsg);
        }
        $objectif = session()->get('objectif');
        if (!$objectif || !isset($objectif['type'], $objectif['valeur'])) {
            $errorMsg = 'Aucun objectif trouvé.';
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => $errorMsg]);
            }
            return redirect()->to('/regime/objectif')->with('error', $errorMsg);
        }

        $val = $objectif['valeur'];

        $regimeModel = new RegimeModel();
        
        $liste = $regimeModel->getListe();
        
        if (empty($liste)) {
            $errorMsg = 'Aucun élément disponible pour cet objectif.';
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => $errorMsg]);
            }
            return redirect()->back()->with('error', $errorMsg);
        }

        $cibleGrammes = (int) round($val * 1000);
        $choisis = $regimeModel->calculerRegime($liste, $cibleGrammes);

        if (empty($choisis)) {
            $errorMsg = 'Impossible de combiner des régimes et activités pour atteindre l objectif.';
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => $errorMsg]);
            }
            return redirect()->back()->with('error', $errorMsg);
        }

        $id_selection = $regimeModel->sauvegarder($choisis);

        if ($isAjax) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Régime et activités calculés et sauvegardés.',
                'selection_id' => $id_selection,
            ]);
        }

        return redirect()->to('/regime')->with('success', 'Régime calculé et sauvegardé.');
    }

    public function afficherRegime(){
        $user = session()->get('user');

        if (!$user || !isset($user['id'])) {
            return redirect()->to('/')->with('error', 'Session expirée.');
        }

        $selectionModel = new RegimeSelection();
        $selection = $selectionModel->where('id_user', $user['id'])
                                    ->orderBy('id_selection', 'DESC')
                                    ->first();

        if (!$selection) {
            return redirect()->to('/regime/objectif')->with('error', 'Aucun programme n\'est défini.');
        }

        $regimeUserModel = new RegimeUserModel();
        $regimes = $regimeUserModel->select('regime.*')
                                   ->join('regime', 'regime.id_regime = regime_user.id_regime')
                                   ->where('regime_user.id_selection', $selection['id_selection'])
                                   ->findAll();

        $activiteUserModel = new \App\Models\ActiviteUserModel();
        $activites = $activiteUserModel->select('activite_sportive.*')
                                       ->join('activite_sportive', 'activite_sportive.id_activite = activite_user.id_activite')
                                       ->where('activite_user.id_selection', $selection['id_selection'])
                                       ->findAll();

        $infoUserModel = new \App\Models\InfoUserModel();
        $infoUser = $infoUserModel->where('id_user', $user['id'])->first();

        $data = [
            'title' => 'Votre Programme',
            'selection' => $selection,
            'regimes' => $regimes,
            'activites' => $activites,
            'infoUser' => $infoUser
        ];

        return view('regime', $data);
    }
}