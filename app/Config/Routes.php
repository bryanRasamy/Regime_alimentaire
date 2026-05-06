<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'GestionUser::index');
$routes->post('login/authentifier', 'GestionUser::authentifier');
$routes->get('register', 'GestionUser::inscription');
$routes->post('register/store', 'GestionUser::inscrire');
