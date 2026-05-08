<?php

namespace App\Controllers;

use App\Models\UserModel;

class GestionUser extends BaseController{
    public function index(){
        $data = [
            'title' => 'Login',
        ];

        return view('login', $data);
    }

    public function inscription()
    {
        $data = [
            'title' => 'Inscription',
        ];

        return view('inscription', $data);
    }

    public function authentifier(){
        $userModel = new UserModel();
        $contentType = strtolower($this->request->getHeaderLine('Content-Type'));
        $payload = str_contains($contentType, 'application/json')
            ? $this->request->getJSON(true)
            : null;
        $isAjax = $this->request->isAJAX();
        $nom = is_array($payload) ? (string) ($payload['email'] ?? '') : (string) $this->request->getPost('email');
        $mot_de_passe = is_array($payload) ? (string) ($payload['password'] ?? '') : (string) $this->request->getPost('password');

        if ($nom === '' || $mot_de_passe === '') {
            if ($isAjax) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON(['success' => false, 'message' => 'Email et mot de passe requis.']);
            }

            return redirect()->back()->withInput()->with('error', 'Email et mot de passe requis.');
        }

        $user = $userModel->where('email', $nom)->first();

        if ($user && password_verify($mot_de_passe, $user['password'])) {
            session()->set('user', [
                'id' => $user['id_user'],
                'nom' => $user['nom'],
                'email' => $user['email'],
                'id_statut' => $user['id_statut']
            ]);

            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Connexion reussie.',
                    'redirect' => '/home',
                ]);
            }

            return redirect()->to('/home')->with('success', 'Connexion réussie');
        } else {
            if ($isAjax) {
                return $this->response
                    ->setStatusCode(401)
                    ->setJSON(['success' => false, 'message' => 'Email ou mot de passe incorrect.']);
            }

            return redirect()->back()->withInput()->with('error', 'Email ou mot de passe incorrect');
        }
    }

    public function inscrire()
    {
        $contentType = strtolower($this->request->getHeaderLine('Content-Type'));
        $payload = str_contains($contentType, 'application/json')
            ? $this->request->getJSON(true)
            : null;
        $isAjax = $this->request->isAJAX();
        $email = is_array($payload) ? (string) ($payload['email'] ?? '') : (string) $this->request->getPost('email');
        $password = is_array($payload) ? (string) ($payload['password'] ?? '') : (string) $this->request->getPost('password');
        $genre = is_array($payload) ? (string) ($payload['genre'] ?? '') : (string) $this->request->getPost('genre');

        if ($email === '' || $password === '' || $genre === '') {
            if ($isAjax) {
                return $this->response
                    ->setStatusCode(400)
                    ->setJSON(['success' => false, 'message' => 'Tous les champs sont obligatoires.']);
            }

            return redirect()->back()->withInput()->with('error', 'Tous les champs sont obligatoires.');
        }

        if ($isAjax) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Inscription enregistree.',
                'redirect' => '/',
            ]);
        }

        return redirect()->to('/')->with('success', 'Inscription enregistree.');
    }
}
