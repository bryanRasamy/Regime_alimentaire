<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'GestionUser::index');
$routes->post('login/authentifier', 'GestionUser::authentifier');

$routes->get('inscription', 'GestionUser::inscription');
$routes->post('inscription/user/add', 'GestionUser::ajouterUser');
$routes->get('inscription/user/info', 'GestionUser::information');
$routes->post('inscription/user/info/add', 'GestionUser::ajouterInformation');
