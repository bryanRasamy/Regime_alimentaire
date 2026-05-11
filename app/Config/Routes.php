<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'GestionUser::index');
$routes->post('login/authentifier', 'GestionUser::authentifier');
$routes->get('logout', 'GestionUser::deconnexion');
$routes->get('inscription', 'GestionUser::inscription');
$routes->post('inscription/user/add', 'GestionUser::ajouterUser');
$routes->get('inscription/user/info', 'GestionUser::information');
$routes->post('inscription/user/info/add', 'GestionUser::ajouterInformation');


$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('regime/objectif', 'GestionRegime::objectif');
    $routes->post('regime/objectif/add', 'GestionRegime::sauvegarderObjectif');
    $routes->get('regime/calculer', 'GestionRegime::calculerRegime');
    $routes->get('regime', 'GestionRegime::afficherRegime');
    $routes->get('profil', 'GestionUser::profil');
    $routes->post('profil/recharger', 'GestionUser::rechargerPorteMonnaie');
    $routes->post('profil/acheter-gold', 'GestionUser::acheterOptionGold');
    $routes->get('regime/export/pdf', 'GestionRegime::exporterPdf');
});