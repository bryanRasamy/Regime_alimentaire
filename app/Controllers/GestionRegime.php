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

    private function normalizePdfText($text) {
        return iconv('UTF-8', 'windows-1252', $text);
    }

    public function exporterPdf() {
        $user = session()->get('user');

        if (!$user || !isset($user['id'])) {
            return redirect()->to('/')->with('error', 'Session expirée.');
        }

        $selectionModel = new \App\Models\RegimeSelection();
        $selection = $selectionModel->where('id_user', $user['id'])
                                    ->orderBy('id_selection', 'DESC')
                                    ->first();

        if (!$selection) {
            return redirect()->to('/regime/objectif')->with('error', 'Aucun programme n\'est défini.');
        }

        $regimeUserModel = new \App\Models\RegimeUserModel();
        $regimes = $regimeUserModel->select('regime.*')
                                   ->join('regime', 'regime.id_regime = regime_user.id_regime')
                                   ->where('regime_user.id_selection', $selection['id_selection'])
                                   ->findAll();

        $activiteUserModel = new \App\Models\ActiviteUserModel();
        $activites = $activiteUserModel->select('activite_sportive.*')
                                       ->join('activite_sportive', 'activite_sportive.id_activite = activite_user.id_activite')
                                       ->where('activite_user.id_selection', $selection['id_selection'])
                                       ->findAll();

        if (!class_exists('FPDF')) {
            require_once APPPATH . 'ThirdParty/fpdf186/fpdf.php';
        }

        $pdf = new \FPDF();
        $pdf->AddPage();
        
        // Titre
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, $this->normalizePdfText('Votre Programme Personnalisé'), 0, 1, 'C');
        $pdf->Ln(5);

        // Informations Objectifs
        $pdf->SetFont('Arial', '', 11);
        $objectif = $selection['objectif'] === 'augmenter_poids' ? 'Prendre du poids' : 
                   ($selection['objectif'] === 'reduire_poids' ? 'Perdre du poids' : 'Atteindre un IMC idéal');
        $pdf->Cell(0, 8, $this->normalizePdfText('Objectif : ' . $objectif), 0, 1);
        $pdf->Cell(0, 8, $this->normalizePdfText('Variation ciblée : ' . $selection['valeur_cible'] . ' kg'), 0, 1);
        $pdf->Cell(0, 8, $this->normalizePdfText('Variation atteinte : ' . $selection['somme_obtenue'] . ' kg'), 0, 1);
        $pdf->Ln(5);

        // Section Régimes
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, $this->normalizePdfText('Vos Régimes Alimentaires'), 0, 1);
        $pdf->Ln(2);

        if (!empty($regimes)) {
            $headerR = ['Nom', 'Duree (jours)', 'Var. Poids (kg)', 'Viande', 'Poisson', 'Volaille', 'Prix (Ar)'];
            $widthsR = [45, 25, 30, 20, 20, 20, 30];
            
            $pdf->SetFont('Arial', 'B', 10);
            for ($i = 0; $i < count($headerR); $i++) {
                $pdf->Cell($widthsR[$i], 7, $this->normalizePdfText($headerR[$i]), 1, 0, 'C');
            }
            $pdf->Ln();

            $pdf->SetFont('Arial', '', 9);
            foreach ($regimes as $regime) {
                $pdf->Cell($widthsR[0], 7, $this->normalizePdfText($regime['nom']), 1);
                $pdf->Cell($widthsR[1], 7, $this->normalizePdfText($regime['duree_jours']), 1, 0, 'C');
                $pdf->Cell($widthsR[2], 7, $this->normalizePdfText($regime['variation_poids']), 1, 0, 'C');
                $pdf->Cell($widthsR[3], 7, $this->normalizePdfText(($regime['viande'] * 100) . '%'), 1, 0, 'C');
                $pdf->Cell($widthsR[4], 7, $this->normalizePdfText(($regime['poisson'] * 100) . '%'), 1, 0, 'C');
                $pdf->Cell($widthsR[5], 7, $this->normalizePdfText(($regime['volaille'] * 100) . '%'), 1, 0, 'C');
                $pdf->Cell($widthsR[6], 7, $this->normalizePdfText($regime['prix']), 1, 0, 'R');
                $pdf->Ln();
            }
        } else {
            $pdf->SetFont('Arial', 'I', 10);
            $pdf->Cell(0, 10, $this->normalizePdfText('Aucun régime alimentaire.'), 0, 1);
        }
        
        $pdf->Ln(10);

        // Section Activités Sportives
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, $this->normalizePdfText('Vos Activités Sportives'), 0, 1);
        $pdf->Ln(2);

        if (!empty($activites)) {
            $headerA = ['Description', 'Duree (jours)', 'Var. Poids (kg)'];
            $widthsA = [110, 40, 40];
            
            $pdf->SetFont('Arial', 'B', 10);
            for ($i = 0; $i < count($headerA); $i++) {
                $pdf->Cell($widthsA[$i], 7, $this->normalizePdfText($headerA[$i]), 1, 0, 'C');
            }
            $pdf->Ln();

            $pdf->SetFont('Arial', '', 9);
            foreach ($activites as $activite) {
                $pdf->Cell($widthsA[0], 7, $this->normalizePdfText($activite['description']), 1);
                $pdf->Cell($widthsA[1], 7, $this->normalizePdfText($activite['duree_jours'] ?? 0), 1, 0, 'C');
                $pdf->Cell($widthsA[2], 7, $this->normalizePdfText($activite['variation_poids'] ?? 0), 1, 0, 'C');
                $pdf->Ln();
            }
        } else {
            $pdf->SetFont('Arial', 'I', 10);
            $pdf->Cell(0, 10, $this->normalizePdfText('Aucune activité sportive.'), 0, 1);
        }

        $content = $pdf->Output('S');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="programme_personnalise.pdf"')
            ->setBody($content);
    }
}