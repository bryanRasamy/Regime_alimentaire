<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', static fn () => redirect()->to(base_url('login')));

$routes->view('login', 'login', ['title' => 'Connexion']);

$routes->match(['get', 'post'], 'login/auth', static fn () => redirect()->to(base_url('login')));

$routes->get('logout', static fn () => redirect()->to(base_url('login')));
