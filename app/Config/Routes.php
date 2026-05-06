<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('login', 'GestionUser::index');
$routes->post('login/authentifier', 'GestionUser::authentifier');
$routes->get('login/inscription', 'GestionUser::ajouter');
$routes->post('login/inscription/enregistrer', 'GestionUser::enregistrer');
$routes->get('logout', 'GestionUser::logout');
$routes->get('livre/catalogue', 'GestionLivre::index');
$routes->get('livre/catalogue/export', 'GestionLivre::exportCatalogue');
$routes->get('livre/detail/(:num)', 'GestionLivre::detail/$1');

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('profil', 'GestionUser::profil');
    $routes->post('livre/catalogue/commentaire/(:num)', 'GestionLivre::ajouterCommentaire/$1');
    $routes->post('livre/reservation/(:num)', 'MouvementLivre::reserver/$1');
});


$routes->group('', ['filter' => 'role:admin,bibliothecaire'], function($routes) {
    $routes->get('tableau-bord', 'GestionLivre::tableauBord');
    $routes->get('livre/add', 'GestionLivre::ajouter');
    $routes->get('livre/retards', 'GestionLivre::listeRetards');
    $routes->get('livre/reservations', 'GestionLivre::listeReservations');
    $routes->get('livre/historique-emprunts', 'GestionLivre::historiqueComplet');
    $routes->post('livre/save','GestionLivre::store');
    $routes->post('livre/delete/(:num)','GestionLivre::supprimer/$1');
    $routes->post('livre/emprunter/(:num)', 'MouvementLivre::pret/$1');
    $routes->post('livre/retour/(:num)', 'MouvementLivre::retour/$1');
});


