<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'GestionUser::index');
$routes->post('login/authentifier', 'GestionUser::authentifier');
$routes->get('inscription', 'GestionUser::inscription');
$routes->post('inscription/store', 'GestionUser::inscrire');
