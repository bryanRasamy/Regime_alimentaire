<?php

namespace App\Controllers;

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

        if ($objectif === '' || !in_array($objectif, $allowedObjectives, true) || $objectifValue === '' || !is_numeric($objectifValue) || (float) $objectifValue <= 0) {
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
                'redirect' => '/regime',
            ]);
        }

        return redirect()->to('/regime')->with('success', 'Objectif enregistré avec succès.');
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

        // Récupère l'objectif depuis la session
        $objectif = session()->get('objectif');
        if (!$objectif || !isset($objectif['type'], $objectif['valeur'])) {
            $errorMsg = 'Aucun objectif trouvé.';
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => $errorMsg]);
            }
            return redirect()->to('/regime/objectif')->with('error', $errorMsg);
        }

        // Récupère les infos utilisateur (poids, taille)
        $db = 
            \Config\Database::connect();
        $info = $db->table('info_user')->where('id_user', $user['id'])->orderBy('id_info', 'DESC')->get()->getRowArray();
        if (!$info) {
            $errorMsg = 'Informations utilisateur manquantes (poids/taille).';
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => $errorMsg]);
            }
            return redirect()->to('/inscription/user/info')->with('error', $errorMsg);
        }

        $currentPoids = (float) $info['poids'];
        $taille = (float) $info['taille'];

        // Calcule la cible en kg selon le type d'objectif
        $type = $objectif['type'];
        $val = (float) $objectif['valeur'];

        if ($type === 'imc_ideale') {
            $targetWeight = $val * ($taille * $taille); // IMC cible -> poids cible
            $diffKg = abs($currentPoids - $targetWeight);
            $desiredSign = $currentPoids > $targetWeight ? 'reduce' : 'increase';
        } else {
            $diffKg = abs($val);
            $desiredSign = ($type === 'reduire_poids') ? 'reduce' : 'increase';
        }

        if ($diffKg <= 0) {
            if ($isAjax) {
                return $this->response->setJSON(['success' => false, 'message' => 'Aucun écart à combler.']);
            }
            return redirect()->to('/home')->with('error', 'Aucun écart à combler.');
        }

        // Precision x100 : on travaille en entier
        $mult = 100;
        $target = (int) round($diffKg * $mult);

        // Récupère les regimes pertinents (filtrer par signe de variation_poids)
        $regimes = $db->table('regime')->get()->getResultArray();
        $items = [];
        foreach ($regimes as $r) {
            $var = (float) $r['variation_poids'];
            if ($desiredSign === 'reduce' && $var >= 0) continue;
            if ($desiredSign === 'increase' && $var <= 0) continue;
            $w = (int) round(abs($var) * $mult);
            if ($w <= 0) continue;
            $items[] = ['id' => $r['id_regime'], 'weight' => $w, 'duree' => (int)$r['duree_jours']];
        }

        if (empty($items)) {
            $errorMsg = 'Aucun régime disponible pour cet objectif.';
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => $errorMsg]);
            }
            return redirect()->back()->with('error', $errorMsg);
        }

        // DP subset-sum 0/1 (pas de répétition)
        $n = count($items);
        $dp = array_fill(0, $target + 1, false);
        $choice = array_fill(0, $target + 1, null);
        $prev = array_fill(0, $target + 1, -1);
        $dp[0] = true;
        for ($i = 0; $i < $n; $i++) {
            $w = $items[$i]['weight'];
            for ($s = $target; $s >= $w; $s--) {
                if (!$dp[$s] && $dp[$s - $w]) {
                    $dp[$s] = true;
                    $choice[$s] = $i;
                    $prev[$s] = $s - $w;
                }
            }
        }

        // Cherche la somme la plus proche <= target
        $best = -1;
        for ($s = $target; $s >= 0; $s--) {
            if ($dp[$s]) { $best = $s; break; }
        }

        if ($best <= 0) {
            $errorMsg = 'Impossible de combiner des régimes pour atteindre l objectif.';
            if ($isAjax) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => $errorMsg]);
            }
            return redirect()->back()->with('error', $errorMsg);
        }

        // Reconstruction
        $s = $best;
        $selectedIdx = [];
        while ($s > 0) {
            $i = $choice[$s];
            if ($i === null) break;
            $selectedIdx[] = $i;
            $s = $prev[$s];
        }

        // Crée une selection en base
        $db->table('regime_selection')->insert([
            'id_user' => $user['id'],
            'objectif' => $type,
            'valeur_target' => $diffKg,
            'somme_obtenue' => ($best / $mult)
        ]);
        $id_selection = $db->insertID();

        // Enregistre chaque regime dans regime_user
        $today = date('Y-m-d');
        foreach ($selectedIdx as $idx) {
            $reg = $items[$idx];
            $regimeRow = $db->table('regime')->where('id_regime', $reg['id'])->get()->getRowArray();
            $date_fin = null;
            if ($regimeRow && isset($regimeRow['duree_jours'])) {
                $d = (int)$regimeRow['duree_jours'];
                $date_fin = date('Y-m-d', strtotime("+$d days"));
            }
            $db->table('regime_user')->insert([
                'id_regime' => $reg['id'],
                'id_user' => $user['id'],
                'id_selection' => $id_selection,
                'date_debut' => $today,
                'date_fin' => $date_fin
            ]);
        }

        if ($isAjax) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Régime calculé et sauvegardé.',
                'selection_id' => $id_selection,
            ]);
        }

        return redirect()->to('/regime')->with('success', 'Régime calculé et sauvegardé.');
    }
}