<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\InfoUserModel;
use App\Models\RegimeSelection;


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
}
