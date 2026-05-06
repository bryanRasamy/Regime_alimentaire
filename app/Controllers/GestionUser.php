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

    public function authentifier(){
        $userModel = new UserModel();
        $nom = $this->request->getPost('nom');
        $mot_de_passe = $this->request->getPost('password');

        $user = $userModel->where('nom', $nom)->first();

        if ($user && password_verify($mot_de_passe, $user['password'])) {
            session()->set('user', [
                'id' => $user['id_user'],
                'nom' => $user['nom'],
                'email' => $user['email'],
                'id_statut' => $user['id_statut']
            ]);

            return redirect()->to('/home')->with('success', 'Connexion réussie');
        } else {
            return redirect()->back()->withInput()->with('error', 'nom ou mot de passe incorrect');
        }
    }
}