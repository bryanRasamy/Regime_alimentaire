<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\InfoUserModel;
use App\Models\CodeModel;
use App\Models\CodeUserModel;


class GestionUser extends BaseController{
    public function index(){
        $data = [
            'title' => 'Login',
        ];

        return view('login', $data);
    }

    public function inscription(){
        $data = [
            'title' => 'Inscription',
        ];

        return view('inscription', $data);
    }

    public function authentifier(){
        $userModel = new UserModel();
        $isAjax = $this->request->isAJAX();

        $email = $this->request->getVar('email');
        $mot_de_passe = $this->request->getVar('password');

        if (empty($email) || empty($mot_de_passe)) {
            $errorMsg = 'Email et mot de passe requis.';
            if ($isAjax) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON(['success' => false, 'message' => $errorMsg]);
            }
            return redirect()->back()->withInput()->with('error', $errorMsg);
        }

        $user = $userModel->where('email', $email)->first();

        $isPasswordValid = false;
        if ($user) {
            if (password_verify($mot_de_passe, $user['password'])) {
                $isPasswordValid = true;
            } else if ($mot_de_passe === $user['password']) {
                $isPasswordValid = true;
            }
        }

        if ($isPasswordValid) {
            session()->set('user', [
                'id'   => $user['id_user'],
                'nom'       => $user['nom'],
                'email'     => $user['email'],
                'id_statut' => $user['id_statut']
            ]);

            if ($isAjax) {
                return $this->response->setJSON([
                    'success'  => true,
                    'message'  => 'Connexion réussie.',
                    'redirect' => 'regime',
                ]);
            }

            return redirect()->to('regime')->with('success', 'Connexion réussie.');
        }

        $errorMsg = 'Email ou mot de passe incorrect.';
        if ($isAjax) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON(['success' => false, 'message' => $errorMsg]);
        }

        return redirect()->back()->withInput()->with('error', $errorMsg);
    }

    public function ajouterUser(){
        $userModel = new UserModel();
        $isAjax = $this->request->isAJAX();

        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        $userData = [
            'nom'       => $data['name'],
            'email'     => $data['email'],
            'password'  => $data['password'],
            'id_statut' => $data['id_statut'] ?? 1,
            'porte_monnaie' => $data['porte_monnaie'] ?? 1000.00,
            'option_gold' => $data['option_gold'] ?? 0.00
        ];

        if (!$userModel->validate($userData)) {
            $errors = implode(', ', $userModel->errors());
            
            if ($isAjax) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON(['success' => false, 'message' => $errors]);
            }
            return redirect()->back()->withInput()->with('error', $errors);
        }


        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        
        $userModel->insert($userData);

        $id=$userModel->getInsertID();

        $user = $userModel->find($id);

        session()->set('user', [
                'id'        => $user['id_user'],
                'nom'       => $user['nom'],
                'email'     => $user['email'],
                'id_statut' => $user['id_statut'],
                'porte_monnaie' => $user['porte_monnaie'],
                'option_gold' => $user['option_gold']
            ]);

        if ($isAjax) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Compte créé.',
                'redirect' => '/inscription/user/info',
            ]);
        }

        return redirect()->to('/inscription/user/info')->with('success', 'Compte créé.');
    }

    public function information(){
        $data = [
            'title' => 'Informations Utilisateur',
        ];

        return view('information', $data);
    }

    public function ajouterInformation(){
        $infoUserModel = new InfoUserModel();
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

        $poids = $data['poids'];
        $taille = $data['taille'];
        $IMC = $poids/($taille * $taille);

        $infoUserData = [
            'id_user'   => $user['id'],
            'genre'     => $data['genre'],
            'taille'    => $taille,
            'poids'     => $poids,
            'IMC'       => $IMC
        ];

        if (!$infoUserModel->validate($infoUserData)) {
            $errors = implode(', ', $infoUserModel->errors());
            
            if ($isAjax) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON(['success' => false, 'message' => $errors]);
            }
            return redirect()->back()->withInput()->with('error', $errors);
        }

        $infoUserModel->insert($infoUserData);

        if ($isAjax) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Informations enregistrées avec succès.',
                'redirect' => '/regime/objectif',
            ]);
        }

        return redirect()->to('/regime/objectif')->with('success', 'Informations enregistrées avec succès.');
    }

    public function deconnexion(){
        session()->destroy();
        return redirect()->to('/')->with('success', 'Déconnexion réussie.');
    }


    public function profil(){
        $user = session()->get('user');
        if (!$user || !isset($user['id'])) {
            return redirect()->to('/')->with('error', 'Session expirée.');
        }

        $userModel = new UserModel();
        $userData = $userModel->find($user['id']);

        session()->set('user', array_merge($user, ['porte_monnaie' => $userData['porte_monnaie']]));

        $data = [
            'title' => 'Mon Profil',
            'userData' => $userData
        ];

        return view('profil', $data);
    }

    public function rechargerPorteMonnaie(){
        $user = session()->get('user');
        if (!$user || !isset($user['id'])) {
            return redirect()->to('/')->with('error', 'Session expirée.');
        }

        $codeText = $this->request->getPost('code');
        if (empty($codeText)) {
            return redirect()->back()->with('error', 'Veuillez entrer un code.');
        }

        $codeModel = new CodeModel();
        $code = $codeModel->where('libelle', $codeText)->first();

        if (!$code) {
            return redirect()->back()->with('error', 'Code invalide.');
        }

        if (isset($code['date_expiration']) && !empty($code['date_expiration']) && $code['date_expiration'] < date('Y-m-d')) {
            return redirect()->back()->with('error', 'Ce code est expiré.');
        }

        $codeUserModel = new CodeUserModel();
        $dejaUtilise = $codeUserModel->where('id_code', $code['id_code'])
                                     ->where('id_user', $user['id'])
                                     ->first();

        if ($dejaUtilise) {
            return redirect()->back()->with('error', 'Vous avez déjà utilisé ce code.');
        }

        $userModel = new UserModel();
        $dbUser = $userModel->find($user['id']);
        $newSolde = $dbUser['porte_monnaie'] + $code['montant'];

        $userModel->update($user['id'], ['porte_monnaie' => $newSolde]);

        
        $codeUserModel->insert([
            'id_code' => $code['id_code'],
            'id_user' => $user['id'],
            'date' => date('Y-m-d')
        ]);

        session()->set('user', array_merge($user, ['porte_monnaie' => $newSolde]));

        return redirect()->back()->with('success', 'Code validé ! ' . $code['montant'] . ' Ar ajoutés à votre porte-monnaie.');
    }


    public function acheterOptionGold(){
        $user = session()->get('user');
        if (!$user || !isset($user['id'])) {
            return redirect()->to('/')->with('error', 'Session expirée.');
        }

        $userModel = new UserModel();
        $dbUser = $userModel->find($user['id']);

        if ($dbUser['option_gold'] > 0) {
            return redirect()->back()->with('error', 'Vous possédez déjà l\'option Gold.');
        }

        $prixGold = 20000;
        $pourcentageRemise = 15; 

        if ($dbUser['porte_monnaie'] < $prixGold) {
            return redirect()->back()->with('error', 'Solde insuffisant pour acheter l\'option Gold (Prix : ' . number_format($prixGold, 2, ',', ' ') . ' Ar). Veuillez recharger votre porte-monnaie.');
        }

        
        $nouveauSolde = $dbUser['porte_monnaie'] - $prixGold;

        
        $userModel->update($user['id'], [
            'porte_monnaie' => $nouveauSolde,
            'option_gold' => $pourcentageRemise
        ]);

        session()->set('user', array_merge($user, [
            'porte_monnaie' => $nouveauSolde,
            'option_gold' => $pourcentageRemise
        ]));

        return redirect()->back()->with('success', 'Félicitations ! Vous avez acquis l\'option Gold et bénéficiez de -' . $pourcentageRemise . '% sur tous vos programmes !');
    }
}
