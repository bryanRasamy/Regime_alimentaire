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

$routes->group('back-office', ['filter' => ['auth', 'role:2']], function($routes) {
    $routes->get('dashboard', 'BackOffice::dashboard');
    $routes->get('dashboard/export/csv', 'BackOffice::exportDashboardCsv');
    $routes->get('dashboard/export/pdf', 'BackOffice::exportDashboardPdf');
    $routes->get('regimes', 'BackOffice::regimes');
    $routes->get('regimes/create', 'BackOffice::createRegime');
    $routes->post('regimes', 'BackOffice::storeRegime');
    $routes->get('regimes/(:num)/edit', 'BackOffice::editRegime/$1');
    $routes->post('regimes/(:num)', 'BackOffice::updateRegime/$1');
    $routes->post('regimes/(:num)/delete', 'BackOffice::deleteRegime/$1');
    $routes->get('activites', 'BackOffice::activites');
    $routes->get('activites/create', 'BackOffice::createActivite');
    $routes->post('activites', 'BackOffice::storeActivite');
    $routes->get('activites/(:num)/edit', 'BackOffice::editActivite/$1');
    $routes->post('activites/(:num)', 'BackOffice::updateActivite/$1');
    $routes->post('activites/(:num)/delete', 'BackOffice::deleteActivite/$1');
    $routes->get('codes', 'BackOffice::codes');
    $routes->get('codes/create', 'BackOffice::createCode');
    $routes->post('codes', 'BackOffice::storeCode');
    $routes->get('codes/(:num)/edit', 'BackOffice::editCode/$1');
    $routes->post('codes/(:num)', 'BackOffice::updateCode/$1');
    $routes->post('codes/(:num)/delete', 'BackOffice::deleteCode/$1');
});