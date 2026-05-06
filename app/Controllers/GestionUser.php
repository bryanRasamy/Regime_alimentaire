<?php

namespace App\Controllers;

class GestionUser extends BaseController{
    public function index(){
        $data = [
            'title' => 'Login',
        ];

        return view('login', $data);
    }
}